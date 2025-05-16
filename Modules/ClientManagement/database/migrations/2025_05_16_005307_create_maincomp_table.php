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
        Schema::create('maincomp', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('client_name');
            $table->foreignId('status')->constrained('refstat')->onDelete('restrict');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('client_type', ['individual', 'company']);
            $table->timestamps();
            $table->integer('updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maincomp');
    }
};
