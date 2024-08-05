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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('password');
            $table->char('login');
            $table->string('description');
            $table->char('photo_url', 100);
            $table->rememberToken();
            $table->foreignId('role_id')->constrained('roles');;

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
