<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('brands')->truncate();

        DB::table('brands')->insert(array (

            array (
                'name' => 'Brand 1',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ),
        ));


    }
}