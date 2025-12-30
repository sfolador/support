<?php

namespace Sfolador\Support;

use Sfolador\Support\Http\Controllers\SupportRequestController;
use Sfolador\Support\Services\RecaptchaService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SupportServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('support')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_support_requests_table')
            ->hasRoute('web');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(RecaptchaService::class, function ($app) {
            return new RecaptchaService;
        });

        $this->app->bind(SupportRequestController::class, function ($app) {
            return new SupportRequestController($app->make(RecaptchaService::class));
        });
    }
}
