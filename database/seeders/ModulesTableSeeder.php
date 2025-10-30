<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('modules')->truncate();

        DB::table('modules')->insert(array (

            array (
                'name' => 'Dashboard',
                'module_internal_name' => NULL,
                'route' => 'dashboard.index',
                'parent_id' => NULL,
                'order' => 1,
                'icon' => 'dashboard',
                'menu_type' => 'PRIMARY',
                'status' => 1,
            ),

            array (
                'name' => 'Settings',
                'module_internal_name' => NULL,
                'route' => 'settings.index',
                'parent_id' => NULL,
                'order' => 2,
                'icon' => 'settings',
                'menu_type' => 'PRIMARY',
                'status' => 1,
            ),

            array (
                'name' => 'Modules',
                'module_internal_name' => NULL,
                'route' => 'settings.modules.index',
                'parent_id' => 2,
                'order' => 3,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Log Viewer',
                'module_internal_name' => NULL,
                'route' => 'log-viewer.index',
                'parent_id' => NULL,
                'order' => 3,
                'icon' => 'log-viewer',
                'menu_type' => 'PRIMARY',
                'status' => 1,
            ),

            array (
                'name' => 'Trading Accounts',
                'module_internal_name' => NULL,
                'route' => 'trading-accounts.index',
                'parent_id' => NULL,
                'order' => 4,
                'icon' => 'trading-accounts',
                'menu_type' => 'PRIMARY',
                'status' => 1,
            ),

            array (
                'name' => 'Brands Management',
                'module_internal_name' => NULL,
                'route' => '',
                'parent_id' => 2,
                'order' => 1,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Brands',
                'module_internal_name' => NULL,
                'route' => 'settings.brands.index',
                'parent_id' => 6,
                'order' => 1,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Role',
                'module_internal_name' => NULL,
                'route' => 'settings.roles.index',
                'parent_id' => 2,
                'order' => 2,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Your Prefrences',
                'module_internal_name' => NULL,
                'route' => '',
                'parent_id' => 2,
                'order' => 4,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'General',
                'module_internal_name' => NULL,
                'route' => 'settings.general.index',
                'parent_id' => 9,
                'order' => 1,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'My Team',
                'module_internal_name' => NULL,
                'route' => 'settings.team.index',
                'parent_id' => 2,
                'order' => 5,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Business Units',
                'module_internal_name' => NULL,
                'route' => 'settings.business-units.index',
                'parent_id' => 6,
                'order' => 7,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'SMTP',
                'module_internal_name' => NULL,
                'route' => 'settings.brand-email.index',
                'parent_id' => 6,
                'order' => 10,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Notifications',
                'module_internal_name' => NULL,
                'route' => 'settings.notifications.index',
                'parent_id' => 9,
                'order' => 10,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Ib Settings',
                'module_internal_name' => NULL,
                'route' => 'settings.ib.index',
                'parent_id' => 2,
                'order' => 6,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Column Master',
                'module_internal_name' => NULL,
                'route' => 'settings.column-master.index',
                'parent_id' => 2,
                'order' => 8,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Voips',
                'module_internal_name' => NULL,
                'route' => 'settings.voips.index',
                'parent_id' => 6,
                'order' => 20,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'SMS',
                'module_internal_name' => NULL,
                'route' => 'settings.sms.index',
                'parent_id' => 6,
                'order' => 21,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Telegram',
                'module_internal_name' => NULL,
                'route' => 'settings.telegram.index',
                'parent_id' => 6,
                'order' => 22,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Wallets',
                'module_internal_name' => NULL,
                'route' => 'settings.brand-wallet.index',
                'parent_id' => 6,
                'order' => 23,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Trading Groups',
                'module_internal_name' => NULL,
                'route' => 'settings.trading-groups.index',
                'parent_id' => 2,
                'order' => 20,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Trading Currencies',
                'module_internal_name' => NULL,
                'route' => 'settings.trading-currencies.index',
                'parent_id' => 2,
                'order' => 21,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Trading Leverages',
                'module_internal_name' => NULL,
                'route' => 'settings.trading-leverages.index',
                'parent_id' => 2,
                'order' => 22,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Whitelisted Ips',
                'module_internal_name' => NULL,
                'route' => 'settings.whitelisted-ips.index',
                'parent_id' => 6,
                'order' => 25,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Whitelisted Countries',
                'module_internal_name' => NULL,
                'route' => 'settings.whitelisted-countries.index',
                'parent_id' => 6,
                'order' => 30,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Email Templates',
                'module_internal_name' => NULL,
                'route' => 'settings.email-templates.index',
                'parent_id' => 2,
                'order' => 31,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Crm User Privileges',
                'module_internal_name' => NULL,
                'route' => 'settings.crm-user-privileges.index',
                'parent_id' => 2,
                'order' => 32,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Permissions',
                'module_internal_name' => NULL,
                'route' => 'settings.permissions.index',
                'parent_id' => 2,
                'order' => 33,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Trading Account Types',
                'module_internal_name' => NULL,
                'route' => 'settings.trading-account-types.index',
                'parent_id' => 2,
                'order' => 34,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),

            array (
                'name' => 'Trading Platforms',
                'module_internal_name' => NULL,
                'route' => 'settings.trading-platforms.index',
                'parent_id' => 2,
                'order' => 35,
                'icon' => NULL,
                'menu_type' => 'SECONDARY',
                'status' => 1,
            ),
        ));


    }
}