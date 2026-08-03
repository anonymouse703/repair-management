<?php

namespace App\Providers;

use App\Repositories\Console\GenerateRepository;
use App\Repositories\Console\GenerateRepositoryInterface;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach (glob(app_path().'/Helpers/*.php') as $filename){
            require_once($filename);
        }

        $this->registerRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function registerRepositories(): void
    {
        $namespace = 'App\\Repositories\\';
        $repositoryPath = app_path('Repositories');

        $repositoryFiles = File::files($repositoryPath);

        foreach ($repositoryFiles as $repositoryFile) {
            $className = pathinfo($repositoryFile, PATHINFO_FILENAME);
            $class = $namespace . $className;

            if (class_exists($class) && ! ($reflector = new \ReflectionClass($class))->isAbstract()) {
                $interfaces = $reflector->getInterfaces();
                $directInterface = next($interfaces);
                $interfaceName = $directInterface->getName();

                if (interface_exists($interfaceName)) {
                    $this->app->bind($interfaceName, $class);
                }
            }
        }

        $this->commands(GenerateRepository::class);
        $this->commands(GenerateRepositoryInterface::class);
        $this->commands(\App\Console\Commands\User\UserCreateCommand::class);
        $this->app->bind(\App\Repositories\Contracts\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
    }
}
