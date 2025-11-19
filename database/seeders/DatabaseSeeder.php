<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product\Category;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call Village seeder first (must be before users)
        $this->call([
            \Database\Seeders\System\SettingSeeder::class,
            \Database\Seeders\Product\CategoryTypeSeeder::class,
            VillageSeeder::class,
        ]);

        // Create SuperAdmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bumdes.com',
            'password' => Hash::make('123'),
            'role' => 'superadmin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin Pusat No. 1',
            'village_id' => null // SuperAdmin tidak terikat desa
        ]);

        // Create Admin for Desa Sendangsari
        $village = \App\Models\Village::first();

        User::create([
            'name' => 'Admin Desa Sendangsari',
            'email' => 'admin@sendangsari.desa.id',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'phone' => '082136547891',
            'address' => $village->address,
            'village_id' => $village->id
        ]);

        // Create regular users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('123'),
            'role' => 'user',
            'phone' => '081234567899',
            'address' => 'Jl. Mawar No. 3, Jakarta',
            'village_id' => null
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('123'),
            'role' => 'user',
            'phone' => '081234567898',
            'address' => 'Jl. Melati No. 5, Bandung',
            'village_id' => null
        ]);

        // Products will be created by ProductSeeder

        // Call Product seeder last
        $this->call([
            ProductSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Database seeding completed!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Villages: ' . \App\Models\Village::count());
        $this->command->info('   - Categories: ' . Category::count());
        $this->command->info('   - Products: ' . Product::count());
        $this->command->info('');
        $this->command->info('🔐 Login credentials:');
        $this->command->info('   SuperAdmin: superadmin@bumdes.com / 123');
        $this->command->info('   Admin Desa: admin@sendangsari.desa.id / 123 (Desa Sendangsari)');
        $this->command->info('   User: budi@example.com / 123');
        $this->command->info('   User: siti@example.com / 123');
    }
}
