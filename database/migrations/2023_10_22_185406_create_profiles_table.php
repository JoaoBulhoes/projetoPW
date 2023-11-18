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
            $table->boolean('create_user')->default(false);
            $table->boolean('manage_user')->default(false);
            $table->boolean('delete_user')->default(false);
            $table->boolean('create_department')->default(false);
            $table->boolean('delete_department')->default(false);
            $table->boolean('access_admin_dashboard')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
