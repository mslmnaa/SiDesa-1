@if ($paginator->hasPages())
    <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-4 bg-white rounded-xl p-4 sm:p-6 border border-gray-100">
        <!-- Results Info -->
        <div class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold text-[#3BB77E]">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
            dari <span class="font-semibold">{{ $paginator->total() }}</span> data
        </div>

        <!-- Pagination Links -->
        <nav role="navigation" aria-label="Navigasi halaman">
            <ul class="flex flex-wrap items-center justify-center gap-x-1.5 gap-y-3 sm:gap-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="inline-block px-3 sm:px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            ‹ Sebelumnya
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}"
                           class="inline-block px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-[#3BB77E] hover:text-white hover:border-[#3BB77E] transition-all duration-200">
                            ‹ Sebelumnya
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li>
                            <span class="inline-block px-3 sm:px-4 py-2 text-sm font-medium text-gray-500">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="inline-block px-3 sm:px-4 py-2 text-sm font-bold text-white bg-[#3BB77E] rounded-lg shadow-md">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}"
                                       class="inline-block px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-[#3BB77E] hover:text-white hover:border-[#3BB77E] transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}"
                           class="inline-block px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-[#3BB77E] hover:text-white hover:border-[#3BB77E] transition-all duration-200">
                            Berikutnya ›
                        </a>
                    </li>
                @else
                    <li>
                        <span class="inline-block px-3 sm:px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            Berikutnya ›
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
