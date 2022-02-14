<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToImprimanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imprimante', function (Blueprint $table) {
            $table->foreign('lieu_instal', 'lieu_instal')->references('lieu_id')->on('lieu')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('model', 'modele_id')->references('id')->on('modele')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('reseau', 'reseau_id')->references('id')->on('reseau')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('type', 'type_id')->references('type_id_imp')->on('type_imp')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('utilisateur', 'utilisateur_id')->references('user_id')->on('user')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imprimante', function (Blueprint $table) {
            $table->dropForeign('lieu_instal');
            $table->dropForeign('modele_id');
            $table->dropForeign('reseau_id');
            $table->dropForeign('type_id');
            $table->dropForeign('utilisateur_id');
        });
    }
}
