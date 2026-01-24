# Frontend Error Fixes - Deployment Guide

## Issues Fixed

### 1. JavaScript Error: "Cannot read properties of undefined (reading 'toLowerCase')"

**Location**: `resources/js/app.js` - KeyboardShortcuts.handleKeydown()

**Problem**: 
The keyboard event handler was attempting to call `.toLowerCase()` on `e.key` without checking if it exists first. In some edge cases (particularly with certain browser extensions or unusual keyboard events), `e.key` can be undefined.

**Fix**:
Added a safety check at the beginning of the `handleKeydown` method:
```javascript
if (!e || !e.key) return;
```

**Impact**: Prevents the application from crashing when undefined keyboard events occur.

---

### 2. Error: "Unexpected token '<'" in JavaScript Files

**Location**: Service Worker (`public/sw.js`)

**Problem**:
The service worker was caching HTTP responses without validating that the content-type matched the requested resource type. This caused scenarios where:
- HTML error pages (404, 500, etc.) were cached as JavaScript files
- When the browser tried to execute these cached responses, it encountered HTML (`<html>...`) instead of JavaScript, causing "Unexpected token '<'" errors
- This particularly affected the backup and settings pages

**Fix**:
Enhanced the `cacheFirstWithNetwork()` function in the service worker to:
1. **Validate cached responses**: Before serving from cache, check if content-type matches the request
2. **Auto-invalidate bad cache**: If HTML is cached for a `.js` or `.css` request, delete that cache entry
3. **Prevent bad caching**: Only cache responses when content-type matches the file extension
4. **Add logging**: Console warnings help identify cache issues during debugging

```javascript
// Validate cached response
if (requestUrl.pathname.endsWith('.js') && contentType.includes('text/html')) {
    console.warn('[SW] Invalid cache: HTML cached for JS file');
    await caches.delete(request);
}
```

**Impact**: Eliminates "Unexpected token '<'" errors and ensures JavaScript/CSS files are served correctly.

---

### 3. Cache Clearing Utility Function

**Location**: `resources/js/app.js`

**Purpose**: Provides a simple way to clear service worker cache when troubleshooting issues.

**Usage**:
Open browser console (F12) and run:
```javascript
erpClearServiceWorkerCache()
```

This will:
- Clear all service worker caches
- Show a success notification
- Automatically refresh the page after 1.5 seconds

---

## Deployment Instructions

### Prerequisites
- Node.js and npm installed
- Access to the server/hosting environment

### Steps

1. **Install Dependencies**:
   ```bash
   npm install
   ```

2. **Build Assets**:
   ```bash
   npm run build
   ```
   This compiles:
   - `resources/js/app.js` → `public/build/assets/app-[hash].js`
   - `resources/css/app.css` → `public/build/assets/app-[hash].css`

3. **Deploy Files**:
   Upload these files to your server:
   - `public/sw.js` (updated service worker)
   - `public/build/` directory (built assets)
   - `resources/js/app.js` (source file with fixes)
   - `resources/css/app.css` (unchanged but included in build)

4. **Clear Server Cache** (if applicable):
   - If using Laravel caching: `php artisan cache:clear`
   - If using Opcache: Restart PHP-FPM or clear Opcache
   - If using CDN: Purge CDN cache for affected files

5. **Service Worker Update**:
   The service worker will auto-update when users visit the site. The update process:
   - Browser detects new service worker
   - Shows update notification (optional)
   - Updates in background
   - Takes effect on next page load

---

## Troubleshooting

### If Users Still See Errors

1. **Hard Refresh**: Ask users to do a hard refresh
   - Windows/Linux: `Ctrl + Shift + R` or `Ctrl + F5`
   - Mac: `Cmd + Shift + R`

2. **Clear Service Worker Cache**: In browser console:
   ```javascript
   erpClearServiceWorkerCache()
   ```

3. **Manual Service Worker Unregister**:
   ```javascript
   navigator.serviceWorker.getRegistrations().then(function(registrations) {
       for(let registration of registrations) {
           registration.unregister();
       }
   });
   ```
   Then refresh the page.

4. **Clear Browser Data**:
   - Chrome: Settings → Privacy → Clear browsing data → Cached images and files
   - Firefox: Options → Privacy → Cookies and Site Data → Clear Data
   - Safari: Safari → Clear History

### Verifying the Fix

1. **Check Console**: Open browser DevTools (F12) → Console tab
   - Should NOT see "Cannot read properties of undefined" errors
   - Should NOT see "Unexpected token '<'" errors

2. **Check Network**: DevTools → Network tab
   - JavaScript files should have content-type: `application/javascript`
   - CSS files should have content-type: `text/css`
   - No 404 errors for build assets

3. **Check Service Worker**: DevTools → Application → Service Workers
   - Should show service worker as "activated and running"
   - Version should be `v1.1.0` or higher

### Common Issues

**Q: Sidebar not showing**
- Check if CSS file loaded correctly in Network tab
- Verify `public/build/assets/app-[hash].css` exists
- Check console for CSS loading errors
- Try hard refresh or clear cache

**Q: Dashboard not working**
- Check console for JavaScript errors
- Verify `public/build/assets/app-[hash].js` loaded
- Ensure Livewire is working (no 419/401 errors)
- Try cache clearing function

**Q: Service worker not updating**
- Wait 24 hours (service workers update every 24h by default)
- Or manually unregister and refresh
- Or increment `CACHE_VERSION` in `sw.js`

---

## Technical Details

### File Changes

1. **resources/js/app.js**:
   - Line 393-397: Added null check in `handleKeydown()`
   - Line 323-345: Added `erpClearServiceWorkerCache()` utility

2. **public/sw.js**:
   - Line 287-341: Enhanced `cacheFirstWithNetwork()` with content-type validation
   - Added cache invalidation logic
   - Added logging for debugging

### Cache Strategy

The service worker uses different strategies for different resources:

- **Static assets** (JS, CSS, images): Cache-first with network fallback
- **API calls**: Network-first with cache fallback
- **HTML pages**: Network-first with offline fallback page
- **Validation**: Content-type must match file extension

### Browser Compatibility

These fixes work on:
- ✅ Chrome/Edge 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

---

## Rollback Instructions

If issues persist after deployment:

1. **Revert code changes**:
   ```bash
   git revert HEAD~3..HEAD
   ```

2. **Disable service worker** (temporary):
   Comment out service worker registration in `resources/views/layouts/app.blade.php`:
   ```javascript
   // Temporarily disabled
   // if ('serviceWorker' in navigator) {
   //     window.addEventListener('load', () => {
   //         navigator.serviceWorker.register('/sw.js')
   ```

3. **Rebuild and redeploy**:
   ```bash
   npm run build
   ```

---

## Support

For issues or questions:
1. Check browser console for error messages
2. Review this document's troubleshooting section
3. Contact development team with:
   - Browser and version
   - Console error logs
   - Network tab screenshots
   - Steps to reproduce

---

**Last Updated**: 2026-01-24  
**Version**: 1.0  
**Applies to**: HugousERP v1.1.0+
