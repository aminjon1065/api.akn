<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('files_link');
            $table->unsignedBigInteger('user_id');
            $table->boolean('opened')->default('0');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('from');
            $table->foreign('from')->references('id')->on('users');
            $table->unsignedBigInteger('to');
            $table->foreign('to')->references('id')->on('users');
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
        Schema::dropIfExists('messages');
    }
}
