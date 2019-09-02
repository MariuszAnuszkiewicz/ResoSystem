<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_order', function (Blueprint $table) {
            $table->bigInteger('music_id');
            $table->bigInteger('order_id');
            $table->integer('quantity')->nullable();
            $table->decimal('price', 6, 2)->nullable();
            $table->foreign('book_id')->references('id')->on('musics');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('music_order');
    }
}
