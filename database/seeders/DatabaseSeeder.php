<?php
use Illuminate\Database\Seeder;
use App\Models\Property;
use Database\Seeders\PropertySeeder;
use App\Models\User;
use App\Models\Contract;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContractSeeder;
// use Database\Seeders\PropertySeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ContractSeeder::class,
            PropertySeeder::class,

        ]);

        $users = User::factory()->count(20)->create(); // Create 5 landlords
        $properties = Property::factory()->count(10)->create(); // Create 10 properties

        // Attach each property to random landlords
        foreach ($properties as $property) {
            // تحديد الملاك
            $landlords = $users->random(rand(1, 3));
            foreach ($landlords as $landlord) {
                $property->users()->attach($landlord->id, ['role' => 'landlord']);
            }

            // تحديد مستأجر واحد عشوائيًا
            $tenant = $users->where('role', 'tenant')->random(1)->first();
            if ($tenant) {
                $property->users()->attach($tenant->id, ['role' => 'tenant']);
            }
        }



    }
}
