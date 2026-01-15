<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Http\Middleware\Impersonate;
use App\Models\AuditLog;

/**
 * WriteAuditTrail Listener
 *
 * Writes audit log entries for domain events.
 *
 * V21-CRITICAL-05 Fix: Removed ShouldQueue interface.
 * In queue workers (production), auth() and request() are not available,
 * causing audit logs to be created with null user_id, ip, and user_agent.
 * Making this synchronous ensures proper context capture for compliance.
 *
 * SECURITY: Properly tracks impersonation context by recording both
 * the actual performer (performed_by_id) and the impersonated user (impersonating_as_id).
 */
class WriteAuditTrail
{
    public function handle(object $event): void
    {
        // Generic fallback writer for domain events.
        try {
            $req = request();
            $user = auth()->user();
            $userId = $user?->getKey();

            // SECURITY FIX: Track impersonation context
            // If impersonation is active, record both the actual performer and impersonated user
            $isImpersonating = Impersonate::isImpersonating();
            $performedById = $isImpersonating
                ? Impersonate::getActualPerformerId()
                : $userId;
            $impersonatingAsId = $isImpersonating
                ? Impersonate::getImpersonatedUserId()
                : null;

            // V21-HIGH-06 Fix: Capture branch_id for multi-branch audit filtering
            // Try to get branch_id from: 1) event subject, 2) user's branch, 3) request attribute
            $branchId = null;
            if (method_exists($event, 'getBranchId')) {
                $branchId = $event->getBranchId();
            } elseif (method_exists($event, 'subject') && $event->subject() && property_exists($event->subject(), 'branch_id')) {
                $branchId = $event->subject()->branch_id;
            } elseif ($user && property_exists($user, 'branch_id')) {
                $branchId = $user->branch_id;
            } elseif ($req) {
                $branchId = $req->attributes->get('branch_id') ?? $req->input('branch_id');
            }

            // Build meta array consistently
            $meta = [];
            if ($impersonatingAsId !== null) {
                $meta['impersonation_session'] = true;
            }
            // Allow events to provide additional meta
            if (method_exists($event, 'meta')) {
                $meta = array_merge($meta, (array) $event->meta());
            }

            AuditLog::create([
                'user_id' => $userId,
                'performed_by_id' => $performedById,
                'impersonating_as_id' => $impersonatingAsId,
                'branch_id' => $branchId, // V21-HIGH-06 Fix: Include branch_id
                'action' => class_basename($event),
                'subject_type' => method_exists($event, 'subjectType') ? $event->subjectType() : null,
                'subject_id' => method_exists($event, 'subjectId') ? $event->subjectId() : null,
                'ip' => $req?->ip(),
                'user_agent' => (string) $req?->userAgent(),
                'old_values' => method_exists($event, 'old') ? (array) $event->old() : [],
                'new_values' => method_exists($event, 'new') ? (array) $event->new() : [],
                'meta' => ! empty($meta) ? $meta : null,
            ]);
        } catch (\Throwable) {
            // swallow errors
        }
    }
}
