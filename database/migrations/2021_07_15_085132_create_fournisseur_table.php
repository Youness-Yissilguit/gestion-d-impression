<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseur', function (Blueprint $table) {
            $table->integer('f_id', true);
            $table->string('nome', 25);
            $table->integer('prenom');
            $table->integer('fax');
            $table->string('ville', 25);
            $table->integer('code_postal');
            $table->string('adresse');
            $table->integer('created_by')->nullable()->index('created_by_fourn');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fournisseur');
    }
}
