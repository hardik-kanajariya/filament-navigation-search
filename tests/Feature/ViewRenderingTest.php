<?php

namespace HkDevs\FilamentNavigationSearch\Tests\Feature;

use HkDevs\FilamentNavigationSearch\Tests\TestCase;

class ViewRenderingTest extends TestCase
{
    public function test_navigation_search_view_renders_correctly()
    {
        $view = view('filament-navigation-search::navigation-search', [
            'placeholder' => 'Search items...',
            'showResultsCount' => true,
            'searchDelay' => 300,
            'minSearchLength' => 2,
            'highlightMatches' => true,
        ]);

        $content = $view->render();

        $this->assertStringContainsString('fi-nav-search', $content);
        $this->assertStringContainsString('Search items...', $content);
        $this->assertStringContainsString('filamentNavigationSearch', $content);
        $this->assertStringContainsString('showResultsCount: true', $content);
        $this->assertStringContainsString('searchDelay: 300', $content);
        $this->assertStringContainsString('minSearchLength: 2', $content);
        $this->assertStringContainsString('highlightMatches: true', $content);
    }

    public function test_navigation_search_view_handles_false_boolean_values()
    {
        $view = view('filament-navigation-search::navigation-search', [
            'placeholder' => 'Test',
            'showResultsCount' => false,
            'searchDelay' => 100,
            'minSearchLength' => 1,
            'highlightMatches' => false,
        ]);

        $content = $view->render();

        $this->assertStringContainsString('showResultsCount: false', $content);
        $this->assertStringContainsString('highlightMatches: false', $content);
    }

    public function test_navigation_search_includes_javascript_functionality()
    {
        $view = view('filament-navigation-search::navigation-search', [
            'placeholder' => 'Test',
            'showResultsCount' => true,
            'searchDelay' => 200,
            'minSearchLength' => 1,
            'highlightMatches' => true,
        ]);

        $content = $view->render();

        // Check for key JavaScript functions
        $this->assertStringContainsString('filterNavigation', $content);
        $this->assertStringContainsString('clearSearch', $content);
        $this->assertStringContainsString('showAllItems', $content);
        $this->assertStringContainsString('hideAllItems', $content);
        $this->assertStringContainsString('highlightText', $content);
    }

    public function test_navigation_search_includes_proper_css_classes()
    {
        $view = view('filament-navigation-search::navigation-search', [
            'placeholder' => 'Test',
            'showResultsCount' => true,
            'searchDelay' => 200,
            'minSearchLength' => 1,
            'highlightMatches' => true,
        ]);

        $content = $view->render();

        // Check for Filament CSS classes
        $this->assertStringContainsString('fi-nav-search', $content);
        $this->assertStringContainsString('fi-nav-search-input', $content);
        $this->assertStringContainsString('fi-nav-search-icon', $content);
        $this->assertStringContainsString('fi-nav-search-clear-btn', $content);
        $this->assertStringContainsString('fi-nav-search-results-count', $content);
    }
}
