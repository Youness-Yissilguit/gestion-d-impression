<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLieuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lieu', function (Blueprint $table) {
            $table->integer('lieu_id', true);
            $table->string('nome', 25);
            $table->string('adress', 25);
            $table->integer('code_postal');
            $table->string('ville', 25);
            $table->string('payer', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lieu');
    }
}
