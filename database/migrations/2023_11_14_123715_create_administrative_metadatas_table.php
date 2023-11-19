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
        Schema::create('administrative_metadatas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('action_type', ['read', 'modify', 'delete', 'download']);
            $table->dateTime('datetime');
            $table->foreignId('document_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_metadatas');
    }
};
