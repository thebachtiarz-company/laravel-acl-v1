<?php

namespace TheBachtiarz\ACL\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface::class, concrete: \TheBachtiarz\ACL\Models\AccessManager::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface::class, concrete: \TheBachtiarz\ACL\Models\AccessSystem::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface::class, concrete: \TheBachtiarz\ACL\Models\SourceAccess::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface::class, concrete: \TheBachtiarz\ACL\Models\UserAccess::class);

        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Repositories\AccessManagerRepositoryInterface::class, concrete: \TheBachtiarz\ACL\Repositories\AccessManagerRepository::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Repositories\AccessSystemRepositoryInterface::class, concrete: \TheBachtiarz\ACL\Repositories\AccessSystemRepository::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Repositories\SourceAccessRepositoryInterface::class, concrete: \TheBachtiarz\ACL\Repositories\SourceAccessRepository::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Repositories\UserAccessRepositoryInterface::class, concrete: \TheBachtiarz\ACL\Repositories\UserAccessRepository::class);

        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Services\AccessManagerServiceInterface::class, concrete: \TheBachtiarz\ACL\Services\AccessManagerService::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Services\AccessSystemServiceInterface::class, concrete: \TheBachtiarz\ACL\Services\AccessSystemService::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Services\SourceAccessServiceInterface::class, concrete: \TheBachtiarz\ACL\Services\SourceAccessService::class);
        $this->app->bind(abstract: \TheBachtiarz\ACL\Interfaces\Services\UserAccessServiceInterface::class, concrete: \TheBachtiarz\ACL\Services\UserAccessService::class);
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
