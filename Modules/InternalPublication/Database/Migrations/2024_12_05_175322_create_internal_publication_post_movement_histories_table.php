<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_publication_post_movement_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p_id');
            $table->foreign('p_id')->references('id')->on('posts');
            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('adder')->nullable();
            $table->foreign('adder')->references('id')->on('users');
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
        Schema::dropIfExists('internal_publication_post_movement_histories');
    }
};
