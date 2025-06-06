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
        Schema::create('property_user', function (Blueprint $table) {
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ✅ استبدل landlord_id بـ user_id
            $table->enum('role', ['landlord', 'tenant']); // ✅ لمعرفة دور المستخدم في العقار
            $table->primary(['property_id','user_id']); // في حال كنت تريد مفتاح مركب
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_user');
    }
};
