<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orioks_scores', function (Blueprint $table) {
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('orioks_users')->onDelete('cascade');
            $table->integer('subject_id');
            $table->string('subject_name');
            $table->integer('control_event_id');
            $table->string('control_event_name');
            $table->string('user_score');
            $table->primary(['user_id','subject_id','control_event_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orioks_scores');
    }
};
