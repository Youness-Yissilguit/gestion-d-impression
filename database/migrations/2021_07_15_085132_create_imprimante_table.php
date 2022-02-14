<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprimanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imprimante', function (Blueprint $table) {
            $table->integer('id_imprt', true);
            $table->string('nome', 25);
            $table->integer('num_serie');
            $table->integer('lieu_instal')->nullable()->index('lieu_instal');
            $table->integer('model')->nullable()->index('modele_id');
            $table->integer('reseau')->nullable()->index('reseau_id');
            $table->integer('type')->nullable()->index('type_id');
            $table->integer('utilisateur')->nullable()->index('utilisateur_id');
            $table->integer('cmpt_inc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imprimante');
    }
}
