<?php namespace Modules\Materiales\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FakesMaterialesSeeder extends Seeder 
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
			\Materiales::create
			([
				"nombre" => $generate->unique()->domainWord." ".$generate->citySuffix ,
				"unidad_medida" => $generate->randomElement(["cm","m","mm","inch"]),
				"precio_unitario" => $generate->numberBetween($min = 30000, $max = 500000)
			]);
	}

	public function max_items()
	{
		return $this->max_items;
	}

}