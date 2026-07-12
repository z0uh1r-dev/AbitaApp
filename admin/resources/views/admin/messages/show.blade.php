@extends('layouts.admin')
@section('title', 'Message — ' . $message->fullName)

@section('header-actions')
    <x-admin.delete-button
        :action="route('admin.messages.destroy', $message)"
        label="Delete Message"
        confirm="Delete this message from {{ $message->fullName }}?" />
    <a href="{{ route('admin.messages.index') }}"
       class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
        ← Back
    </a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">

        <div class="bg-gradient-to-r from-brand/10 to-transparent border-b border-gray-800 px-8 py-6">
            <div class="font-display text-2xl font-extrabold">{{ $message->fullName }}</div>
            <div class="text-sm text-gray-400 mt-1">
                Received {{ $message->createdAt->format('d M Y') }} at {{ $message->createdAt->format('H:i') }}
            </div>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Full Name</div>
                    <div class="text-gray-200 font-medium">{{ $message->fullName }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Email</div>
                    <a href="mailto:{{ $message->email }}" class="text-brand hover:underline font-medium">
                        {{ $message->email }}
                    </a>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Phone</div>
                    <a href="tel:{{ $message->phone }}" class="text-gray-200 hover:text-brand transition-colors">
                        {{ $message->phone }}
                    </a>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Company</div>
                    <div class="text-gray-200">{{ $message->companyName }}</div>
                </div>
            </div>

            <div>
                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Message</div>
                <div class="bg-gray-800/60 border border-gray-700 rounded-xl px-5 py-4 text-sm text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
            </div>

            <div class="pt-4 border-t border-gray-800">
                <a href="mailto:{{ $message->email }}?subject=Re: Your contact message&body=Dear {{ $message->fullName }},%0A%0A"
                   class="inline-flex items-center gap-2 bg-brand text-gray-50 text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-brand-dark transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Reply by Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
