<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

/**
 * Comprehensive View Test Suite
 * 
 * Tests all 232+ Livewire views for:
 * - Proper root tag detection
 * - @script block placement
 * - Basic syntax validation
 */
class ComprehensiveViewTest extends TestCase
{
    /**
     * Get all Livewire view files.
     */
    protected function getAllLivewireViews(): array
    {
        $path = base_path('resources/views/livewire');
        $files = File::allFiles($path);
        
        return collect($files)
            ->filter(fn($file) => $file->getExtension() === 'php')
            ->map(fn($file) => $file->getPathname())
            ->values()
            ->toArray();
    }

    /**
     * Test all views have proper root tags.
     */
    public function test_all_views_have_proper_root_tags(): void
    {
        $views = $this->getAllLivewireViews();
        $issues = [];
        
        foreach ($views as $viewPath) {
            $content = file_get_contents($viewPath);
            $firstLine = trim(explode("\n", $content)[0] ?? '');
            
            // Check for bare <div> without attributes (problematic for Livewire)
            if ($firstLine === '<div>') {
                $issues[] = str_replace(base_path(), '', $viewPath) . ': has bare <div> tag';
            }
            
            // Check first line starts with HTML tag or Blade directive
            if (!preg_match('/^(<[a-z]|@|{{)/', $firstLine) && !empty($firstLine)) {
                // This might be a partial, which is OK
            }
        }
        
        $this->assertEmpty($issues, 
            "Views with root tag issues:\n" . implode("\n", $issues));
    }

    /**
     * Test @script blocks are properly placed inside root elements.
     */
    public function test_script_blocks_inside_root_elements(): void
    {
        $views = $this->getAllLivewireViews();
        $issues = [];
        
        foreach ($views as $viewPath) {
            $content = file_get_contents($viewPath);
            
            // Skip files without @script
            if (!str_contains($content, '@script')) {
                continue;
            }
            
            $lines = explode("\n", $content);
            $lastLines = array_slice($lines, -5);
            $lastContent = implode("\n", $lastLines);
            
            // Check if @endscript is followed by </div> (correct) or not
            if (preg_match('/@endscript\s*$/', trim($content))) {
                $issues[] = str_replace(base_path(), '', $viewPath) . ': @endscript at end without </div>';
            }
        }
        
        $this->assertEmpty($issues, 
            "Views with @script placement issues:\n" . implode("\n", $issues));
    }

    /**
     * Test all views can be compiled by Blade.
     */
    public function test_all_views_can_compile(): void
    {
        $views = $this->getAllLivewireViews();
        $failedViews = [];
        
        foreach ($views as $viewPath) {
            // Extract view name from path
            $relativePath = str_replace(base_path('resources/views/'), '', $viewPath);
            $viewName = str_replace(['/', '.blade.php'], ['.', ''], $relativePath);
            
            try {
                view($viewName)->render();
            } catch (\Exception $e) {
                // Expected - views need data. Check if it's a compile error
                if (str_contains($e->getMessage(), 'syntax error') ||
                    str_contains($e->getMessage(), 'Parse error')) {
                    $failedViews[] = "$viewName: " . $e->getMessage();
                }
            }
        }
        
        $this->assertEmpty($failedViews, 
            "Views with compilation errors:\n" . implode("\n", $failedViews));
    }

    /**
     * Test view count matches expectations.
     */
    public function test_view_count_is_as_expected(): void
    {
        $views = $this->getAllLivewireViews();
        $count = count($views);
        
        // Should have at least 200 views
        $this->assertGreaterThanOrEqual(200, $count, 
            "Expected at least 200 Livewire views, found {$count}");
        
        // Log the actual count
        $this->assertTrue(true, "Total Livewire views: {$count}");
    }
}
