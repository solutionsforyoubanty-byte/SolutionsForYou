<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show contact page
     */
    public function index()
    {
        $services = Service::orderBy('title')->get();
        return view('user.contact.index', compact('services'));
    }

    /**
     * Store contact form submission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($request->all());

        return redirect()->route('contact.thanks');
    }

    /**
     * Show thank you page
     */
    public function thanks()
    {
        return view('user.contact.thanks');
    }

    /**
     * Show about page
     */
    public function about()
    {
        $services = Service::take(6)->get();
        $projectsCount = \App\Models\Project::count();
        $servicesCount = Service::count();
        
        return view('user.about.index', compact('services', 'projectsCount', 'servicesCount'));
    }

    /**
     * Admin: List all contacts
     */
    public function adminIndex()
    {
        $contacts = Contact::with('service')->latest()->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Admin: View contact details
     */
    public function show($id)
    {
        $contact = Contact::with('service')->findOrFail($id);
        
        // Mark as read
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Admin: Update contact status
     */
    public function updateStatus(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => $request->status]);

        return back()->with('toast_success', 'Status updated successfully!');
    }

    /**
     * Admin: Delete contact
     */
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')->with('toast_success', 'Contact deleted!');
    }
}
