<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()
            ->when(request('q'), fn ($query, $search) =>
                $query->where('fullName', 'like', "%{$search}%")
                    ->orWhere('companyName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
            )
            ->latest('createdAt')
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Contact message deleted.');
    }
}
