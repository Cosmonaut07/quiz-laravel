<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_user_id');
            $table->tinyInteger('quiz_type');
            $table->boolean('is_active');
            $table->integer('score')->default(0);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('submit_time')->nullable();
            $table->timestamps();
            $table->foreign('guest_user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_entries');
    }
};
