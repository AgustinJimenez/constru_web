<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/proveedores'], function (Router $router) {
    $router->bind('proveedores', function ($id) {
        return app('Modules\Proveedores\Repositories\ProveedoresRepository')->find($id);
    });
    $router->get('proveedores', [
        'as' => 'admin.proveedores.proveedores.index',
        'uses' => 'ProveedoresController@index',
        'middleware' => 'can:proveedores.proveedores.index'
    ]);
    $router->get('proveedores/create', [
        'as' => 'admin.proveedores.proveedores.create',
        'uses' => 'ProveedoresController@create',
        'middleware' => 'can:proveedores.proveedores.create'
    ]);
    $router->post('proveedores', [
        'as' => 'admin.proveedores.proveedores.store',
        'uses' => 'ProveedoresController@store',
        'middleware' => 'can:proveedores.proveedores.store'
    ]);
    $router->get('proveedores/{proveedores}/edit', [
        'as' => 'admin.proveedores.proveedores.edit',
        'uses' => 'ProveedoresController@edit',
        'middleware' => 'can:proveedores.proveedores.edit'
    ]);
    $router->put('proveedores/{proveedores}', [
        'as' => 'admin.proveedores.proveedores.update',
        'uses' => 'ProveedoresController@update',
        'middleware' => 'can:proveedores.proveedores.update'
    ]);
    $router->delete('proveedores/{proveedores}', [
        'as' => 'admin.proveedores.proveedores.destroy',
        'uses' => 'ProveedoresController@destroy',
        'middleware' => 'can:proveedores.proveedores.destroy'
    ]);
    $router->post('proveedores/index-ajax', [
        'as' => 'admin.proveedores.proveedores.index-ajax',
        'uses' => 'ProveedoresController@index_ajax',
        'middleware' => 'can:proveedores.proveedores.index'
    ]);
    $router->get('proveedores/search-proveedor', [
        'as' => 'admin.proveedores.proveedores.search-proveedor',
        'uses' => 'ProveedoresController@search_proveedor'
    ]);
    $router->get('proveedores/proveedor-materiales/{proveedores}', [
        'as' => 'admin.proveedores.proveedores.proveedor-materiales',
        'uses' => 'ProveedoresController@proveedor_materiales',
        'middleware' => 'can:proveedores.proveedores.edit'
    ]);
    $router->post('proveedores/index-materiales', [
        'as' => 'admin.proveedores.proveedores.index-materiales',
        'uses' => 'ProveedoresController@index_materiales',
        'middleware' => 'can:proveedores.proveedores.index'
    ]);
    $router->post('proveedores/save-material', [
        'as' => 'admin.proveedores.proveedores.save-material',
        'uses' => 'ProveedoresController@save_material',
        'middleware' => 'can:proveedores.proveedores.edit'
    ]);
    $router->bind('proveedor_materiales', function ($id) {
        return app('Modules\Proveedores\Repositories\Proveedor_MaterialesRepository')->find($id);
    });
    $router->get('proveedor_materiales', [
        'as' => 'admin.proveedores.proveedor_materiales.index',
        'uses' => 'Proveedor_MaterialesController@index',
        'middleware' => 'can:proveedores.proveedor_materiales.index'
    ]);
    $router->get('proveedor_materiales/create', [
        'as' => 'admin.proveedores.proveedor_materiales.create',
        'uses' => 'Proveedor_MaterialesController@create',
        'middleware' => 'can:proveedores.proveedor_materiales.create'
    ]);
    $router->post('proveedor_materiales', [
        'as' => 'admin.proveedores.proveedor_materiales.store',
        'uses' => 'Proveedor_MaterialesController@store',
        'middleware' => 'can:proveedores.proveedor_materiales.store'
    ]);
    $router->get('proveedor_materiales/{proveedor_materiales}/edit', [
        'as' => 'admin.proveedores.proveedor_materiales.edit',
        'uses' => 'Proveedor_MaterialesController@edit',
        'middleware' => 'can:proveedores.proveedor_materiales.edit'
    ]);
    $router->put('proveedor_materiales/{proveedor_materiales}', [
        'as' => 'admin.proveedores.proveedor_materiales.update',
        'uses' => 'Proveedor_MaterialesController@update',
        'middleware' => 'can:proveedores.proveedor_materiales.update'
    ]);
    $router->delete('proveedor_materiales/{proveedor_materiales}', [
        'as' => 'admin.proveedores.proveedor_materiales.destroy',
        'uses' => 'Proveedor_MaterialesController@destroy',
        'middleware' => 'can:proveedores.proveedor_materiales.destroy'
    ]);
// append


});
