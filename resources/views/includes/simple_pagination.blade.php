@if ( $paginator->hasPages() )
<!-- Pagination Start -->
<div class="box-footer clearfix">
    <div class="pull-left">
        Showing <strong>{{( $paginator->currentpage() - 1 ) * $paginator->perpage() + 1 }}</strong> to <strong>{{ $paginator->currentpage() * $paginator->perpage() }}</strong>
            of  <strong>{{ $paginator->total() }}</strong>
    </div>
    <ul class="pager pull-right" style="margin-top: 0;">
        {{-- First Page --}}
        <li><a href="{{ $paginator->url('first_page_url') }}">First Page</a></li>

        {{-- Previous Page Link --}}
        @if ( $paginator->currentPage() != 1 )
        <li><a href="{{ $paginator->url($paginator->currentPage() - 1) }}">&laquo; Previous Page</a></li>
        @endif
        
        {{-- Nex Page Link --}}
        @if ( $paginator->currentPage() != $paginator->lastPage() )
        <li><a href="{{ $paginator->url($paginator->currentPage() + 1) }}" rel="next">Next Page &raquo;</a></li>
        @endif

        {{-- Last Page --}}
        <li><a href="{{ $paginator->url($paginator->lastPage()) }}">Last Page</a></li>
    </ul>
</div>
<!-- Pagination end -->
@endif
