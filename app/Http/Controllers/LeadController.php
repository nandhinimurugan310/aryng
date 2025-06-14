<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LeadController extends Controller
{
    public function showForm()
    {
        return view('form');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'company_name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'required|string',
            'job_title' => 'required|string|max:255',
        ]);

        $lead = Lead::create($validated);
        Session::put('lead_id', $lead->id);

        return redirect()->route('chat');
    }

    public function showChat()
    {
        return view('chat');
    }
}
