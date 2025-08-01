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
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            // $table->string('locale')->default('tw');
            $table->string('type')->nullable(); // 來源表單位置

            $table->string('title'); // 主旨
            $table->string('slug')->nullable(); // 可能用來當唯一識別碼（例如日期+email）
            // $table->string('tag')->nullable(); // 類別分類，可選

            $table->string('email')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->longText('info')->nullable();
            $table->longText('content')->nullable(); // 訊息內容
            $table->longText('intro')->nullable();

            $table->string('send_ip')->nullable();
            $table->string('send_status')->default('success'); // 可為 success / failed 等

            $table->string('fixuser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_logs');
    }
};
