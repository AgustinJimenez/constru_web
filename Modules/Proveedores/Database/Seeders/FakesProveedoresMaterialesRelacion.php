<?php namespace Modules\Proveedores\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Materiales\Database\Seeders\FakesMaterialesSeeder;
use Modules\Proveedores\Database\Seeders\FakesProveedoresSeeder;

class FakesProveedoresMaterialesRelacion extends Seeder 
{
	//public $max_id_materiales = FakesMaterialesSeeder::max_items();
	//public $max_id_proveedores = FakesProveedoresSeeder::max_items();
	public $max_items = 300;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		for ($i = 0; $i < $this->max_items; $i++) 
			\Proveedor_Materiales::create
			([
				"proveedor_id" => \Proveedores::orderByRaw("RAND()")->first()->id,
				"material_id" => \Materiales::orderByRaw("RAND()")->first()->id
			]);
	}

	public function max_items()
	{
		return $this->max_items;
	}

}