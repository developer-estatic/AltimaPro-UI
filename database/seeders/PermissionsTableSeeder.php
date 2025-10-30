<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('permissions')->truncate();

        DB::table('permissions')->insert(array (

            array (
                'module_id' => 1,
                'name' => 'dashboard.index',
                'display_name' => 'View',
                'guard_name' => 'web',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 2,
                'name' => 'settings.index',
                'display_name' => 'List',
                'guard_name' => 'web',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 4,
                'name' => 'log-viewer.index',
                'display_name' => 'List',
                'guard_name' => 'web',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 5,
                'name' => 'trading-accounts.index',
                'display_name' => 'List',
                'guard_name' => 'web',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 3,
                'name' => 'settings.modules.index',
                'display_name' => 'List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 6,
                'name' => 'settings.brands-management.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 7,
                'name' => 'settings.brands.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 8,
                'name' => 'settings.role.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 9,
                'name' => 'settings.your-prefrences.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 10,
                'name' => 'settings.general.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 11,
                'name' => 'settings.my-team.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 13,
                'name' => 'settings.brand-email.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 14,
                'name' => 'settings.notifications.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 15,
                'name' => 'settings.ib-settings.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 16,
                'name' => 'settings.column-master.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 12,
                'name' => 'settings.business-units.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 18,
                'name' => 'settings.sms.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 19,
                'name' => 'settings.telegram.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 20,
                'name' => 'settings.brand-wallet.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 21,
                'name' => 'settings.trading-groups.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 22,
                'name' => 'settings.trading-currencies.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 23,
                'name' => 'settings.trading-leverages.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 17,
                'name' => 'settings.voips.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 24,
                'name' => 'settings.whitelisted-ips.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 25,
                'name' => 'settings.whitelisted-countries.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 26,
                'name' => 'settings.email-templates.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 27,
                'name' => 'settings.crm-user-privileges.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 28,
                'name' => 'settings.permissions.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 29,
                'name' => 'settings.trading-account-types.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.index',
                'display_name' => 'View/List',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.show',
                'display_name' => 'Show Single',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.create',
                'display_name' => 'Create',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.store',
                'display_name' => 'Store',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.edit',
                'display_name' => 'Edit',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.update',
                'display_name' => 'Update',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),

            array (
                'module_id' => 30,
                'name' => 'settings.trading-platforms.destroy',
                'display_name' => 'Delete',
                'guard_name' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
            ),
        ));
    }
}