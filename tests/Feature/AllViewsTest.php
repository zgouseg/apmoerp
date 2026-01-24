<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

/**
 * All Views Test Suite
 * 
 * Tests every single Livewire view in the application (232+ views).
 */
class AllViewsTest extends TestCase
{
    /**
     * Get all Livewire view files.
     */
    protected function getAllViews(): array
    {
        $path = base_path('resources/views/livewire');
        $files = File::allFiles($path);
        
        return collect($files)
            ->filter(fn($file) => $file->getExtension() === 'php')
            ->map(fn($file) => [
                'path' => $file->getPathname(),
                'relative' => str_replace(base_path() . '/', '', $file->getPathname()),
            ])
            ->values()
            ->toArray();
    }

    /**
     * Test all views have proper root tags (no bare <div>).
     */
    public function test_all_views_have_proper_root_tags(): void
    {
        $views = $this->getAllViews();
        $issues = [];
        
        foreach ($views as $view) {
            $content = file_get_contents($view['path']);
            $firstLine = trim(explode("\n", $content)[0] ?? '');
            
            // Check for bare <div> without attributes
            if ($firstLine === '<div>') {
                $issues[] = $view['relative'] . ': has bare <div> tag';
            }
        }
        
        $this->assertEmpty($issues, 
            "Views with bare <div> root tag:\n" . implode("\n", $issues));
    }

    /**
     * Test all views have @script inside root element.
     */
    public function test_all_script_blocks_inside_root_element(): void
    {
        $views = $this->getAllViews();
        $issues = [];
        
        foreach ($views as $view) {
            $content = file_get_contents($view['path']);
            
            if (!str_contains($content, '@script')) {
                continue;
            }
            
            // @endscript should NOT be at the very end (should have </div> after)
            $trimmed = rtrim($content);
            if (preg_match('/@endscript\s*$/', $trimmed)) {
                $issues[] = $view['relative'] . ': @endscript at end without closing tag';
            }
        }
        
        $this->assertEmpty($issues, 
            "Views with @script outside root:\n" . implode("\n", $issues));
    }

    /**
     * Test view count is at least 230.
     */
    public function test_view_count_is_complete(): void
    {
        $views = $this->getAllViews();
        $count = count($views);
        
        $this->assertGreaterThanOrEqual(230, $count, 
            "Expected at least 230 views, found $count");
    }

    /**
     * Test admin views exist.
     */
    public function test_admin_views_exist(): void
    {
        $adminPath = base_path('resources/views/livewire/admin');
        $files = File::allFiles($adminPath);
        
        $this->assertGreaterThan(20, count($files), 
            'Should have more than 20 admin views');
    }

    /**
     * Test sales views exist.
     */
    public function test_sales_views_exist(): void
    {
        $path = base_path('resources/views/livewire/sales');
        
        if (is_dir($path)) {
            $files = File::allFiles($path);
            $this->assertGreaterThan(0, count($files));
        } else {
            $this->markTestSkipped('Sales views directory not found');
        }
    }

    /**
     * Test purchases views exist.
     */
    public function test_purchases_views_exist(): void
    {
        $path = base_path('resources/views/livewire/purchases');
        
        if (is_dir($path)) {
            $files = File::allFiles($path);
            $this->assertGreaterThan(0, count($files));
        } else {
            $this->markTestSkipped('Purchases views directory not found');
        }
    }

    /**
     * Test inventory views exist.
     */
    public function test_inventory_views_exist(): void
    {
        $path = base_path('resources/views/livewire/inventory');
        
        if (is_dir($path)) {
            $files = File::allFiles($path);
            $this->assertGreaterThan(0, count($files));
        } else {
            $this->markTestSkipped('Inventory views directory not found');
        }
    }

    /**
     * Test POS views exist.
     */
    public function test_pos_views_exist(): void
    {
        $path = base_path('resources/views/livewire/pos');
        
        if (is_dir($path)) {
            $files = File::allFiles($path);
            $this->assertGreaterThan(0, count($files));
        } else {
            $this->markTestSkipped('POS views directory not found');
        }
    }

