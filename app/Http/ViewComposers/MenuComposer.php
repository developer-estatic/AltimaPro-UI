<?php

namespace App\Http\ViewComposers;

use AllowDynamicProperties;
use App\Models\Module;
use Illuminate\View\View;

#[AllowDynamicProperties] class MenuComposer
{
    /**
     * The post model implementation.
     *
     * @var Post
     */
    protected $modules;

    /**
     * Create a new post composer.
     *
     * @param  Post  $post
     * @return void
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $menu = Module::join('permissions', 'modules.id', '=', 'permissions.module_id')
            ->with(['children' => function($query) {
                $query->where('status', '=', 1)
                    ->whereNotNull('route')
                    ->orderBy('order', 'asc');
            }])
            ->where('status', '=', 1)
            ->where('menu_type', '=', 'PRIMARY')
            ->whereNull('parent_id')
            ->where(function ($query) {
                $query->orWhere('permissions.name', 'LIKE', '%-view%');
                $query->orWhere('permissions.name', 'LIKE', '%.index%');
            })
            ->select('modules.*')
            ->groupBy('modules.id', 'modules.name')
            ->orderBy('order', 'asc')->get();

        $currentModule = Module::where('route', \Request::route()->getName())->whereNotNull('parent_id')->first();


        foreach($menu as $item) {
            if($currentModule) {
                ($currentModule->parent_id == $item->id) ? $item->active = true : $item->active = false;
            }
        }

        $view->with('menu', $menu);
    }
}
