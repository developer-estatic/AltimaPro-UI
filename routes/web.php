<?php

use App\Livewire\BrandsSmtp;
use App\Livewire\IbComponent;
use App\Livewire\SmsComponent;
use App\Livewire\RoleComponent;
use App\Livewire\VoipsComponent;
use App\Livewire\BrandsComponent;
use App\Livewire\ModuleComponent;
use App\Livewire\GeneralComponent;
use App\Livewire\TelegramComponent;
use App\Livewire\PermissionComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\BrandsWalletComponent;
use App\Livewire\NotificationComponent;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Livewire\BusinessUnitsComponent;
use App\Livewire\TradingGroupsComponent;
use App\Livewire\WhitelistedIpComponent;
use App\Livewire\EmailTemplatesComponent;
use App\Livewire\RoleManagementComponent;
use App\Livewire\UserManagementComponent;
use App\Livewire\UserPermissionComponent;
use App\Http\Controllers\ProfileController;
use App\Livewire\TradingLeveragesComponent;
use App\Livewire\TradingPlatformsComponent;
use App\Http\Controllers\LanguageController;
use App\Livewire\CrmUserPrivilegesComponent;
use App\Livewire\TradingCurrenciesComponent;
use App\Http\Controllers\DashboardController;
use App\Livewire\TradingAccountTypesComponent;
use App\Livewire\WhitelistedCountriesComponent;
use App\Http\Controllers\TradingAccountsController;
use App\Livewire\ColumnMasterComponent;

Route::get('/language',[LanguageController::class , 'change'])->name('language');

Route::middleware(['auth', 'verified', 'check_permission','encrypt'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/trading-accounts', [TradingAccountsController::class, 'index'])->name('trading-accounts.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    // Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);
//    Route::get('users', [UserController::class, 'index'])->name('users.index');
//    Route::put('users/{id}/update', [UserController::class, 'update'])->name('users.update');
//    Route::delete('users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
//    Route::resource('users', UserController::class);

    Route::post('/change-status', [UserController::class, 'changeStatus'])->name('change-status');


    Route::middleware(['auth', 'verified', 'check_permission','encrypt'])
    ->prefix('settings')->name('settings.')
    ->group(function () {
        // Route::get('/get-template', [DashboardController::class, 'getTemplate'])->name('get.template');
        Route::redirect('', '/settings/brands', 301)->name('index');
        Route::get('/brands', BrandsComponent::class)->name('brands.index');
        Route::get('/general', GeneralComponent::class)->name('general.index');
        Route::get('/notifications', NotificationComponent::class)->name('notifications.index');
        Route::get('/brand-email', BrandsSmtp::class)->name('brand-email.index');
        Route::get('/brand-wallet', BrandsWalletComponent::class)->name('brand-wallet.index');
        Route::get('/sms', SmsComponent::class)->name('sms.index');
        Route::get('/telegram', TelegramComponent::class)->name('telegram.index');
        Route::get('/voips', VoipsComponent::class)->name('voips.index');
        Route::get('/trading-groups', TradingGroupsComponent::class)->name('trading-groups.index');
        Route::get('/trading-currencies', TradingCurrenciesComponent::class)->name('trading-currencies.index');
        Route::get('/business-units', BusinessUnitsComponent::class)->name('business-units.index');
        Route::get('/trading-leverages', TradingLeveragesComponent::class)->name('trading-leverages.index');
        Route::get('/trading-platforms', TradingPlatformsComponent::class)->name('trading-platforms.index');
        Route::get('/trading-account-types', TradingAccountTypesComponent::class)->name('trading-account-types.index');
        Route::get('/whitelisted-ips', WhitelistedIpComponent::class)->name('whitelisted-ips.index');
        Route::get('/ibs', IbComponent::class)->name('ib.index');
        Route::get('/column-master', ColumnMasterComponent::class)->name('column-master.index');
        Route::get('/whitelisted-countries', WhitelistedCountriesComponent::class)->name('whitelisted-countries.index');
        Route::get('/email-templates', EmailTemplatesComponent::class)->name('email-templates.index');
        Route::get('/crm-user-privileges', CrmUserPrivilegesComponent::class)->name('crm-user-privileges.index');
        Route::get('/modules', ModuleComponent::class)->name('modules.index');
        // Route::get('/roles', RoleComponent::class)->name('roles');
        Route::get('/permissions', PermissionComponent::class)->name('permissions.index');
        Route::get('/roles', RoleManagementComponent::class)->name('roles.index');
        Route::get('/team', UserManagementComponent::class)->name('team.index');

    });
});


Route::get('/get-country-code', [DashboardController::class, 'getCountryCode'])->name('get.country.code');


require __DIR__.'/auth.php';
