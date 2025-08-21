# Filament Navigation Search

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hkdevs/filament-navigation-search.svg?style=flat-square)](https://packagist.org/packages/hkdevs/filament-navigation-search)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hardik-kanajariya/filament-navigation-search/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hardik-kanajariya/filament-navigation-search/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hardik-kanajariya/filament-navigation-search/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hardik-kanajariya/filament-navigation-search/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hkdevs/filament-navigation-search.svg?style=flat-square)](https://packagist.org/packages/hkdevs/filament-navigation-search)

A beautiful and intuitive navigation search plugin for FilamentPHP panels. This plugin adds a real-time search functionality to your Filament sidebar navigation, allowing users to quickly filter and find navigation items.

![Filament Navigation Search Demo](./docs/images/demo.gif)

## Features

- 🔍 **Real-time search** - Filter navigation items as you type
- 🎯 **Smart filtering** - Searches through navigation labels, groups, and badges
- 🌙 **Dark mode support** - Seamlessly integrates with Filament's theming
- ⚡ **Fast & lightweight** - Client-side filtering for instant results
- 🎨 **Beautiful UI** - Matches Filament's design system perfectly
- 📱 **Mobile responsive** - Works great on all device sizes
- 🔧 **Easy to configure** - Simple setup and customization options

## Installation

You can install the package via composer:

```bash
composer require hkdevs/filament-navigation-search
```

## Usage

### Basic Setup

Add the plugin to your Filament panel in your `PanelProvider`:

```php
use HkDevs\FilamentNavigationSearch\FilamentNavigationSearchPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... your other configuration
        ->plugins([
            FilamentNavigationSearchPlugin::make(),
            // ... your other plugins
        ]);
}
```

That's it! The navigation search will now appear at the top of your sidebar.

### Advanced Configuration

You can customize the plugin behavior:

```php
use HkDevs\FilamentNavigationSearch\FilamentNavigationSearchPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentNavigationSearchPlugin::make()
                ->placeholder('Search menu items...')
                ->position('top') // or 'bottom'
                ->showResultsCount(true)
                ->searchDelay(300) // milliseconds
                ->minSearchLength(2)
                ->highlightMatches(true),
        ]);
}
```

### Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `placeholder()` | string | 'Search navigation...' | Placeholder text for the search input |
| `position()` | string | 'top' | Position of search box ('top' or 'bottom') |
| `showResultsCount()` | bool | true | Show count of filtered results |
| `searchDelay()` | int | 200 | Debounce delay in milliseconds |
| `minSearchLength()` | int | 1 | Minimum characters before filtering |
| `highlightMatches()` | bool | true | Highlight matching text in results |

### Disabling the Plugin

You can conditionally disable the plugin:

```php
FilamentNavigationSearchPlugin::make()
    ->enabled(fn () => auth()->user()?->can('use-navigation-search'))
```

## How It Works

The plugin works by:

1. **Analyzing Navigation Structure** - Scans all navigation items and groups
2. **Client-Side Filtering** - Uses Alpine.js for fast, real-time filtering
3. **Smart Matching** - Searches through item labels, group names, and badges
4. **Visual Feedback** - Shows/hides items with smooth transitions

## Customization

### Styling

The plugin uses Filament's CSS classes and follows the design system. You can customize the appearance by overriding CSS:

```css
/* Custom search input styling */
.fi-nav-search input {
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
}

/* Custom highlight color */
.fi-nav-search-highlight {
    background-color: #fbbf24;
    color: #1f2937;
}
```

### Views

You can publish and customize the views:

```bash
php artisan vendor:publish --tag="filament-navigation-search-views"
```

### Translations

You can publish and customize the language files:

```bash
php artisan vendor:publish --tag="filament-navigation-search-translations"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Hardik Kanajariya](https://github.com/hardik-kanajariya)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support

If you find this package useful, please consider:

- ⭐ Starring the repository
- 🐛 Reporting bugs or requesting features
- 💡 Contributing to the codebase
- ☕ [Buying me a coffee](https://www.buymeacoffee.com/hardikkanajariya)

---

**Made with ❤️ by [Hardik Kanajariya](https://hardikkanajariya.in)**
