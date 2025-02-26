
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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing primary key
            $table->string('id_identify', 14)->unique(); // Unique identifier, exactly 14 characters
            $table->string('id_identify_image'); // Corrected typo: 'id_identify_iamge' to 'id_identify_image'
            $table->string('fullname')->unique(); // Full name, unique
            $table->string('email')->unique(); // Email, unique
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->string('password'); // Password
            $table->rememberToken(); // Remember token for "remember me" functionality
            $table->integer('age')->unsigned(); // Age, unsigned integer
            $table->string('phone', 11)->unique(); // Phone number, exactly 11 characters, unique
            $table->string('image'); // Profile image path or filename
            $table->enum('role', ['landlord', 'tenant'])->default('tenant'); // Role, default is 'tenant'
            $table->timestamps(); // Created_at and updated_at timestamps
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
