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
        Schema::create('project_flights', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            $table->string('project_slug');

            $table->foreign(['locale', 'project_slug'])
                ->references(['locale', 'slug'])
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->integer('order')->default('1');
            $table->boolean('display')->default('0');
            $table->string('date')->nullable();
            $table->text('description')->nullable();

            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_flights');
    }
};
