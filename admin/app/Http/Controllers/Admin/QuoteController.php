<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public function index(): View
    {
        $quotes = Quote::when(request('q'), fn ($q, $search) =>
                $q->where('companyName', 'like', "%{$search}%")
                  ->orWhere('contactName', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
            )
            ->when(request('status'), fn ($q, $status) =>
                $q->where('status', $status)
            )
            ->latest('createdAt')
            ->paginate(20)
            ->withQueryString();

        return view('admin.quotes.index', compact('quotes'));
    }

    public function show(Quote $quote): View
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function update(Request $request, Quote $quote): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:New,In Progress,Completed',
        ]);

        $quote->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.quotes.show', $quote)
            ->with('success', 'Quote status updated successfully.');
    }

    public function destroy(Quote $quote): RedirectResponse
    {
        $quote->delete();

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Quote request deleted.');
    }
}
