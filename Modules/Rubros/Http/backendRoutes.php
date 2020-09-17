<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/rubros'], function (Router $router) {
    $router->bind('categorias_rubro', function ($id) {
        return app('Modules\Rubros\Repositories\Categorias_RubroRepository')->find($id);
    });
    $router->get('categorias_rubros', [
        'as' => 'admin.rubros.categorias_rubro.index',
        'uses' => 'Categorias_RubroController@index',
        'middleware' => 'can:rubros.categorias_rubros.index'
    ]);
    $router->get('categorias_rubros/create', [
        'as' => 'admin.rubros.categorias_rubro.create',
        'uses' => 'Categorias_RubroController@create',
        'middleware' => 'can:rubros.categorias_rubros.create'
    ]);
    $router->post('categorias_rubros', [
        'as' => 'admin.rubros.categorias_rubro.store',
        'uses' => 'Categorias_RubroController@store',
        'middleware' => 'can:rubros.categorias_rubros.store'
    ]);
    $router->get('categorias_rubros/{categorias_rubro}/edit', [
        'as' => 'admin.rubros.categorias_rubro.edit',
        'uses' => 'Categorias_RubroController@edit',
        'middleware' => 'can:rubros.categorias_rubros.edit'
    ]);
    $router->put('categorias_rubros/{categorias_rubro}', [
        'as' => 'admin.rubros.categorias_rubro.update',
        'uses' => 'Categorias_RubroController@update',
        'middleware' => 'can:rubros.categorias_rubros.update'
    ]);
    $router->delete('categorias_rubros/{categorias_rubro}', [
        'as' => 'admin.rubros.categorias_rubro.destroy',
        'uses' => 'Categorias_RubroController@destroy',
        'middleware' => 'can:rubros.categorias_rubros.destroy'
    ]);
    $router->bind('rubros', function ($id) {
        return app('Modules\Rubros\Repositories\RubrosRepository')->find($id);
    });
    $router->get('rubros', [
        'as' => 'admin.rubros.rubros.index',
        'uses' => 'RubrosController@index',
        'middleware' => 'can:rubros.rubros.index'
    ]);
    $router->get('rubros/create', [
        'as' => 'admin.rubros.rubros.create',
        'uses' => 'RubrosController@create',
        'middleware' => 'can:rubros.rubros.create'
    ]);
    $router->post('rubros', [
        'as' => 'admin.rubros.rubros.store',
        'uses' => 'RubrosController@store',
        'middleware' => 'can:rubros.rubros.store'
    ]);
    $router->get('rubros/{rubros}/edit', [
        'as' => 'admin.rubros.rubros.edit',
        'uses' => 'RubrosController@edit',
        'middleware' => 'can:rubros.rubros.edit'
    ]);
    $router->put('rubros/{rubros}', [
        'as' => 'admin.rubros.rubros.update',
        'uses' => 'RubrosController@update',
        'middleware' => 'can:rubros.rubros.update'
    ]);
    $router->delete('rubros/{rubros}', [
        'as' => 'admin.rubros.rubros.destroy',
        'uses' => 'RubrosController@destroy',
        'middleware' => 'can:rubros.rubros.destroy'
    ]);
    $router->post('rubros/index-rubros', [
        'as' => 'admin.rubros.rubros.index-ajax',
        'uses' => 'RubrosController@index_ajax',
        'middleware' => 'can:rubros.rubros.index'
    ]);
    $router->get('rubros/search-rubro', [
        'as' => 'admin.rubros.rubros.search-rubro',
        'uses' => 'RubrosController@search_rubro'
    ]);
    $router->get('rubros/search-material', [
        'as' => 'admin.rubros.rubros.search-material',
        'uses' => 'RubrosController@search_material'
    ]);
    $router->post('rubros/validate-rubro', [
        'as' => 'admin.rubros.rubros.validate-rubro',
        'uses' => 'RubrosController@validate_rubro'
    ]);
    $router->bind('rubro_materiales', function ($id) {
        return app('Modules\Rubros\Repositories\Rubro_MaterialesRepository')->find($id);
    });
    $router->get('rubro_materiales', [
        'as' => 'admin.rubros.rubro_materiales.index',
        'uses' => 'Rubro_MaterialesController@index',
        'middleware' => 'can:rubros.rubro_materiales.index'
    ]);
    $router->get('rubro_materiales/create', [
        'as' => 'admin.rubros.rubro_materiales.create',
        'uses' => 'Rubro_MaterialesController@create',
        'middleware' => 'can:rubros.rubro_materiales.create'
    ]);
    $router->post('rubro_materiales', [
        'as' => 'admin.rubros.rubro_materiales.store',
        'uses' => 'Rubro_MaterialesController@store',
        'middleware' => 'can:rubros.rubro_materiales.store'
    ]);
    $router->get('rubro_materiales/{rubro_materiales}/edit', [
        'as' => 'admin.rubros.rubro_materiales.edit',
        'uses' => 'Rubro_MaterialesController@edit',
        'middleware' => 'can:rubros.rubro_materiales.edit'
    ]);
    $router->put('rubro_materiales/{rubro_materiales}', [
        'as' => 'admin.rubros.rubro_materiales.update',
        'uses' => 'Rubro_MaterialesController@update',
        'middleware' => 'can:rubros.rubro_materiales.update'
    ]);
    $router->delete('rubro_materiales/{rubro_materiales}', [
        'as' => 'admin.rubros.rubro_materiales.destroy',
        'uses' => 'Rubro_MaterialesController@destroy',
        'middleware' => 'can:rubros.rubro_materiales.destroy'
    ]);
});
