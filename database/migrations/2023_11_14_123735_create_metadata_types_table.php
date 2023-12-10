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
        Schema::create('metadata_types', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('document_metadata_type', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('value');
            $table->foreignId('document_id')->constrained();
            $table->foreignId('metadata_type_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata_types');
        Schema::dropIfExists('document_metadata_type');
    }
};
