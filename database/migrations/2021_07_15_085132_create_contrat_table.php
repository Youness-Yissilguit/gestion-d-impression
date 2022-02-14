<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrat', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 25);
            $table->timestamp('date_debut')->useCurrent();
            $table->integer('duree');
            $table->integer('perio_facturation');
            $table->integer('cout_c');
            $table->integer('cout_nb');
            $table->integer('id_imprimante')->index('imprimante_id');
            $table->integer('id_fournisseur')->index('fournisseur_id');
            $table->integer('type')->nullable()->index('type_d');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrat');
    }
}
