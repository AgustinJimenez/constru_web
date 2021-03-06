<?php namespace Modules\Proveedores\Providers;

use Illuminate\Support\ServiceProvider;

class ProveedoresServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Proveedores\Repositories\ProveedoresRepository',
            function () {
                $repository = new \Modules\Proveedores\Repositories\Eloquent\EloquentProveedoresRepository(new \Modules\Proveedores\Entities\Proveedores());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Proveedores\Repositories\Cache\CacheProveedoresDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Proveedores\Repositories\Proveedor_MaterialesRepository',
            function () {
                $repository = new \Modules\Proveedores\Repositories\Eloquent\EloquentProveedor_MaterialesRepository(new \Modules\Proveedores\Entities\Proveedor_Materiales());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Proveedores\Repositories\Cache\CacheProveedor_MaterialesDecorator($repository);
            }
        );
// add bindings


    }
}
