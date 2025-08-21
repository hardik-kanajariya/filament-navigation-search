<?php

namespace HkDevs\FilamentNavigationSearch;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentNavigationSearchPlugin implements Plugin
{
    protected string $placeholder = 'Search navigation...';
    protected string $position = 'top';
    protected bool $showResultsCount = true;
    protected int $searchDelay = 200;
    protected int $minSearchLength = 1;
    protected bool $highlightMatches = true;
    protected bool $enabled = true;

    public function getId(): string
    {
        return 'filament-navigation-search';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        if (! $this->enabled) {
            return;
        }

        $renderHook = $this->position === 'bottom' 
            ? 'panels::sidebar.end' 
            : 'panels::sidebar.start';

        $panel->renderHook($renderHook, fn () => view('filament-navigation-search::navigation-search', [
            'placeholder' => $this->placeholder,
            'showResultsCount' => $this->showResultsCount,
            'searchDelay' => $this->searchDelay,
            'minSearchLength' => $this->minSearchLength,
            'highlightMatches' => $this->highlightMatches,
        ]));
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function position(string $position): static
    {
        if (! in_array($position, ['top', 'bottom'])) {
            throw new \InvalidArgumentException('Position must be either "top" or "bottom"');
        }

        $this->position = $position;
        return $this;
    }

    public function showResultsCount(bool $show = true): static
    {
        $this->showResultsCount = $show;
        return $this;
    }

    public function searchDelay(int $delay): static
    {
        $this->searchDelay = max(0, $delay);
        return $this;
    }

    public function minSearchLength(int $length): static
    {
        $this->minSearchLength = max(1, $length);
        return $this;
    }

    public function highlightMatches(bool $highlight = true): static
    {
        $this->highlightMatches = $highlight;
        return $this;
    }

    public function enabled(bool|Closure $condition = true): static
    {
        $this->enabled = $condition instanceof Closure ? $condition() : $condition;
        return $this;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getShowResultsCount(): bool
    {
        return $this->showResultsCount;
    }

    public function getSearchDelay(): int
    {
        return $this->searchDelay;
    }

    public function getMinSearchLength(): int
    {
        return $this->minSearchLength;
    }

    public function getHighlightMatches(): bool
    {
        return $this->highlightMatches;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
