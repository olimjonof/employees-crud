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
        Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('firstName', 100);
        $table->string('lastName', 100);
        $table->string('email', 191)->unique();
        $table->string('phone', 30)->nullable();
        $table->string('position', 120)->nullable();
        $table->decimal('salary', 10, 2)->default(0);
        $table->date('hired_at')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
