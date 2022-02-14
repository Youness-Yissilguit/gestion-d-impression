<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->integer('ticket_id', true);
            $table->string('titre', 25);
            $table->string('description');
            $table->string('statue', 25);
            $table->string('priorite', 25);
            $table->string('type', 25);
            $table->date('date_ouvert');
            $table->date('date_limit');
            $table->integer('categorie')->nullable()->index('cat_id');
            $table->integer('attribu_to')->nullable()->index('atribu_to_id');
            $table->integer('created_by')->nullable()->index('created_by_id');
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
        Schema::dropIfExists('tickets');
    }
}
