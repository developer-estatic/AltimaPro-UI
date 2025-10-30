<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->truncate();

        DB::table('users')->insert(array (

            array (
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone' => '',
                'country_id' => 70,
                'business_unit_id' => 1,
                'email_verified_at' => NULL,
                'password' => bcrypt(12345678),
                'avatar' => NULL,
                'status' => NULL,
                'remember_token' => NULL,
                'language' => NULL,
                'date_time_format' => NULL,
                'default_home_page' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'latest_login' => NULL,
                'login_ip' => NULL,
                'manager_id' => 1,
                'address_line_1' => '70 Milton Lane',
                'address_line_2' => 'Sint sint et amet ',
                'zipcode' => '49520',
                'city' => 'Sed tempora labore b',
                'country' => NULL,
            ),

            array (
                'first_name' => 'amir',
                'last_name' => 'adfaf',
                'email' => 'abc@tee.com',
                'phone' => NULL,
                'country_id' => 52,
                'business_unit_id' => 1,
                'email_verified_at' => NULL,
                'password' => bcrypt(12345678),
                'avatar' => NULL,
                'status' => NULL,
                'remember_token' => NULL,
                'language' => NULL,
                'date_time_format' => NULL,
                'default_home_page' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'latest_login' => NULL,
                'login_ip' => NULL,
                'manager_id' => 1,
                'address_line_1' => '12321',
                'address_line_2' => '1231',
                'zipcode' => '12321',
                'city' => '12312',
                'country' => NULL,
            ),

            array (
                'first_name' => 'cansjnc',
                'last_name' => 'cnjans',
                'email' => 'abc@eee.com',
                'phone' => NULL,
                'country_id' => 172,
                'business_unit_id' => 2,
                'email_verified_at' => NULL,
                'password' => bcrypt(12345678),
                'avatar' => NULL,
                'status' => NULL,
                'remember_token' => NULL,
                'language' => NULL,
                'date_time_format' => NULL,
                'default_home_page' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'latest_login' => NULL,
                'login_ip' => NULL,
                'manager_id' => 1,
                'address_line_1' => 'jdncjndj',
                'address_line_2' => 'rokfgoekss',
                'zipcode' => '24234',
                'city' => '23423',
                'country' => NULL,
            ),

            array (
                'first_name' => 'Clementine',
                'last_name' => 'Lott',
                'email' => 'bojixo@mailinator.com',
                'phone' => NULL,
                'country_id' => 62,
                'business_unit_id' => 3,
                'email_verified_at' => NULL,
                'password' => bcrypt(12345678),
                'avatar' => NULL,
                'status' => NULL,
                'remember_token' => NULL,
                'language' => NULL,
                'date_time_format' => NULL,
                'default_home_page' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'latest_login' => NULL,
                'login_ip' => NULL,
                'manager_id' => 1,
                'address_line_1' => '74 Second Road',
                'address_line_2' => 'Consequat Voluptate',
                'zipcode' => '24766',
                'city' => 'At sed quaerat quasi',
                'country' => NULL,
            ),

            array (
                'first_name' => 'Mikayla',
                'last_name' => 'Wolf',
                'email' => 'leka@mailinator.com',
                'phone' => NULL,
                'country_id' => 130,
                'business_unit_id' => 2,
                'email_verified_at' => NULL,
                'password' => bcrypt(12345678),
                'avatar' => NULL,
                'status' => NULL,
                'remember_token' => NULL,
                'language' => NULL,
                'date_time_format' => NULL,
                'default_home_page' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'latest_login' => NULL,
                'login_ip' => NULL,
                'manager_id' => 1,
                'address_line_1' => '80 White Old Road',
                'address_line_2' => 'Illum ea fugiat inc',
                'zipcode' => '24934',
                'city' => 'Cum doloribus volupt',
                'country' => NULL,
            ),
        ));


    }
}