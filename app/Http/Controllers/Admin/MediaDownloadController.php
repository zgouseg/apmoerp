<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;

class MediaDownloadController extends Controller
{
    public function __invoke(Media $media, Request $request): Response
    {
        $user = $request->user();
        $canManageAll = $user?->can('media.manage-all') ?? false;

        abort_unless($user?->can('media.view'), 403, __('You do not have permission to view media files.'));

        $canBypassBranch = ! $user?->branch_id || $canManageAll;

        if (
            $user?->branch_id
            && $media->branch_id
            && $user->branch_id !== $media->branch_id
            && ! $canBypassBranch
        ) {
            abort(403, __('You do not have permission to access this file.'));
        }

        if (! $canManageAll && ! $user->can('media.view-others') && $media->user_id !== $user->id) {
            abort(403, __('You do not have permission to access this file.'));
        }

        $serveThumbnail = $request->boolean('thumbnail');
        $path = $serveThumbnail && $media->thumbnail_path ? $media->thumbnail_path : $media->file_path;

        $disk = Storage::disk($media->disk);

        abort_unless($disk->exists($path), 404, __('File not found.'));

        $filename = $serveThumbnail
            ? basename($path)
            : ($media->original_name ?: $media->name);

        // CRIT-002 FIX: Verify MIME type from actual file on storage instead of trusting DB
        $storedMimeType = $disk->mimeType($path);
        $dbMimeType = $media->mime_type ?? 'application/octet-stream';

        // Use the storage-detected MIME type, fallback to DB if detection fails
        $mimeType = $storedMimeType ?: $dbMimeType;

        // CRIT-002 FIX: Define safe MIME types that can be served inline
        $safeInlineMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'application/pdf',
        ];

        // CRIT-002 FIX: Use attachment disposition by default, only allow inline for safe types
        $isSafeForInline = in_array($mimeType, $safeInlineMimeTypes, true);
        $disposition = $isSafeForInline
            ? HeaderUtils::DISPOSITION_INLINE
            : HeaderUtils::DISPOSITION_ATTACHMENT;

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => HeaderUtils::makeDisposition(
                $disposition,
                $filename,
                preg_replace('/[^\x20-\x7E]/', '_', $filename) ?? 'file'
            ),
            // CRIT-002 FIX: Prevent MIME type sniffing attacks
            'X-Content-Type-Options' => 'nosniff',
        ];

        $stream = $disk->readStream($path);

        if ($stream === false) {
            abort(404, __('File not found.'));
        }

        return response()->stream(function () use ($stream): void {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, $headers);
    }
}
