# Filament Navigation Search Plugin

This is a standalone, open-source Filament plugin that adds beautiful search functionality to your navigation sidebar.

## Directory Structure

```
filament-navigation-search/
├── .github/workflows/          # GitHub Actions for CI/CD
│   ├── run-tests.yml          # Automated testing
│   └── fix-php-code-style-issues.yml
├── examples/                   # Usage examples
│   └── ExampleAdminPanelProvider.php
├── resources/
│   ├── lang/en/               # English translations
│   └── views/                 # Blade templates
├── src/                       # Main source code
│   ├── FilamentNavigationSearchPlugin.php
│   └── FilamentNavigationSearchServiceProvider.php
├── tests/                     # Test suite
│   ├── Feature/               # Integration tests
│   ├── Unit/                  # Unit tests
│   ├── Pest.php              # Pest configuration
│   └── TestCase.php          # Base test class
├── .gitignore
├── .php-cs-fixer.dist.php    # Code style configuration
├── CHANGELOG.md              # Version history
├── composer.json             # Package dependencies
├── CONTRIBUTING.md           # Contribution guidelines
├── LICENSE.md               # MIT License
├── phpstan.neon.dist        # Static analysis config
├── phpstan-baseline.neon    # PHPStan baseline
├── phpunit.xml             # PHPUnit configuration
├── README.md               # Main documentation
├── run-tests.bat          # Windows test runner
├── run-tests.sh          # Unix test runner
└── USAGE.md             # Comprehensive usage guide
```

## Development Workflow

### Setting Up for Development

1. **Navigate to the plugin directory:**
   ```bash
   cd packages/filament-navigation-search
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Run tests:**
   ```bash
   composer test
   # or
   ./run-tests.sh  # Unix
   run-tests.bat   # Windows
   ```

### Testing

The plugin includes comprehensive tests:

- **Unit Tests**: Test individual components and methods
- **Feature Tests**: Test integration with Filament panels
- **Code Style**: PSR-12 compliance with Laravel Pint
- **Static Analysis**: PHPStan level 4 analysis

### Code Quality

- **PSR-12 Coding Standard**: Enforced via Laravel Pint
- **Static Analysis**: PHPStan with Laravel extensions
- **Test Coverage**: Comprehensive unit and feature tests
- **Documentation**: Extensive README and usage examples

### CI/CD

GitHub Actions automatically:
- Run tests on multiple PHP/Laravel versions
- Check code style and fix issues
- Perform static analysis
- Generate test reports

## Features

- 🔍 **Real-time Search**: Filter navigation items as you type
- ⚡ **High Performance**: Client-side filtering for instant results
- 🎨 **Beautiful UI**: Seamlessly integrates with Filament's design
- 🌙 **Dark Mode**: Full dark mode support
- ⌨️ **Keyboard Shortcuts**: Ctrl/Cmd+K to focus, Escape to clear
- 📱 **Mobile Responsive**: Works on all device sizes
- 🎯 **Smart Filtering**: Searches labels, groups, and badges
- 🎨 **Customizable**: Configurable appearance and behavior
- 🌍 **Internationalization**: Multi-language support
- ♿ **Accessible**: Proper ARIA labels and keyboard navigation

## Installation & Usage

See [README.md](README.md) for installation instructions and [USAGE.md](USAGE.md) for comprehensive usage examples.

## Contributing

This is an open-source project. Contributions are welcome! See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## License

MIT License. See [LICENSE.md](LICENSE.md) for details.

---

**Author:** [Hardik Kanajariya](https://hardikkanajariya.in)
**Website:** [hardikkanajariya.in](https://hardikkanajariya.in)
**Email:** hardik@hardikkanajariya.in
