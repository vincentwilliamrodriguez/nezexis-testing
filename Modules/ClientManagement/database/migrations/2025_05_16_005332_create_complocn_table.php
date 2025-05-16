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
        Schema::create('complocn', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('locatable');
            $table->string('country');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('street_add');
            $table->string('zipcode');
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
        Schema::dropIfExists('complocn');
    }
};
