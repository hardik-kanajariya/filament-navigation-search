<div x-data="filamentNavigationSearch({
        placeholder: '{{ $placeholder }}',
        showResultsCount: {{ $showResultsCount ? 'true' : 'false' }},
        searchDelay: {{ $searchDelay }},
        minSearchLength: {{ $minSearchLength }},
        highlightMatches: {{ $highlightMatches ? 'true' : 'false' }}
    })" x-init="init()" class="fi-nav-search">
    <div class="fi-nav-search-wrapper">
        <!-- Search Input -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-filament::icon icon="heroicon-m-magnifying-glass" class="fi-nav-search-icon" />
            </div>
            <input type="text" x-model="searchQuery" x-ref="searchInput" :placeholder="placeholder"
                class="fi-nav-search-input" autocomplete="off" spellcheck="false" />
            <!-- Clear Button -->
            <button x-show="searchQuery.length > 0" x-transition:enter="fi-nav-search-transition-enter"
                x-transition:enter-start="fi-nav-search-transition-enter-start"
                x-transition:enter-end="fi-nav-search-transition-enter-end"
                x-transition:leave="fi-nav-search-transition-leave"
                x-transition:leave-start="fi-nav-search-transition-leave-start"
                x-transition:leave-end="fi-nav-search-transition-leave-end" @click="clearSearch()" type="button"
                class="fi-nav-search-clear-btn" title="{{ __('filament-navigation-search::navigation-search.clear') }}">
                <x-filament::icon icon="heroicon-m-x-mark" class="fi-nav-search-clear-icon" />
            </button>
        </div>

        <!-- Search Results Count -->
        <div x-show="showResultsCount && searchQuery.length >= minSearchLength"
            x-transition:enter="fi-nav-search-transition-enter"
            x-transition:enter-start="fi-nav-search-transition-enter-start"
            x-transition:enter-end="fi-nav-search-transition-enter-end"
            x-transition:leave="fi-nav-search-transition-leave"
            x-transition:leave-start="fi-nav-search-transition-leave-start"
            x-transition:leave-end="fi-nav-search-transition-leave-end" class="fi-nav-search-results-count">
            <span x-text="getResultsText()"></span>
        </div>

        <!-- No Results Message -->
        <div x-show="searchQuery.length >= minSearchLength && visibleItemsCount === 0"
            x-transition:enter="fi-nav-search-transition-enter"
            x-transition:enter-start="fi-nav-search-transition-enter-start"
            x-transition:enter-end="fi-nav-search-transition-enter-end"
            x-transition:leave="fi-nav-search-transition-leave"
            x-transition:leave-start="fi-nav-search-transition-leave-start"
            x-transition:leave-end="fi-nav-search-transition-leave-end" class="fi-nav-search-no-results">
            <div class="flex items-center gap-2">
                <x-filament::icon icon="heroicon-m-exclamation-triangle" class="fi-nav-search-no-results-icon" />
                <span>{{ __('filament-navigation-search::navigation-search.no_results') }}</span>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
    <script>
        function filamentNavigationSearch(config = {}) {
            return {
                searchQuery: '',
                visibleItemsCount: 0,
                originalNavigation: null,
                searchTimeout: null,
                placeholder: config.placeholder || 'Search navigation...',
                showResultsCount: config.showResultsCount !== false,
                searchDelay: config.searchDelay || 200,
                minSearchLength: config.minSearchLength || 1,
                highlightMatches: config.highlightMatches !== false,

                init() {
                    this.cacheOriginalNavigation();

                    // Watch for search query changes with debouncing
                    this.$watch('searchQuery', (value) => {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            this.filterNavigation(value);
                        }, this.searchDelay);
                    });

                    // Add keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        // Focus search on Ctrl/Cmd + K
                        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                            e.preventDefault();
                            this.$refs.searchInput.focus();
                        }

                        // Clear search on Escape
                        if (e.key === 'Escape' && document.activeElement === this.$refs.searchInput) {
                            this.clearSearch();
                            this.$refs.searchInput.blur();
                        }
                    });
                },

                cacheOriginalNavigation() {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (nav) {
                        this.originalNavigation = nav.cloneNode(true);
                    }
                },

                filterNavigation(query) {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (!nav) return;

                    if (!query.trim() || query.length < this.minSearchLength) {
                        this.showAllItems();
                        this.countVisibleItems();
                        return;
                    }

                    const searchTerm = query.toLowerCase();
                    let visibleCount = 0;

                    // Hide all items initially
                    this.hideAllItems();

                    // Search through navigation items
                    nav.querySelectorAll('.fi-sidebar-nav-item').forEach(item => {
                        const label = this.getItemText(item, '.fi-sidebar-nav-item-label');
                        const badge = this.getItemText(item, '.fi-sidebar-nav-item-badge');

                        if (label.includes(searchTerm) || badge.includes(searchTerm)) {
                            this.showItem(item);
                            this.showParentGroup(item);
                            visibleCount++;

                            if (this.highlightMatches) {
                                this.highlightText(item, searchTerm);
                            }
                        }
                    });

                    // Search through navigation groups
                    nav.querySelectorAll('.fi-sidebar-nav-group').forEach(group => {
                        const groupLabel = this.getItemText(group, '.fi-sidebar-nav-group-label');

                        if (groupLabel.includes(searchTerm)) {
                            this.showGroup(group);
                            group.querySelectorAll('.fi-sidebar-nav-item').forEach(item => {
                                this.showItem(item);
                                visibleCount++;
                            });

                            if (this.highlightMatches) {
                                this.highlightText(group, searchTerm);
                            }
                        }
                    });

                    // Hide empty groups
                    this.hideEmptyGroups();

                    this.visibleItemsCount = visibleCount;
                },

                getItemText(element, selector) {
                    const textElement = element.querySelector(selector);
                    return textElement ? textElement.textContent.toLowerCase().trim() : '';
                },

                showAllItems() {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (!nav) return;

                    nav.querySelectorAll('.fi-sidebar-nav-item, .fi-sidebar-nav-group').forEach(item => {
                        item.style.display = '';
                        item.classList.remove('fi-nav-search-hidden');
                    });

                    this.removeHighlights();
                },

                hideAllItems() {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (!nav) return;

                    nav.querySelectorAll('.fi-sidebar-nav-item, .fi-sidebar-nav-group').forEach(item => {
                        item.style.display = 'none';
                        item.classList.add('fi-nav-search-hidden');
                    });
                },

                showItem(item) {
                    item.style.display = 'flex';
                    item.classList.remove('fi-nav-search-hidden');
                },

                showGroup(group) {
                    group.style.display = 'block';
                    group.classList.remove('fi-nav-search-hidden');
                },

                showParentGroup(item) {
                    const group = item.closest('.fi-sidebar-nav-group');
                    if (group) {
                        this.showGroup(group);
                    }
                },

                hideEmptyGroups() {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (!nav) return;

                    nav.querySelectorAll('.fi-sidebar-nav-group').forEach(group => {
                        const visibleItems = group.querySelectorAll('.fi-sidebar-nav-item:not(.fi-nav-search-hidden)');
                        if (visibleItems.length === 0) {
                            group.style.display = 'none';
                            group.classList.add('fi-nav-search-hidden');
                        }
                    });
                },

                countVisibleItems() {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (!nav) return;

                    const visibleItems = nav.querySelectorAll('.fi-sidebar-nav-item:not(.fi-nav-search-hidden)');
                    this.visibleItemsCount = visibleItems.length;
                },

                highlightText(element, searchTerm) {
                    // This is a basic implementation - can be enhanced for better highlighting
                    const textElements = element.querySelectorAll('.fi-sidebar-nav-item-label, .fi-sidebar-nav-group-label');

                    textElements.forEach(textEl => {
                        const text = textEl.textContent;
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        const highlightedText = text.replace(regex, '<mark class="fi-nav-search-highlight">$1</mark>');

                        if (highlightedText !== text) {
                            textEl.innerHTML = highlightedText;
                        }
                    });
                },

                removeHighlights() {
                    const nav = document.querySelector('.fi-sidebar-nav');
                    if (!nav) return;

                    nav.querySelectorAll('.fi-nav-search-highlight').forEach(highlight => {
                        const parent = highlight.parentNode;
                        parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
                        parent.normalize();
                    });
                },

                clearSearch() {
                    this.searchQuery = '';
                    this.removeHighlights();
                },

                getResultsText() {
                    const count = this.visibleItemsCount;
                    if (count === 0) {
                        return '';
                    } else if (count === 1) {
                        return '1 item found';
                    } else {
                        return `${count} items found`;
                    }
                }
            }
        }
    </script>
