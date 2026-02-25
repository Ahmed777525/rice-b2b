<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display the about page.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // In a real application, you would send an email here
        // For now, we'll just return with a success message
        // Mail::to('admin@rice-b2b.com')->send(new ContactFormMail($validated));

        return redirect()->route('contact')->with('success', __('messages.contact_success'));
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Display the terms and conditions page.
     */
    public function terms()
    {
        return view('pages.terms');
    }
}
