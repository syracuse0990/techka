<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AddressSeeder::class,
        ]);

        $checkExits = User::where('email', 'techka@gmail.com')->exists();
        if(!$checkExits){
            User::factory()->create([
                'role_id' => 1,
                'first_name' => 'Cyrus',
                'last_name' => 'Viilaray',
                'middle_name' => '',
                'online' => false,
                'email' => 'techka@gmail.com',
                'password' => Hash::make('asdasd123'),
            ]);
        }
    }
}
