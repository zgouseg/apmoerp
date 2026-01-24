#!/usr/bin/env php
<?php

/**
 * Livewire Root Tag Validator
 * 
 * This script validates that all Livewire Blade views have a proper root HTML tag.
 * Livewire requires each component view to have a single root element.
 * 
 * Usage: php scripts/validate-livewire-views.php
 * 
 * Exit codes:
 *   0 - All views are valid
 *   1 - One or more views are missing root tags
 */

class LivewireViewValidator
{
    private $baseDir;
    private $viewsDir;
    private $errors = [];
    
    // ANSI color codes
    const COLOR_INFO = "\033[0;36m";
    const COLOR_SUCCESS = "\033[0;32m";
    const COLOR_ERROR = "\033[0;31m";
    const COLOR_RESET = "\033[0m";
    
    // Preview length for error messages
    const PREVIEW_LENGTH = 100;
    
    public function __construct()
    {
        $this->baseDir = dirname(__DIR__);
        $this->viewsDir = $this->baseDir . '/resources/views/livewire';
    }
    
    public function validate()
    {
        if (!is_dir($this->viewsDir)) {
            $this->error("Livewire views directory not found: {$this->viewsDir}");
            return false;
        }
        
        $this->info("Validating Livewire views in: {$this->viewsDir}\n");
        
        $files = $this->findBladeFiles($this->viewsDir);
        $this->info("Found " . count($files) . " Blade files to validate\n");
        
        $invalidFiles = [];
        
        foreach ($files as $file) {
            $result = $this->validateFile($file);
            if (!$result['valid']) {
                $invalidFiles[] = [
                    'file' => str_replace($this->baseDir . '/', '', $file),
                    'reason' => $result['reason']
                ];
            }
        }
        
        if (empty($invalidFiles)) {
            $this->success("\n✓ All " . count($files) . " Livewire views have proper root tags!");
            return true;
        } else {
            $this->error("\n✗ Found " . count($invalidFiles) . " files with missing or invalid root tags:\n");
            foreach ($invalidFiles as $invalid) {
                $this->error("  File: " . $invalid['file']);
                $this->error("  Issue: " . $invalid['reason']);
                $this->error("");
            }
            return false;
        }
    }
    
    private function validateFile($filePath)
    {
        $content = file_get_contents($filePath);
        
        // Remove Blade comments
        $content = preg_replace('/\{\{--.*?--\}\}/s', '', $content);
        
        // Remove @script sections for validation (they're allowed outside root)
        $contentWithoutScript = preg_replace('/@script\b.*?@endscript\b/s', '', $content);
        
        // Trim whitespace
        $contentWithoutScript = trim($contentWithoutScript);
        
        // Check if content is empty
        if (empty($contentWithoutScript)) {
            return [
                'valid' => false,
                'reason' => 'View file is empty or contains only comments'
            ];
        }
        
        // Check if content starts with an HTML opening tag
        if (!preg_match('/^<(\w+)([^>]*)>/', $contentWithoutScript, $openMatch)) {
            // Get preview to show what it starts with
            $preview = substr($contentWithoutScript, 0, self::PREVIEW_LENGTH);
            return [
                'valid' => false,
                'reason' => "Does not start with HTML tag. Starts with: " . $preview
            ];
        }
        
        $tagName = $openMatch[1];
        
        // Check for self-closing tags (which can't be root elements in Livewire)
        $fullOpenTag = $openMatch[0];
        if (substr(rtrim($fullOpenTag), -2) === '/>') {
            return [
                'valid' => false,
                'reason' => "Root element is self-closing <{$tagName} />. Livewire requires a non-self-closing root element."
            ];
        }
        
        // Check if content ends with the corresponding closing tag
        $pattern = '/<\/' . preg_quote($tagName, '/') . '>\s*$/';
        if (!preg_match($pattern, $contentWithoutScript)) {
            // Get preview to show what it ends with
            $preview = substr($contentWithoutScript, -self::PREVIEW_LENGTH);
            return [
                'valid' => false,
                'reason' => "Does not end with </{$tagName}>. Ends with: " . $preview
            ];
        }
        
        return ['valid' => true, 'reason' => ''];
    }
    
    private function findBladeFiles($directory)
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && substr($file->getFilename(), -10) === '.blade.php') {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    private function info($message)
    {
        echo self::COLOR_INFO . $message . self::COLOR_RESET . "\n";
    }
    
    private function success($message)
    {
        echo self::COLOR_SUCCESS . $message . self::COLOR_RESET . "\n";
    }
    
    private function error($message)
    {
        echo self::COLOR_ERROR . $message . self::COLOR_RESET . "\n";
    }
}

// Run validator
$validator = new LivewireViewValidator();
$result = $validator->validate();

exit($result ? 0 : 1);
