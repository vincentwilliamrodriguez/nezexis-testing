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
        Schema::create('compbrch', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name');
            $table->foreignId('client_id')->constrained('maincomp')->onDelete('cascade');
            $table->foreignId('status')->constrained('refstat')->onDelete('restrict');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->timestamps();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compbrch');
    }
};
