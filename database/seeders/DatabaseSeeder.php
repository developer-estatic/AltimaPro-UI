<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            BusinessUnitSeeder::class,
            BrandsTableSeeder::class,
            BrandSmtpsTableSeeder::class,
            UsersTableSeeder::class,
            ModulesTableSeeder::class,
            RolesTableSeeder::class,
            ModelHasRolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,

        ]);
    }
}
