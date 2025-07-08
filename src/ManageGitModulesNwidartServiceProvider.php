<?php

namespace ErixCode\ManageGitModulesNwidart;

use App\Console\Commands\GitLogInModules;
use App\Console\Commands\GitPullInModules;
use ErixCode\ManageGitModulesNwidart\Commands\GitBranchInModules;
use Illuminate\Support\ServiceProvider;

class ManageGitModulesNwidartServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Aquí puedes registrar bindings si los necesitas
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GitBranchInModules::class,
                GitLogInModules::class,
                GitPullInModules::class
            ]);
        }
    }
}
