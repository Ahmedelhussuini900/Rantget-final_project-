<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        Payment::factory()->count(20)->create(); // إنشاء 20 سجل دفع وهمي
    }
}
