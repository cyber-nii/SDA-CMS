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
        // 1. Members
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('contact_number', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->date('baptism_date')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Transferred', 'Deceased'])->default('Active');
            $table->timestamps();
        });

        // 2. Departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id');
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Member Departments (Pivot)
        Schema::create('member_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('department_id');
            $table->string('role', 50)->default('Member');
            $table->date('joined_date')->nullable();

            $table->primary(['member_id', 'department_id']);
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });

        // 4. Tithes
        Schema::create('tithes', function (Blueprint $table) {
            $table->id('tithe_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('date_received');
            $table->string('receipt_number', 50)->unique();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->foreign('member_id')->references('member_id')->on('members')->nullOnDelete();
        });

        // 5. Offerings
        Schema::create('offerings', function (Blueprint $table) {
            $table->id('offering_id');
            $table->string('category', 75);
            $table->decimal('amount', 10, 2);
            $table->date('date_received');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 6. Donations
        Schema::create('donations', function (Blueprint $table) {
            $table->id('donation_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->string('purpose', 100);
            $table->decimal('amount', 10, 2);
            $table->date('date_received');
            $table->string('receipt_number', 50)->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('members')->nullOnDelete();
        });

        // 7. Baptisms
        Schema::create('baptisms', function (Blueprint $table) {
            $table->id('baptism_id');
            $table->unsignedBigInteger('member_id');
            $table->date('baptism_date');
            $table->string('pastor_name', 100);
            $table->string('location', 150)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('members')->cascadeOnDelete();
        });

        // 8. Transfers
        Schema::create('transfers', function (Blueprint $table) {
            $table->id('transfer_id');
            $table->unsignedBigInteger('member_id');
            $table->enum('transfer_type', ['In', 'Out']);
            $table->string('from_church', 150)->nullable();
            $table->string('to_church', 150)->nullable();
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Completed', 'Rejected'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('members')->cascadeOnDelete();
        });

        // 9. Documents
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->string('file_path', 255);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 10. Announcements
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->string('title', 150);
            $table->text('content');
            $table->date('publish_date');
            $table->date('expiry_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 11. Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 100);
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('transfers');
        Schema::dropIfExists('baptisms');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('offerings');
        Schema::dropIfExists('tithes');
        Schema::dropIfExists('member_departments');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('members');
    }
};
