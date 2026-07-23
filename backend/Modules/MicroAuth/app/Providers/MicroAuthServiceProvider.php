<?php

namespace Modules\MicroAuth\Providers;

use Modules\MicroAuth\Contracts\AuthServiceInterface;
use Modules\MicroAuth\Services\AuthService;
use Nwidart\Modules\Support\ModuleServiceProvider;

class MicroAuthServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'MicroAuth';
    protected string $nameLower = 'microauth';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Registra los bindings del módulo.
     * Otros módulos inyectan AuthServiceInterface; nunca AuthService directamente.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }
}
