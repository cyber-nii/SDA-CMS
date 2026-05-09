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
            
            DB::statement("INSERT INTO users SELECT * FROM users_old");
            DB::statement("DROP TABLE users_old");
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader', 'Funds Controller') DEFAULT 'Clerk'");
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
            DB::statement("ALTER TABLE users RENAME TO users_old");
            
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username', 50)->unique();
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->enum('role', ['Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader'])->default('Clerk');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
            
            DB::statement("INSERT INTO users SELECT * FROM users_old");
            DB::statement("DROP TABLE users_old");
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Super Admin', 'Pastor', 'Clerk', 'Treasurer', 'Head Elder', 'Department Leader') DEFAULT 'Clerk'");
        }
    }
};
