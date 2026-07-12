@if ($paginator->hasPages())
<nav class="flex items-center justify-between px-1 mt-4">
    <p class="text-sm text-gray-400">
        Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </p>
    <div class="flex gap-1">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 text-sm rounded-lg bg-gray-800 text-gray-300 cursor-default">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-sm rounded-lg bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors">←</a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1.5 text-sm text-gray-400">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 text-sm rounded-lg bg-brand text-gray-50 font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-sm rounded-lg bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-sm rounded-lg bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors">→</a>
        @else
            <span class="px-3 py-1.5 text-sm rounded-lg bg-gray-800 text-gray-300 cursor-default">→</span>
        @endif
    </div>
</nav>
@endif
