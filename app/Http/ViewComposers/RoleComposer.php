<?php

namespace App\Http\ViewComposers;

use AllowDynamicProperties;
use App\Models\Role;
use App\Models\Module;
use Illuminate\View\View;

#[AllowDynamicProperties] class RoleComposer
{
    /**
     * The post model implementation.
     *
     * @var Role
     */
    protected $roles;

    /**
     * Create a new post composer.
     *
     * @param  Role  $roles
     * @return void
     */
    public function __construct(Role $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $roles = Role::all();

        $view->with('roles', $roles);
    }
}
