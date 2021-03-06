<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('channel_id')->unsigned();
            $table->integer('replies_count')->default(0)->unsigned();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->unsignedInteger('best_reply_id')->nullable();
            $table->boolean('locked')->default(false);
            $table->text('body');
            $table->timestamps();

            $table->foreign('best_reply_id')->references('id')->on('replies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
