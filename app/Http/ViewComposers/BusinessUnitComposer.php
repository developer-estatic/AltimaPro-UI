<?php

namespace App\Http\ViewComposers;

use AllowDynamicProperties;
use App\Models\BusinessUnit;
use App\Models\Country;
use App\Models\Module;
use Illuminate\View\View;

#[AllowDynamicProperties] class BusinessUnitComposer
{
    /**
     * The post model implementation.
     *
     * @var Country
     */
    protected $businessUnits;

    /**
     * Create a new post composer.
     *
     * @param  Country  $countries
     * @return void
     */
    public function __construct(BusinessUnit $businessUnits)
    {
        $this->businessUnits = $businessUnits;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $businessUnits = BusinessUnit::all();

        $view->with('businessUnits', $businessUnits);
    }
}
