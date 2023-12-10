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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->boolean('create_user');
            $table->boolean('manage_user');
            $table->boolean('delete_user');
            $table->boolean('create_department');
            $table->boolean('delete_department');
            $table->boolean('access_admin_dashboard');
        });

        Schema::create('profile_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('profile_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('profile_user');
    }
};
