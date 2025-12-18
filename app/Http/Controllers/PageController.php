<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Career;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($request->only('name', 'email', 'subject', 'message'));

        return redirect()->route('pages.contact')->with('success', 'Thank you! Your message has been sent successfully.');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function careers()
    {
        $careers = Career::where('is_active', true)->latest()->get();
        return view('pages.careers', compact('careers'));
    }

    public function careerShow(Career $career)
    {
        if (!$career->is_active) {
            abort(404);
        }
        return view('pages.career-show', compact('career'));
    }

    public function applyJob(Request $request, Career $career)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string',
        ]);

        $data = $request->only('name', 'email', 'phone', 'cover_letter');
        $data['career_id'] = $career->id;

        if ($request->hasFile('resume')) {
            $data['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        JobApplication::create($data);

        return redirect()->route('pages.careers.show', $career)->with('success', 'Your application has been submitted successfully!');
    }

    public function payments()
    {
        return view('pages.payments');
    }

    public function shipping()
    {
        return view('pages.shipping');
    }

    public function returns()
    {
        return view('pages.returns');
    }

    public function returnPolicy()
    {
        return view('pages.return-policy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
