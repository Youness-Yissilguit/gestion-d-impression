<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumsInContratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrat', function (Blueprint $table) {
            $table->float('cout_c')->change();
            $table->float('cout_nb')->change();
            $table->date('date_debut')->default(null)->change();
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
            $table->integer('cout_c')->change();
            $table->integer('cout_nb')->change();
            $table->timestamp('date_debut')->useCurrent()->change();
        });
    }
}
