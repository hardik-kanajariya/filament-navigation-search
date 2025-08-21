# Changelog

All notable changes to `filament-navigation-search` will be documented in this file.

## v1.0.0 - 2025-08-22

### Added
- Initial release of Filament Navigation Search plugin
- Real-time navigation filtering with debounced search
- Support for searching navigation items, groups, and badges
- Configurable search placeholder, position, and behavior
- Results counter with customizable display
- Text highlighting for search matches
- Keyboard shortcuts (Ctrl/Cmd + K to focus, Escape to clear)
- Dark mode support with automatic theme detection
- Comprehensive test suite with unit and feature tests
- Multi-language support with English translations
- Smooth animations and transitions
- No results state with helpful messaging
- Clear search functionality with visual feedback
- Sticky positioning for better UX
- Accessibility features and ARIA support

### Features
- **Smart Search**: Searches through navigation labels, group names, and badges
- **Configurable Options**: Customize placeholder, position, delays, and more
- **Performance Optimized**: Client-side filtering for instant results
- **Beautiful UI**: Seamlessly integrates with Filament's design system
- **Keyboard Navigation**: Full keyboard support for power users
- **Responsive Design**: Works perfectly on desktop and mobile devices

### Configuration Options
- `placeholder()` - Custom search input placeholder
- `position()` - Search box position ('top' or 'bottom')
- `showResultsCount()` - Toggle results counter display
- `searchDelay()` - Debounce delay for search input
- `minSearchLength()` - Minimum characters before filtering
- `highlightMatches()` - Enable/disable text highlighting
- `enabled()` - Conditional plugin activation

### Technical Details
- Built with Alpine.js for reactive functionality
- Uses Filament's render hooks for seamless integration
- Follows PSR-12 coding standards
- Comprehensive test coverage with PHPStan analysis
- Modern CSS with proper dark mode support
- Optimized for performance with minimal overhead
