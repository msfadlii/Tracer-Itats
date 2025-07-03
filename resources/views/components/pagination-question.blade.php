@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">← Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-3 py-2 text-sm text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50 transition">
                ← Prev
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Dots --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-400">{{ $element }}</span>
            @endif

            {{-- Page Number Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 text-sm text-white bg-blue-600 rounded shadow font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-2 text-sm text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-3 py-2 text-sm text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50 transition">
                Next →
            </a>
        @else
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">Next →</span>
        @endif
    </nav>
@endif
