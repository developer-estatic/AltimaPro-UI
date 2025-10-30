<?php

namespace App\Livewire;

use App\Models\Module;
use Livewire\Component;
use App\Models\ColumnMaster;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Column Master')]
class ColumnMasterComponent extends Component
{
    public $columns = [];
    public $modules = [];
    public $name;
    public $status = 0;
    public $es_name;
    public $module;
    public $sequence;
    public $editId = null;

    public $modalVisible = false;

    public function mount()
    {
        $this->loadColumns();
    }

    public function loadColumns()
    {
        $this->columns = ColumnMaster::get();
        $this->modules = Module::get();
        $this->dispatch('reload-datatable');
    }

    public function saveColumn()
    {
        try {
        try {
            $this->validate([
                'name' => 'required',
                'status' => 'required',
                'es_name' => 'required',
                'module' => 'required',
                'sequence' => 'required',
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return;
        }


        if ($this->editId !== null) {
            $column = ColumnMaster::find($this->editId);
            if ($column) {
                $column->update([
                    'name' => $this->name,
                    'status' => $this->status,
                    'es_name' => $this->es_name,
                    'module_id' => $this->module,
                    'sequence' => $this->sequence,
                ]);
            } else {
                $this->notify('warning', 'Column not found!');
                $this->hideModal();
                $this->resetForm();
                return;
            }
        } else {
            $column = ColumnMaster::create([
                'name' => $this->name,
                'status' => $this->status,
                'es_name' => $this->es_name,
                'module_id' => $this->module,
                'sequence' => $this->sequence,
            ]);
        }

        $this->loadColumns();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->notify('success', 'Column ' . $action . ' successfully!');
        $this->hideModal();
        $this->resetForm();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editColumn($id)
    {
        $this->hideModal();
        $this->openModal();
        $this->modalVisible = true;
        $this->editId = $id;
        $column = collect($this->columns)->firstWhere('id', $id);
        $this->name = $column->name;
        $this->status = $column->status;
        $this->es_name = $column->es_name;
        $this->module = $column->module_id;
        $this->sequence = $column->sequence;
    }

    public function deleteColumn($id)
    {
        $column = ColumnMaster::whereId($id)->first();
        if ($column) {
            $column->delete();
            $this->loadColumns();
            $this->notify('success', 'Column deleted successfully!');
        } else {
            $this->notify('warning', 'Column not found!');
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-column');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-column');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['name', 'status', 'es_name', 'module', 'sequence', 'editId', 'modalVisible']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.column-master-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }
}
