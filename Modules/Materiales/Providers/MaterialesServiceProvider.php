<?php namespace Modules\Materiales\Providers;

use Illuminate\Support\ServiceProvider;

class MaterialesServiceProvider extends ServiceProvider
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
            'Modules\Materiales\Repositories\MaterialesRepository',
            function () {
                $repository = new \Modules\Materiales\Repositories\Eloquent\EloquentMaterialesRepository(new \Modules\Materiales\Entities\Materiales());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Materiales\Repositories\Cache\CacheMaterialesDecorator($repository);
            }
        );
// add bindings

    }
}
