<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactSubmissionRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact');
    }

    public function submit(ContactSubmissionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $cleanData = [
            'name' => strip_tags(trim($validated['name'])),
            'phone_number' => strip_tags(trim($validated['phone_number'])),
            'email' => !empty($validated['email']) ? strip_tags(trim($validated['email'])) : null,
            'subject' => strip_tags(trim($validated['subject'])),
            'message' => strip_tags(trim($validated['message'])),
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ];

        ContactMessage::create($cleanData);

        return back()->with('success', 'Terima kasih! Pesan Anda telah kami terima. Tim AzkaMandiri akan segera menghubungi Anda melalui WhatsApp atau telepon.');
    }
}

