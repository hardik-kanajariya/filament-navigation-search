# Usage Examples

This document provides comprehensive examples of how to use the Filament Navigation Search plugin.

## Basic Installation

### Step 1: Install the Package

```bash
composer require hkdevs/filament-navigation-search
```

### Step 2: Add to Your Panel

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use HkDevs\FilamentNavigationSearch\FilamentNavigationSearchPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugins([
                FilamentNavigationSearchPlugin::make(),
            ]);
    }
}
```

## Configuration Examples

### Basic Configuration

```php
FilamentNavigationSearchPlugin::make()
    ->placeholder('Search admin panel...')
    ->position('top')
    ->showResultsCount(true)
```

### Advanced Configuration

```php
FilamentNavigationSearchPlugin::make()
    ->placeholder('Find what you need...')
    ->position('bottom')
    ->showResultsCount(false)
    ->searchDelay(500)
    ->minSearchLength(3)
    ->highlightMatches(false)
```

### Conditional Activation

```php
// Enable only for admins
FilamentNavigationSearchPlugin::make()
    ->enabled(fn () => auth()->user()?->hasRole('admin'))

// Enable based on environment
FilamentNavigationSearchPlugin::make()
    ->enabled(app()->environment('local', 'staging'))

// Enable based on feature flag
FilamentNavigationSearchPlugin::make()
    ->enabled(config('features.navigation_search', true))
```

## Real-World Examples

### E-commerce Admin Panel

```php
FilamentNavigationSearchPlugin::make()
    ->placeholder('Search products, orders, customers...')
    ->position('top')
    ->showResultsCount(true)
    ->searchDelay(300)
    ->minSearchLength(2)
    ->highlightMatches(true)
```

### Content Management System

```php
FilamentNavigationSearchPlugin::make()
    ->placeholder('Find pages, posts, media...')
    ->position('top')
    ->showResultsCount(true)
    ->searchDelay(200)
    ->minSearchLength(1)
    ->highlightMatches(true)
```

### Multi-tenant Application

```php
FilamentNavigationSearchPlugin::make()
    ->placeholder('Search tenant resources...')
    ->enabled(fn () => Filament::getTenant()?->hasFeature('navigation_search'))
    ->position('top')
    ->showResultsCount(true)
```

## Customization Examples

### Custom Styling

Create a custom CSS file:

```css
/* resources/css/custom-navigation-search.css */

/* Custom search input styling */
.fi-nav-search-input {
    border-radius: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.fi-nav-search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Custom highlight color */
.fi-nav-search-highlight {
    background-color: #fbbf24;
    color: #1f2937;
    font-weight: 700;
}

/* Custom clear button */
.fi-nav-search-clear-btn {
    color: rgba(255, 255, 255, 0.8);
}

.fi-nav-search-clear-btn:hover {
    color: white;
}
```

Include it in your panel:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->viteTheme('resources/css/custom-navigation-search.css')
        ->plugins([
            FilamentNavigationSearchPlugin::make(),
        ]);
}
```

### Custom Translations

Publish the language files:

```bash
php artisan vendor:publish --tag="filament-navigation-search-translations"
```

Customize the translations in `resources/lang/en/filament-navigation-search.php`:

```php
<?php

return [
    'clear' => 'Clear search',
    'no_results' => 'No items found matching your search',
    'placeholder' => 'Type to search navigation...',
    'results_count' => [
        'single' => 'Found :count item',
        'multiple' => 'Found :count items',
    ],
];
```

### Custom Views

Publish the views:

```bash
php artisan vendor:publish --tag="filament-navigation-search-views"
```

Customize the navigation search view in `resources/views/vendor/filament-navigation-search/navigation-search.blade.php`.

## Performance Optimization

### Large Navigation Structures

For applications with many navigation items:

```php
FilamentNavigationSearchPlugin::make()
    ->searchDelay(400) // Increase delay to reduce rapid filtering
    ->minSearchLength(3) // Require more characters before filtering
    ->showResultsCount(false) // Disable counting for better performance
```

### Memory-Conscious Configuration

```php
FilamentNavigationSearchPlugin::make()
    ->highlightMatches(false) // Disable highlighting to save DOM manipulation
    ->searchDelay(500) // Higher delay = fewer search operations
    ->minSearchLength(2) // Don't search single characters
```

## Integration Examples

### With Role-Based Navigation

```php
// In your PanelProvider
public function panel(Panel $panel): Panel
{
    return $panel
        ->navigation([
            NavigationGroup::make('Content')
                ->items([
                    NavigationItem::make('Posts')
                        ->visible(fn () => auth()->user()->can('view_posts')),
                    NavigationItem::make('Pages')
                        ->visible(fn () => auth()->user()->can('view_pages')),
                ]),
            NavigationGroup::make('Settings')
                ->items([
                    NavigationItem::make('Users')
                        ->visible(fn () => auth()->user()->can('view_users')),
                ])
                ->visible(fn () => auth()->user()->hasRole('admin')),
        ])
        ->plugins([
            FilamentNavigationSearchPlugin::make()
                ->placeholder('Search available features...')
                ->enabled(fn () => auth()->user()->navigation_items()->count() > 5),
        ]);
}
```

### With Dynamic Navigation

```php
// Custom navigation provider
class DynamicNavigationProvider
{
    public static function getNavigation(): array
    {
        $user = auth()->user();
        $navigation = [];
        
        // Add navigation items based on user permissions
        if ($user->can('view_dashboard')) {
            $navigation[] = NavigationItem::make('Dashboard');
        }
        
        // Add more items...
        
        return $navigation;
    }
}

// In your PanelProvider
public function panel(Panel $panel): Panel
{
    return $panel
        ->navigation(DynamicNavigationProvider::getNavigation())
        ->plugins([
            FilamentNavigationSearchPlugin::make()
                ->enabled(fn () => count(DynamicNavigationProvider::getNavigation()) > 3),
        ]);
}
```

## Troubleshooting

### Common Issues

1. **Search not working**: Ensure the plugin is properly registered and JavaScript is not blocked.
2. **Styling issues**: Check for CSS conflicts and ensure Filament's CSS is loaded.
3. **Performance issues**: Increase search delay and minimum search length for large navigation structures.

### Debug Mode

Enable debug mode to see what's happening:

```php
FilamentNavigationSearchPlugin::make()
    ->searchDelay(0) // No delay for debugging
    ->minSearchLength(1) // Search immediately
    ->showResultsCount(true) // See result counts
```

### Browser Console Debugging

Add this JavaScript to debug search functionality:

```javascript
// In browser console
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.fi-nav-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            console.log('Search query:', e.target.value);
            console.log('Visible items:', document.querySelectorAll('.fi-sidebar-nav-item:not(.fi-nav-search-hidden)').length);
        });
    }
});
```
