<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BrandSmtpsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('brand_smtps')->truncate();

        DB::table('brand_smtps')->insert(array (

            array (
                'brand_id' => 1,
                'name' => 'Mari Rollins',
                'host' => 'Non id est sint ape',
                'username' => 'jolaja',
                'password' => 'Pa$$w0rd!',
                'port' => 58,
                'encryption' => 'Id unde animi totam',
                'from_email' => 'mypowiz@mailinator.com',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ),

            array (
                'brand_id' => 1,
                'name' => 'Walker Gardner',
                'host' => 'Exercitationem paria',
                'username' => 'lytytojyqi',
                'password' => 'Pa$$w0rd!',
                'port' => 27,
                'encryption' => 'Consequatur tempore',
                'from_email' => 'becaci@mailinator.com',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ),
        ));


    }
}