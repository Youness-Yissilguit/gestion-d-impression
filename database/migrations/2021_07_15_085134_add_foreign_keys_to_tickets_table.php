<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('attribu_to', 'atribu_to_id')->references('user_id')->on('user')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('categorie', 'cat_id')->references('cat_id')->on('categorie')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign('created_by', 'created_by_id')->references('user_id')->on('user')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('atribu_to_id');
            $table->dropForeign('cat_id');
            $table->dropForeign('created_by_id');
        });
    }
}
