<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresProveedoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proveedores__proveedores', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 500)->unique();
            $table->string('direccion', 500);
            $table->string('direccion_web', 40);
            $table->text('direccion_map');
            $table->string('nro_telefono');
            $table->string('celular');
            $table->string('email');
            //$table->softDeletes();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('proveedores__proveedores');
	}
}
