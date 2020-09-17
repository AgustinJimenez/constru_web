<?php namespace Modules\Proveedores\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FakesProveedoresSeeder extends Seeder 
{
	public $max_items = 300;
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$generate = \Faker::create();
		for ($i = 0; $i < $this->max_items; $i++) 
			\Proveedores::create
			([
				"nombre" => $generate->unique()->company." ".$generate->companySuffix,
				"direccion" => $generate->address,
				"direccion_web" => /*$generate->freeEmailDomain*/"https://es.stackoverflow.com/questions/" . $generate->numberBetween(1, 50000),
				"direccion_map" => $generate->latitude($min = -90, $max = 90) . "," . $generate->longitude($min = -180, $max = 180),
				"nro_telefono" => "021" . $generate->numberBetween(99999, 999999),
				"celular" => "09" . $generate->randomElement(["6","7","8","9"]) . $generate->numberBetween(1, 5) . $generate->numberBetween(99999, 999999),
				"email" => $generate->companyEmail
			]);
	}
	public function max_items()
	{
		return $this->max_items;
	}

}