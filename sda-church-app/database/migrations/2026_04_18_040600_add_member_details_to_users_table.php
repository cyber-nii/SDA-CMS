<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support MODIFY COLUMN, so we need to recreate the table
            DB::statement("DROP INDEX IF EXISTS users_username_unique");
            DB::statement("DROP INDEX IF EXISTS users_email_unique");
            DB::statement("ALTER TABLE users RENAME TO users_old");
            
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('member_id')->nullable();
                $table->string('username', 50)->unique();
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->enum('role', ['Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller', 'Member'])->default('Member');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->boolean('must_change_password')->default(false);
                $table->rememberToken();
                $table->timestamps();
            });
            
            DB::statement("INSERT INTO users (id, username, first_name, last_name, role, email, email_verified_at, password, remember_token, created_at, updated_at) 
                          SELECT id, username, first_name, last_name, role, email, email_verified_at, password, remember_token, created_at, updated_at FROM users_old");
            DB::statement("DROP TABLE users_old");
            
            // Add the foreign key separately if members table exists
            if (Schema::hasTable('members')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreign('member_id')->references('member_id')->on('members')->onDelete('set null');
                });
            }
        } else {
            // 1. Update the 'role' enum to include 'Member'
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller', 'Member') DEFAULT 'Member'");

            // 2. Add member_id and must_change_password
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('member_id')->nullable()->after('id');
                $table->boolean('must_change_password')->default(false)->after('password');
            });

            // 3. Add foreign key index
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('member_id')->references('member_id')->on('members')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            DB::statement("DROP INDEX IF EXISTS users_username_unique");
            DB::statement("DROP INDEX IF EXISTS users_email_unique");
            DB::statement("DROP INDEX IF EXISTS users_member_id_foreign");
            DB::statement("ALTER TABLE users RENAME TO users_old");
            
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username', 50)->unique();
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->enum('role', ['Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller'])->default('Clerk');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
            
            DB::statement("INSERT INTO users (id, username, first_name, last_name, role, email, email_verified_at, password, remember_token, created_at, updated_at) 
                          SELECT id, username, first_name, last_name, role, email, email_verified_at, password, remember_token, created_at, updated_at FROM users_old");
            DB::statement("DROP TABLE users_old");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['member_id']);
            });

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['member_id', 'must_change_password']);
            });

            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller') DEFAULT 'Clerk'");
        }
    }
};
