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
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط المستخدمين
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // ربط العقارات
            $table->enum('role', ['landlord', 'tenant']); // تحديد هل المستخدم مالك أم مستأجر
            $table->timestamp('start_date')->nullable(); // تاريخ بداية العقد
            $table->timestamp('end_date')->nullable(); // تاريخ نهاية العقد
            $table->timestamps();
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_user');
    }
};
