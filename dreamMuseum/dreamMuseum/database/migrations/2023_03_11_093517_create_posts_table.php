<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->char('title');
            $table->text('description');
            $table->char('img_url', 100);
            $table->foreignId('user_id')->constrained('users');
            $table->char('model_url', 100);
            $table->char('model_type');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamp('created_at')->default(New Expression('NOW()'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
