@props(['items' => []])

@if(count($items) > 0)
    <nav aria-label="Breadcrumb" class="flex items-center min-w-0">
        <ol class="flex items-center space-x-1 text-sm min-w-0 overflow-hidden">
            @foreach($items as $index => $item)
                @php
                    $isLast = $index === array_key_last($items);
                    $isFirst = $index === 0;
                @endphp

                {{-- Chevron separator --}}
                @if(!$isFirst)
                    <li class="flex items-center shrink-0" aria-hidden="true">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </li>
                @endif

                <li class="flex items-center min-w-0 {{ $isLast ? '' : '' }}">
                    @if($item['href'] && !$isLast)
                        <a
                            href="{{ $item['href'] }}"
                            class="text-gray-500 hover:text-gray-700 transition truncate max-w-[120px] sm:max-w-[200px]"
                            title="{{ $item['title'] }}"
                        >
                            {{ $item['title'] }}
                        </a>
                    @else
                        <span
                            class="text-gray-900 font-semibold truncate {{ $isFirst ? 'text-[#F26C4F]' : '' }}"
                            aria-current="{{ $isLast ? 'page' : 'false' }}"
                            title="{{ $item['title'] }}"
                        >
                            {{-- Mobile: show only first and last --}}
                            @if($isFirst && count($items) > 2 && !$isLast)
                                <span class="hidden sm:inline">{{ $item['title'] }}</span>
                                <span class="sm:hidden">{{ $item['title'] }}</span>
                            @else
                                {{ $item['title'] }}
                            @endif
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
