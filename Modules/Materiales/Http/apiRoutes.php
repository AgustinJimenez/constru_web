<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' => 'api/v1', 'middleware' => 'api_token'], function (Router $router) 
{
    $router->bind('id', function ($id) 
    {
        return \Materiales::find($id);
    });
    $router->bind('id_proveedor', function ($id_proveedor) 
    {
        return \Proveedores::find($id_proveedor);
    });

    $locale = LaravelLocalization::setLocale() ?: App::getLocale();
    
    $router->get('materiales/index', ['uses' => 'ApiController@index_materiales']);

    $router->get('materiales/material/proveedores/{id}', ['uses' => 'ApiController@material_proveedores']);

    $router->get('proveedores/index', ['uses' => 'ApiController@proveedores_index']);

    $router->get('proveedores/proveedor/{id_proveedor}', ['uses' => 'ApiController@proveedor']);

    $router->get('categorias_rubros', ['uses' => 'ApiController@categorias_with_rubros']);
});
