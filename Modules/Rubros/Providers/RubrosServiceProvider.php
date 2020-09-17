<?php namespace Modules\Rubros\Providers;

use Illuminate\Support\ServiceProvider;

class RubrosServiceProvider extends ServiceProvider
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
            'Modules\Rubros\Repositories\Categorias_RubroRepository',
            function () {
                $repository = new \Modules\Rubros\Repositories\Eloquent\EloquentCategorias_RubroRepository(new \Modules\Rubros\Entities\Categorias_Rubro());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Rubros\Repositories\Cache\CacheCategorias_RubroDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Rubros\Repositories\RubrosRepository',
            function () {
                $repository = new \Modules\Rubros\Repositories\Eloquent\EloquentRubrosRepository(new \Modules\Rubros\Entities\Rubros());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Rubros\Repositories\Cache\CacheRubrosDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Rubros\Repositories\Rubro_MaterialesRepository',
            function () {
                $repository = new \Modules\Rubros\Repositories\Eloquent\EloquentRubro_MaterialesRepository(new \Modules\Rubros\Entities\Rubro_Materiales());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Rubros\Repositories\Cache\CacheRubro_MaterialesDecorator($repository);
            }
        );
// add bindings



    }
}
