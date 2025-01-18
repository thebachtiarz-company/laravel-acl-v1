<?php

namespace App\Libraries\MyACL\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface::class, concrete: \App\Libraries\MyACL\Models\AccessManager::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface::class, concrete: \App\Libraries\MyACL\Models\AccessSystem::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface::class, concrete: \App\Libraries\MyACL\Models\SourceAccess::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Models\UserAccessInterface::class, concrete: \App\Libraries\MyACL\Models\UserAccess::class);

        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Repositories\AccessManagerRepositoryInterface::class, concrete: \App\Libraries\MyACL\Repositories\AccessManagerRepository::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Repositories\AccessSystemRepositoryInterface::class, concrete: \App\Libraries\MyACL\Repositories\AccessSystemRepository::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Repositories\SourceAccessRepositoryInterface::class, concrete: \App\Libraries\MyACL\Repositories\SourceAccessRepository::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Repositories\UserAccessRepositoryInterface::class, concrete: \App\Libraries\MyACL\Repositories\UserAccessRepository::class);

        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Services\AccessManagerServiceInterface::class, concrete: \App\Libraries\MyACL\Services\AccessManagerService::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Services\AccessSystemServiceInterface::class, concrete: \App\Libraries\MyACL\Services\AccessSystemService::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Services\SourceAccessServiceInterface::class, concrete: \App\Libraries\MyACL\Services\SourceAccessService::class);
        $this->app->bind(abstract: \App\Libraries\MyACL\Interfaces\Services\UserAccessServiceInterface::class, concrete: \App\Libraries\MyACL\Services\UserAccessService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $publishName = 'thebachtiarz-acl-advance';

        $this->publishes([__DIR__ . '/../../database/migrations' => database_path('migrations')], "$publishName-migrations");
    }
}
