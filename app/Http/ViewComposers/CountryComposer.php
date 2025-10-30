<?php

namespace App\Http\ViewComposers;

use AllowDynamicProperties;
use App\Models\Country;
use App\Models\Module;
use Illuminate\View\View;

#[AllowDynamicProperties] class CountryComposer
{
    /**
     * The post model implementation.
     *
     * @var Country
     */
    protected $countries;

    /**
     * Create a new post composer.
     *
     * @param  Country  $countries
     * @return void
     */
    public function __construct(Country $countries)
    {
        $this->countries = $countries;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $countries = Country::all();

        $view->with('countries', $countries);
    }
}
