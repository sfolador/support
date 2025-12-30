<?php

namespace Sfolador\Support\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Sfolador\Support\Filament\Resources\SupportRequestResource;

class SupportPlugin implements Plugin
{
    public function getId(): string
    {
        return 'support';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            SupportRequestResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
