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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('institution_id')->constrained()->onDelete('cascade'); // Foreign Key
            $table->string('name');
            $table->timestamps();
    });

    /**
     * Reverse the migrations.
     */
}
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};