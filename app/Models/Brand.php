<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];

    public function businessUnits()
    {
        return $this->hasMany(BusinessUnit::class, 'brand_id');
    }
    public function sms()
    {
        return $this->hasMany(Sms::class, 'brand_id');
    }

    public function smtp()
    {
        return $this->hasMany(BrandSmtp::class, 'brand_id');
    }
    public function telegram()
    {
        return $this->hasMany(Telegram::class, 'brand_id');
    }
    public function voips()
    {
        return $this->hasMany(Voip::class, 'brand_id');
    }
    public function wallets()
    {
        return $this->hasMany(BrandWallet::class, 'brand_id');
    }
    public function whitelistedCountries()
    {
        return $this->hasMany(WhitelistedCountry::class, 'brand_id');
    }
    public function whitelistedIps()
    {
        return $this->hasMany(WhitelistedIp::class, 'brand_id');
    }


}
