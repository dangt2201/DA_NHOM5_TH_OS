<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ProductsDemoSeeder;
use Database\Seeders\CategoriesAndBrandsSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            CategoriesAndBrandsSeeder::class,  
            ProductsDemoSeeder::class,      
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('123456'),
                'role' => 1,
                'email_verified_at' => now(),
                'phone' => '0901234567',
        ]);
    }
}
