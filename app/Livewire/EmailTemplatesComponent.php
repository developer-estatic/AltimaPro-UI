<?php

namespace App\Livewire;

use App\Models\EmailTemplate;
use App\Models\CrmMetaData;
use App\Models\BusinessUnit;
use Livewire\Component;

class EmailTemplatesComponent extends Component
{
    public $emailTemplates;
    public $businessUnits;
    public $name, $status = 0, $type_id, $business_unit_id, $language, $subject, $body, $editId;
    public $types;
    public $showModal = false;

    public function mount()
    {
        $this->emailTemplates = EmailTemplate::all();
        $this->types = getTypesFromCRMMetaData('email_template_type');
        $this->businessUnits = BusinessUnit::all();
        $this->business_unit_id = null;
        $this->type_id = null;
    }

    public function render()
    {
        return view('livewire.email-templates');
    }

    public function create()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        if ($this->editId)   {
            $this->update();
            return;
        }
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
            'type_id' => 'required|exists:crm_meta_data,id',
            'business_unit_id' => 'required|exists:business_units,id',
            'language' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $data = [
            'name' => $this->name,
            'status' => $this->status ?? 0,
            'type_id' => $this->type_id,
            'business_unit_id' => $this->business_unit_id,
            'language' => $this->language,
            'subject' => $this->subject,
            'body' => $this->body,
        ];

        EmailTemplate::create($data); // Fixed: pass $data to create()

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Email Template created successfully!'
        ]);

        $this->hideModal();
        $this->emailTemplates = EmailTemplate::all();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->openModal();
        $emailTemplate = EmailTemplate::findOrFail($id);
        $this->editId = $id;
        $this->name = $emailTemplate->name;
        $this->status = $emailTemplate->status;
        $this->type_id = $emailTemplate->type_id;
        $this->business_unit_id = $emailTemplate->business_unit_id;
        $this->language = $emailTemplate->language;
        $this->subject = $emailTemplate->subject;
        $this->body = $emailTemplate->body;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
            'type_id' => 'required|exists:crm_meta_data,id',
            'business_unit_id' => 'required|exists:business_units,id',
            'language' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $emailTemplate = EmailTemplate::findOrFail($this->editId);
        $emailTemplate->update([
            'name' => $this->name,
            'status' => $this->status ?? 0,
            'type_id' => $this->type_id,
            'business_unit_id' => $this->business_unit_id,
            'language' => $this->language,
            'subject' => $this->subject,
            'body' => $this->body,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Email Template updated successfully!'
        ]);

        $this->emailTemplates = EmailTemplate::all();
        $this->resetInputFields();
        $this->hideModal();
    }

    public function delete($id)
    {
        EmailTemplate::findOrFail($id)->delete();
        $this->emailTemplates = EmailTemplate::all();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Email Template deleted successfully!'
        ]);
    }

    public function openModal()
    {
        $this->hideModal();
        $this->showModal = true;
        $this->dispatch('open-modal', 'create-update-email-template');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-email-template');
        $this->showModal = false;
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->status = 0;
        $this->type_id = null;
        $this->business_unit_id = null;
        $this->language = '';
        $this->subject = '';
        $this->body = '';
        $this->editId = null;
    }

    // Keep this method for backward compatibility if needed
    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }
}