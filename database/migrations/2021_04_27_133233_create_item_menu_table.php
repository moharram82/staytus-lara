<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_menu', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('menu_id');

            $table->primary(['item_id', 'menu_id']);

            $table->foreign('item_id', 'fk_item_menu_items_item_id')->references('id')->on('items')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('menu_id', 'fk_item_menu_menus_menu_id')->references('id')->on('menus')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_menu');
    }
}
