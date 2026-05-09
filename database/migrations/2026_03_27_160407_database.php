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
        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->text('password')->nullable();
            $table->json('groups')->nullable();
            $table->string('type', 20)->nullable();
            $table->boolean('enabled')->default(1);
            $table->rememberToken();

            $table->primary('username');
        });
        
        // Password resets
        Schema::create('password_resets', function (Blueprint $table) {
            $table->char('token', 64);
            $table->string('user_username');
            $table->timestamp('expiration');
            $table->timestamp('created')->useCurrent();
            
            $table->primary('token');
            $table->foreign('user_username')->references('username')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        
        // Form Requests
        Schema::create('form_requests', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('type', 30);
            $table->string('first_name');
            $table->string('last_name');
            $table->char('language', 2);
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->text('request');
            $table->json('data')->nullable();
            $table->boolean('privacy');
            $table->timestamp('created')->useCurrent();
            
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
