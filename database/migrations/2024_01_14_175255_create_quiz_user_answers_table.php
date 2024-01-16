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
        Schema::create('quiz_user_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_entry_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('choice_id');
            $table->foreign('quiz_entry_id')->references('id')->on('quiz_entries')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('choice_id')->references('id')->on('question_choices')->onDelete('cascade');
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
        Schema::dropIfExists('quiz_user_answers');
    }
};
