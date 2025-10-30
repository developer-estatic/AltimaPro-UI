<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Organization;
use Yajra\DataTables\Html\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Organizations')]
class OrganizationComponent extends Component
{

    public $organizations;

    public $search = '';
    public $userId = null;

    public $modalName = 'add-organization';
    public $editId = null;

    public $name = '';

    public $status = 0;

    public $brand_id = null;

    public $description;

    public $openAccordions = [];

    public $expandedBrandRows = [];

    public $brandsOptions = [];

    public $modalVisible = false;

    public function mount() {
        $this->organizations = Organization::all();
    }

    public function submit()
    {
        $this->{$this->modalName == 'add-organization' ? 'createOrganization' : 'updateOrganization'}();
    }

    public function createOrganization()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'status' => 'required|boolean',
            'brand_id' => 'nullable|integer',
        ]);

        Organization::create([
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
        ]);
        $this->notify('success', 'Organization added successfully!');
        $this->hideModal();
        $this->organizations = Organization::all();
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }

    public function editOrganization($id)
    {
        $this->openModal();
        $this->modalName = 'edit-organization';
        $organization = Organization::find($id);
        $this->editId = $organization->id;
        $this->name = $organization->name;
        $this->brand_id = $organization->brand_id;
        $this->status = $organization->status;
        $this->description = $organization->description;
    }

    public function updateOrganization()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'status' => 'required|boolean',
            'brand_id' => 'nullable|integer',
        ]);
        $organization = Organization::find($this->editId);
        $organization->update([
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
        ]);
        $this->notify('success', 'Organization updated successfully!');
        $this->hideModal();
        $this->organizations = Organization::all();
    }

    public function deleteOrganization($id)
    {
        Organization::find($id)?->delete();
        $this->notify('success', 'Organization deleted successfully!');
        $this->organizations = Organization::all();
    }

    public function toggleAccordion($id)
    {
        if (in_array($id, $this->openAccordions)) {
            $this->openAccordions = array_diff($this->openAccordions, [$id]);
        } else {
            $this->openAccordions[] = $id;
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->brandsOptions = []; // Reset brandsOptions as getBrandOptions() is removed
        $this->brandsOptions = $this->getBrandOptions();
        $this->resetValidation();
        $this->reset(['name', 'status', 'description', 'modalName', 'editId']);
        $this->modalName = 'add-organization';
        $this->dispatch('open-modal', 'create-update-organization');

    }

    #[\Livewire\Attributes\On('hideModal')]
    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'status', 'description', 'modalName', 'editId']);
        $this->dispatch('close-modal', 'create-update-organization');
        $this->modalVisible = false;
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }

    public function render()
    {
        return view('livewire.organization-component');
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }

    /**
     * Get example JSON for bulk creation (excluding id)
     */
    public static function bulkCreateJsonExample(): array
    {
        return [
            'status' => true,
            'name' => 'string',
            'description' => 'string',
            'brand_id' => 1
        ];
    }

    public function getBrandOptions()
    {
        return Brand::all()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
            ];
        })->toArray();
    }
}
