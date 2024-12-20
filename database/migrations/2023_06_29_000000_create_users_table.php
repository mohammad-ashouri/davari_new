<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('family');
            $table->string('username')->unique();
            $table->string('password');
            $table->tinyInteger('type')->comment('
            1 => SuperAdmin
            ');
            $table->string('subject');
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('ntcp')->default(0)->comment('Needs To Change Password');
            $table->text('user_image')->nullable();
            $table->unsignedBigInteger('scientific_group')->nullable();
            $table->rememberToken();
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
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
