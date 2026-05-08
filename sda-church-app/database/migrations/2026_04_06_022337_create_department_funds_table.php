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
        Schema::create('department_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->decimal('amount', 10, 2);
            $table->date('date_received');
            $table->string('receipt_number')->nullable()->unique();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('department_id')->on('departments')->cascadeOnDelete();
            $table->foreign('recorded_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_funds');
    }
};
