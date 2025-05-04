<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['studies', 'sport', 'reading', 'projects', 'health', 'other']);
            $table->enum('visibility', ['private', 'friends', 'public'])->default('private');
            $table->date('deadline')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};