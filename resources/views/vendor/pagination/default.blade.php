@if ($paginator->hasPages())
    <style>
        .paginator-nav{
            
            margin-top: auto;
            margin-bottom: 0;
        }
        ul.pagination{
            gap: 5px;
            list-style: none;
            display: flex;
        }

        ul.pagination li{
            border-radius: 5px;
            padding: 5px;
            margin: 2px;
        }
        ul.pagination li.btn{
            background-color: var(--sub2);
        }

        ul.pagination li.btn.disabled{
            background-color: rgb(126, 126, 126);
            color: rgb(212, 212, 212);
        }

        .paginator-nav a {
            text-decoration: none;
        }
        
    </style>
    <nav class="paginator-nav">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="btn disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">Previous</span>
                </li>
            @else
                <li class="btn">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="btn">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
                </li>
            @else
                <li class="btn disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
