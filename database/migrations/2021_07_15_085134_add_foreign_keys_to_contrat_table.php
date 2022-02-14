<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToContratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrat', function (Blueprint $table) {
            $table->foreign('id_fournisseur', 'fournisseur_id')->references('f_id')->on('fournisseur');
            $table->foreign('id_imprimante', 'imprimante_id')->references('id_imprt')->on('imprimante');
            $table->foreign('type', 'type_d')->references('type_id')->on('type_cntr')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrat', function (Blueprint $table) {
            $table->dropForeign('fournisseur_id');
            $table->dropForeign('imprimante_id');
            $table->dropForeign('type_d');
        });
    }
}
