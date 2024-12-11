<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id')->on('users');
            $table->string('title');
            $table->unsignedBigInteger('scientific_group');
            $table->foreign('scientific_group')->references('id')->on('scientific_groups');
            $table->unsignedBigInteger('post_format');
            $table->foreign('post_format')->references('id')->on('post_formats');
            $table->text('description')->nullable();
            $table->string('status')->default('ارسال به مدیر پژوهش');
            $table->unsignedBigInteger('adder')->nullable();
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
