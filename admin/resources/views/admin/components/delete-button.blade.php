@props(['action', 'label' => 'Delete', 'confirm' => 'Are you sure you want to delete this? This action cannot be undone.'])

<form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ $confirm }}')">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg
               bg-red-950 text-red-400 border border-red-900
               hover:bg-red-900 hover:text-red-300 transition-colors">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        {{ $label }}
    </button>
</form>
