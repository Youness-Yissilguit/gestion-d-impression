<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->integer('user_id', true);
            $table->string('nome', 25);
            $table->string('prenom', 25);
            $table->integer('telephone');
            $table->integer('telephone_mobile');
            $table->string('identifiant', 25);
            $table->string('mode_de_pass', 25);
            $table->string('role', 25);
            $table->integer('created_by')->nullable()->index('created_by');
            $table->timestamp('create_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
