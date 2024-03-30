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
        Schema::create('orioks_users', function (Blueprint $table) {
            $table->integer('id') -> primary();
            $table->string('auth_string');
            $table->integer('last_news_id');
            $table->boolean('isReceivingPerformanceNotifications');
            $table->boolean('isReceivingNewsNotifications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orioks_users');
    }
};