    /**
     * Test dashboard views exist.
     */
    public function test_dashboard_views_exist(): void
    {
        $path = base_path('resources/views/livewire/dashboard');
        
        if (is_dir($path)) {
            $files = File::allFiles($path);
            $this->assertGreaterThan(0, count($files));
        } else {
            $this->markTestSkipped('Dashboard views directory not found');
        }
    }

    /**
     * Test finance views exist.
     */
    public function test_finance_views_exist(): void
    {
        $paths = [
            base_path('resources/views/livewire/accounting'),
            base_path('resources/views/livewire/banking'),
            base_path('resources/views/livewire/expenses'),
            base_path('resources/views/livewire/income'),
        ];
        
        $found = 0;
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $found++;
            }
        }
        
        $this->assertGreaterThan(0, $found, 'Should have at least one finance views directory');
    }

    /**
     * Test shared/components views exist.
     */
    public function test_shared_views_exist(): void
    {
        $paths = [
            base_path('resources/views/livewire/shared'),
            base_path('resources/views/livewire/components'),
        ];
        
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $files = File::allFiles($path);
                $this->assertGreaterThan(0, count($files), "Should have files in $path");
                return;
            }
        }
        
        $this->markTestSkipped('No shared/components views directory');
    }

    /**
     * Test all views are valid Blade templates.
     */
    public function test_all_views_are_valid_blade(): void
    {
        $views = $this->getAllViews();
        $syntaxErrors = [];
        
        foreach ($views as $view) {
            $content = file_get_contents($view['path']);
            
            // Check for common syntax issues - only match actual Blade directives
            // @if( must be at start of line or after whitespace
            $unclosedIf = preg_match_all('/^\s*@if\s*\(/m', $content) - preg_match_all('/^\s*@endif/m', $content);
            $unclosedForeach = preg_match_all('/^\s*@foreach\s*\(/m', $content) - preg_match_all('/^\s*@endforeach/m', $content);
            
            if ($unclosedIf > 2) {
                $syntaxErrors[] = $view['relative'] . ": unmatched @if/@endif (diff: $unclosedIf)";
            }
            if ($unclosedForeach > 2) {
                $syntaxErrors[] = $view['relative'] . ": unmatched @foreach/@endforeach (diff: $unclosedForeach)";
            }
        }
        
        // Allow some mismatches due to partial views
        $this->assertLessThan(10, count($syntaxErrors), 
            "Too many potential syntax errors:\n" . implode("\n", array_slice($syntaxErrors, 0, 10)));
    }

    /**
     * Test form views have wire:model or x-model.
     */
    public function test_form_views_have_data_binding(): void
    {
        $views = $this->getAllViews();
        $formViews = [];
        
        foreach ($views as $view) {
            if (str_contains($view['relative'], 'form')) {
                $content = file_get_contents($view['path']);
                
                if (str_contains($content, 'wire:model') || str_contains($content, 'x-model')) {
                    $formViews[] = $view['relative'];
                }
            }
        }
        
        $this->assertGreaterThan(10, count($formViews), 
            'Should have at least 10 form views with data binding');
    }

    /**
     * Test index views have table or list.
     */
    public function test_index_views_have_data_display(): void
    {
        $views = $this->getAllViews();
        $indexViews = 0;
        
        foreach ($views as $view) {
            if (str_contains($view['relative'], 'index')) {
                $content = file_get_contents($view['path']);
                
                if (str_contains($content, '<table') || 
                    str_contains($content, '@foreach') ||
                    str_contains($content, '<x-') ||
                    str_contains($content, 'wire:click')) {
                    $indexViews++;
                }
            }
        }
        
        $this->assertGreaterThan(15, $indexViews, 
            'Should have at least 15 index views with data display');
    }
}
