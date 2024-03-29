<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
        });

        Schema::create('department_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('department_id')->constrained();
        });

        Schema::create('department_document', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('view');
            $table->boolean('update');
            $table->boolean('delete');
            $table->boolean('download');
            $table->foreignId('document_id')->constrained();
            $table->foreignId('department_id')->constrained();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('department_user');
        Schema::dropIfExists('department_document');
    }
};
