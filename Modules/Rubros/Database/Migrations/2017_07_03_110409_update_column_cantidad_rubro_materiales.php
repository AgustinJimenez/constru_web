<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnCantidadRubroMateriales extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rubros__rubro_materiales', function(Blueprint $table)
        {
            $table->dropColumn('cantidad');
            $table->double('cantidad', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rubros__rubro_materiales', function(Blueprint $table)
        {
            $table->dropColumn('cantidad');
            $table->integer('cantidad');
        });
    }

}