@endPushOnce

@pushOnce('styles')
    <style>
        /* Navigation Search Styles */
        .fi-nav-search {
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .fi-nav-search-wrapper {
            padding: 1rem;
            border-bottom: 1px solid rgb(243 244 246);
            background: rgba(249, 250, 251, 0.95);
            backdrop-filter: blur(8px);
        }

        .fi-nav-search-input {
            width: 100%;
            padding: 0.5rem 2.5rem 0.5rem 2.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            border: 1px solid rgb(209 213 219);
            border-radius: 0.5rem;
            background-color: rgb(255 255 255);
            color: rgb(17 24 39);
            transition: all 0.15s ease-in-out;
        }

        .fi-nav-search-input:focus {
            outline: none;
            border-color: rgb(59 130 246);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .fi-nav-search-icon {
            width: 1rem;
            height: 1rem;
            color: rgb(107 114 128);
        }

        .fi-nav-search-clear-btn {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
            background: transparent;
            border: none;
            cursor: pointer;
            color: rgb(107 114 128);
            transition: color 0.15s ease-in-out;
        }

        .fi-nav-search-clear-btn:hover {
            color: rgb(75 85 99);
        }

        .fi-nav-search-clear-icon {
            width: 1rem;
            height: 1rem;
        }

        .fi-nav-search-results-count {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            line-height: 1rem;
            color: rgb(107 114 128);
        }

        .fi-nav-search-no-results {
            margin-top: 0.5rem;
            padding: 0.5rem;
            font-size: 0.75rem;
            line-height: 1rem;
            color: rgb(185 28 28);
            background-color: rgb(254 242 242);
            border: 1px solid rgb(252 165 165);
            border-radius: 0.375rem;
        }

        .fi-nav-search-no-results-icon {
            width: 1rem;
            height: 1rem;
            color: rgb(185 28 28);
        }

        .fi-nav-search-highlight {
            background-color: rgb(254 240 138);
            color: rgb(120 113 108);
            padding: 0.125rem 0.25rem;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        /* Transitions */
        .fi-nav-search-transition-enter {
            transition-property: opacity, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .fi-nav-search-transition-enter-start {
            opacity: 0;
            transform: scale(0.95);
        }

        .fi-nav-search-transition-enter-end {
            opacity: 1;
            transform: scale(1);
        }

        .fi-nav-search-transition-leave {
            transition-property: opacity, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 75ms;
        }

        .fi-nav-search-transition-leave-start {
            opacity: 1;
            transform: scale(1);
        }

        .fi-nav-search-transition-leave-end {
            opacity: 0;
            transform: scale(0.95);
        }

        /* Smooth transitions for filtered items */
        .fi-sidebar-nav-item,
        .fi-sidebar-nav-group {
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
        }

        /* Dark mode styles */
        .dark .fi-nav-search-wrapper {
            background-color: rgba(17, 24, 39, 0.95);
            border-bottom-color: rgb(55 65 81);
        }

        .dark .fi-nav-search-input {
            background-color: rgb(31 41 55);
            border-color: rgb(55 65 81);
            color: rgb(243 244 246);
        }

        .dark .fi-nav-search-input:focus {
            border-color: rgb(59 130 246);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dark .fi-nav-search-icon {
            color: rgb(156 163 175);
        }

        .dark .fi-nav-search-clear-btn {
            color: rgb(156 163 175);
        }

        .dark .fi-nav-search-clear-btn:hover {
            color: rgb(209 213 219);
        }

        .dark .fi-nav-search-results-count {
            color: rgb(156 163 175);
        }

        .dark .fi-nav-search-no-results {
            background-color: rgb(69 10 10);
            border-color: rgb(153 27 27);
            color: rgb(248 113 113);
        }

        .dark .fi-nav-search-no-results-icon {
            color: rgb(248 113 113);
        }

        .dark .fi-nav-search-highlight {
            background-color: rgb(120 113 108);
            color: rgb(255 255 255);
        }
    </style>
@endPushOnce