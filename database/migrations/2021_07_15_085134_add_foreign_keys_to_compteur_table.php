<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCompteurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compteur', function (Blueprint $table) {
            $table->foreign('id_imp', 'imp_id_cmpt')->references('id_imprt')->on('imprimante')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compteur', function (Blueprint $table) {
            $table->dropForeign('imp_id_cmpt');
        });
    }
}
