<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use WouterJ\EloquentBundle\Facade\Schema;

class CreatePlayerCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_cards', function (Blueprint $table) {
            $table->id();
            $table->addColumn('int', 'player_id');
            $table->addColumn('int', 'card_id');
            $table->addColumn('tinyint', 'is_hidden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_cards');
    }
}
