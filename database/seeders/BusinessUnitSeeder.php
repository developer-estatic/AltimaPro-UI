<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        BusinessUnit::truncate();
        $businessUnits = [
            [
                'name' => 'BU 1',
                'timezone' => 'Asia/Kolkata',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'BU 2',
                'timezone' => 'America/Denver',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'BU 3',
                'timezone' => 'Europe/London',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        BusinessUnit::insert($businessUnits);
        Schema::enableForeignKeyConstraints();
    }
}
