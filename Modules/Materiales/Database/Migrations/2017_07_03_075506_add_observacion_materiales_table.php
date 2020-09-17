<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObservacionMaterialesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materiales__materiales', function(Blueprint $table)
        {
            $table->string('observacion', 1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materiales__materiales', function(Blueprint $table)
        {
            $table->dropColumn('observacion', 1000);
        });
    }

}