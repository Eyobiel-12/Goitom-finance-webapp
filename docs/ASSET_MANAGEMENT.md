# Asset Management Guidelines

## ❗ Important: Always Use @vite, Never Hardcode Asset Paths

This project uses **Vite** for asset compilation. **NEVER** hardcode asset file paths in Blade templates.

## ✅ Correct Way

Always use the `@vite` directive in Blade templates:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

This automatically:

-   Loads the correct files from `resources/`
-   Handles hot module replacement in development
-   Generates correct hashed filenames in production
-   Works with both dev and production builds

## ❌ Wrong Ways (NEVER DO THIS)

### ❌ Don't hardcode build asset paths:

```blade
{{-- WRONG! --}}
<link rel="stylesheet" href="{{ asset('build/assets/app-XXX.css') }}">
<script type="module" src="{{ asset('build/assets/app-XXX.js') }}"></script>
```

### ❌ Don't use old/static filenames:

```blade
{{-- WRONG! --}}
<link rel="stylesheet" href="{{ asset('build/assets/app-BVG48AMd.css') }}">
```

### ❌ Don't directly reference build folder:

```blade
{{-- WRONG! --}}
<link rel="stylesheet" href="/build/assets/app.css">
```

## Why?

1. **Build hashes change**: Each `npm run build` generates new file hashes
2. **Development mode**: Vite dev server uses different URLs
3. **Cache busting**: Vite handles cache busting automatically
4. **Build process**: Files are optimized and hashed during build

## Files to Check

Always use `@vite` in these files:

-   `resources/views/**/*.blade.php`
-   Layout files (`resources/views/layouts/*.blade.php`)
-   Component files (`resources/views/components/**/*.blade.php`)

## Pre-Commit Check

This repository includes a pre-commit hook that automatically checks for hardcoded asset paths. If detected, the commit will be blocked.

You can manually run the check:

```bash
# Windows (PowerShell)
pwsh scripts/check-hardcoded-assets.ps1

# Linux/Mac/Git Bash
bash scripts/check-hardcoded-assets.sh
```

## If You See This Error

If the pre-commit hook blocks your commit:

1. Find all instances of `asset('build/assets` or `asset("build/assets` in your Blade files
2. Replace them with `@vite(['resources/css/app.css', 'resources/js/app.js'])`
3. Commit again

## Example Migration

### Before (WRONG):

```blade
<head>
    <link rel="stylesheet" href="{{ asset('build/assets/app-BVG48AMd.css') }}">
    <script type="module" src="{{ asset('build/assets/app-CXDpL9bK.js') }}"></script>
</head>
```

### After (CORRECT):

```blade
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

## Remember

-   ✅ Always use `@vite(['resources/css/app.css', 'resources/js/app.js'])`
-   ❌ Never use `asset('build/assets/...')` for compiled assets
-   ✅ The `@vite` directive handles everything automatically
