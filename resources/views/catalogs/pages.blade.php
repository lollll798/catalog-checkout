<?php $page = $data['pageDetails']; ?>
<div id="pagination" style="float: left;">
    Showing {{ $page['startItemsCount'] }} to {{ $page['endItemsCount'] }} of {{ $page['totalItemsCount'] }} entries
</div>
<div style="float: right;">
    <nav>
        <ul class="pagination">
            <li class="page-item {{ $page['selectedPage'] == 1? 'disabled' : '' }}">
                <a class="page-link"  href="{{ env('HOMESTEAD_URL').'requestCatelogList?page='.($page['selectedPage'] - 1) }}" rel="prev" aria-label="Prev">‹</a>
            </li>

            @foreach ($page['pageBar'] as $bar)
                @if ($bar == $page['selectedPage'])
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $bar }}</span></li>
                @elseif ($bar == '...')
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $bar }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ env('HOMESTEAD_URL').'requestCatelogList?page='.$bar }}">{{ $bar }}</a>
                    </li>
                @endif
            @endforeach

            <li class="page-item {{ $page['selectedPage'] == $page['totalPages']? 'disabled' : '' }}">
                <a class="page-link" href="{{ env('HOMESTEAD_URL').'requestCatelogList?page='.($page['selectedPage'] + 1) }}" rel="next" aria-label="Next">›</a>
            </li>
        </ul>
    </nav>
</div>
