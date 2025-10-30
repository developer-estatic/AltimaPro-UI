<?php

namespace App\Livewire;

use App\Models\Module;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Menu extends Component
{
    public $menu;

    public function mount(): void
    {
        $this->loadMenu();
    }

    public function loadMenu(): void
    {
        $menu = Module::join('permissions', 'modules.id', '=', 'permissions.module_id')
            ->with(['children' => function ($query) {
                $query->where('status', 1)
                    ->whereNotNull('route')
                    ->orderBy('order', 'asc');
            }])
            ->where('status', 1)
            ->where('menu_type', 'PRIMARY')
            ->whereNull('parent_id')
            ->where(function ($query) {
                $query->orWhere('permissions.name', 'LIKE', '%-view%')
                    ->orWhere('permissions.name', 'LIKE', '%.index%');
            })
            ->select('modules.*')
            ->groupBy('modules.id', 'modules.name')
            ->orderBy('order', 'asc')
            ->get();

        $currentRoute = Request::route()?->getName();
        $currentModule = Module::where('route', $currentRoute)
            ->whereNotNull('parent_id')
            ->first();

        foreach ($menu as $item) {
            $item->active = $currentModule && $currentModule->parent_id === $item->id;
        }

        $this->menu = $menu;
    }

    #[\Livewire\Attributes\On('menu-updated')]
    public function refreshMenu(): void
    {
        $this->loadMenu();
    }

    public function render()
    {
        return view('livewire.menu');
    }
}
