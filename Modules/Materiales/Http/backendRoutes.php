<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/materiales'], function (Router $router) 
{

    $router->bind('materiales', function ($id) 
    {
        return app('Modules\Materiales\Repositories\MaterialesRepository')->find($id);
    });
    
    $router->get('materiales', [
        'as' => 'admin.materiales.materiales.index',
        'uses' => 'MaterialesController@index',
        'middleware' => 'can:materiales.materiales.index'
    ]);
    $router->get('materiales/create', [
        'as' => 'admin.materiales.materiales.create',
        'uses' => 'MaterialesController@create',
        'middleware' => 'can:materiales.materiales.create'
    ]);
    $router->post('materiales', [
        'as' => 'admin.materiales.materiales.store',
        'uses' => 'MaterialesController@store',
        'middleware' => 'can:materiales.materiales.store'
    ]);
    $router->get('materiales/{materiales}/edit', [
        'as' => 'admin.materiales.materiales.edit',
        'uses' => 'MaterialesController@edit',
        'middleware' => 'can:materiales.materiales.edit'
    ]);
    $router->put('materiales/{materiales}', [
        'as' => 'admin.materiales.materiales.update',
        'uses' => 'MaterialesController@update',
        'middleware' => 'can:materiales.materiales.update'
    ]);
    $router->delete('materiales/{materiales}', [
        'as' => 'admin.materiales.materiales.destroy',
        'uses' => 'MaterialesController@destroy',
        'middleware' => 'can:materiales.materiales.destroy'
    ]);
    $router->post('materiales/index-materiales', [
        'as' => 'admin.materiales.materiales.index-ajax',
        'uses' => 'MaterialesController@index_ajax',
        'middleware' => 'can:materiales.materiales.index'
    ]);
    $router->get('materiales/search-material', [
        'as' => 'admin.materiales.materiales.search-material',
        'uses' => 'MaterialesController@search_material'
    ]);
});
