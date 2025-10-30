<?php
namespace App\Rules;

use App\Models\Module;
use Illuminate\Contracts\Validation\Rule;

class UniqueOrderInMenu implements Rule
{
    protected $module;
    protected $id;

    public function __construct($module, $id)
    {
        $this->module = $module;
        $this->id = $id;
    }

    public function passes($attribute, $value)
    {
        return !Module::where('menu_type', $this->module->menu_type)
            ->where('order', $value)
            ->where('parent_id', $this->module->parent_id)
            ->where('id', '!=', $this->id)
            ->exists();
    }

    public function message()
    {
        return 'The order must be unique within the same menu type and parent module.';
    }
}