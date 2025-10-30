<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::all();
        return view('email-templates.index', compact('emailTemplates'));
    }

    public function create()
    {
        return view('email-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'status' => 'nullable|boolean',
            'type_id' => 'nullable|exists:crm_meta_data,id',
            'business_unit_id' => 'nullable|integer',
            'language' => 'nullable|string',
            'subject' => 'nullable|string',
            'body' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        EmailTemplate::create($validated);

        return redirect()->route('email-templates.index');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'status' => 'nullable|boolean',
            'type_id' => 'nullable|exists:crm_meta_data,id',
            'business_unit_id' => 'nullable|integer',
            'language' => 'nullable|string',
            'subject' => 'nullable|string',
            'body' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $emailTemplate->update($validated);

        return redirect()->route('email-templates.index');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('email-templates.index');
    }
}
