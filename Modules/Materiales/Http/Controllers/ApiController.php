<?php namespace Modules\Materiales\Http\Controllers;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;

class ApiController extends AdminBaseController 
{
	public $debug = [ "now" => false, "with_lorem_images" => false ];
	
	public function index_materiales(Request $re)
	{
		$materiales = \Materiales::where('nombre', 'like', "%{$re->get('params')}%")
						->orderBy('nombre', "asc")
						->select('id', 'nombre'/*, 'unidad_medida', 'precio_unitario'*/)
						->get();

		return response()->json( $materiales );
	}

	public function material_proveedores(\Materiales $material)
	{
		$proveedores = array();
		foreach ($material->proveedores as $key => $proveedor) 
		{
			$proveedor->latitud = $proveedor->latitud;
			$proveedor->longitud = $proveedor->longitud;
			if( $this->debug["now"] and $this->debug["with_lorem_images"] ):
				$generate = \Faker::create();
				$proveedor->imagen_url = $generate->imageUrl($width = $generate->numberBetween(600, 1000), $height = $generate->numberBetween(600, 1000));
			;else:
				$proveedor->imagen_url = $proveedor->imagen;
			endif;

			$proveedores[] = collect($proveedor)->only('id','nombre', 'direccion', 'latitud', 'longitud', 'direccion_web', 'nro_telefono', 'email', 'imagen_url')->toArray();
		}
		return response()->json( $proveedores );
	}

	public function proveedores_index(Request $re)
	{
		$proveedores = \Proveedores::where('nombre', 'like', "%{$re->get('params')}%")
					->orderBy('nombre', "asc")
					->select('id', 'nombre')
					->get();
		return response()->json( $proveedores );
	}

	public function proveedor(\Proveedores $proveedor)
	{
		$proveedor->latitud = $proveedor->latitud;
		$proveedor->longitud = $proveedor->longitud;
		if( $this->debug["now"] and $this->debug["with_lorem_images"] ):
			$generate = \Faker::create();
			$proveedor->imagen_url = $generate->imageUrl($width = $generate->numberBetween(600, 1000), $height = $generate->numberBetween(600, 1000));
		;else:
			$proveedor->imagen_url = $proveedor->imagen;
		endif;
		
		return response()->json( $proveedor );
	}

	public function categorias_with_rubros()
	{
		$categorias_rubros = \Categorias_Rubro::with(['rubros' => function($rubro)
		{
			$rubro->with(['rubro_materiales' => function($rubro_material)
			{
				$rubro_material->with(['material' => function($material)
				{
					$material->select('id', "nombre", "unidad_medida", 'precio_unitario');
				}])
				->select('id', 'material_id', 'rubro_id', 'cantidad');
			}])
			->select('id', 'categoria_id', 'nombre', 'unidad_medida', 'precio_mano_de_obra');
		}])
		->select('id', "nombre", "numero")
		->orderBy('numero')
		->get();
	//dd($categorias_rubros->toArray() );
		return response()->json( $categorias_rubros );
	}
	
}