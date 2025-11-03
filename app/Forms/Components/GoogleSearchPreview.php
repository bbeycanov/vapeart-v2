<?php

namespace App\Forms\Components;

use Filament\Schemas\Components\Component;

class GoogleSearchPreview extends Component
{
    protected array $extra = [];


    protected string $view = 'forms.components.google-search-preview';

    protected function setUp(): void
    {
        parent::setUp();
        $this->dehydrated(false);
        $this->reactive();
    }

    public function baseUrl(string $url): static
    {
         $this->extra['data-base-url'] = $url;
         return $this->extraAttributes($this->extra);
    }

    public function siteName(string $name): static
    {
        $this->extra['data-site-name'] = $name;
        return $this->extraAttributes($this->extra);
    }

    public function faviconUrl(?string $url): static
    {
        $this->extra['data-favicon'] = $url;
        return $this->extraAttributes($this->extra);
    }

    public static function make(): static
    {
        /** @var static $i */
        $i = app(static::class);
        return $i;
    }
}
