<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('roles')->truncate();

        DB::table('roles')->insert(array (

            array (
                'name' => 'Admin',
                'guard_name' => 'web',
                'parent_id' => 0,
            ),

            array (
                'name' => 'Backoffice',
                'guard_name' => 'web',
                'parent_id' => 1,
            ),

            array (
                'name' => 'Retention Manager',
                'guard_name' => 'web',
                'parent_id' => 2,
            ),

            array (
                'name' => 'Marketing Manager',
                'guard_name' => 'web',
                'parent_id' => 2,
            ),
        ));


    }
}