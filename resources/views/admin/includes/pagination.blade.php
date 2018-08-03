{{-- Pagination --}}
<?php
    $path = Request::path(); 
    $pages = ceil($data['pagination']['total'] / $data['pagination']['per_page']);
    $per_page = $data['pagination']['per_page'];
    $total = $data['pagination']['total'];
    $current_page = $data['pagination']['current_page'];
    $result_from = 1;
    $result_to = $total < $per_page ? $total : $per_page;
    if ($current_page > 1 && $current_page != $pages) {
        $result_from = ($current_page - 1) * $per_page + 1;
        $result_to = $current_page * $per_page;
    }
    if ($current_page > 1 && $current_page == $pages) {
        $result_from = ($current_page - 1) * $per_page + 1;
        $result_to = $total;
    } 
?>
<?php Log::info("data\n" . print_r($data, true)); ?>
@if ($result_info)
    <div class="card-body">
        <div class="col-sm-5 result-info" style="display:inline-block;">
            Showing  {{ $result_from }} to  {{ $result_to }} of {{ $total }} entries
        </div>
@endif
@if ($pages > 1)
    <nav class="float-sm-right">
        <ul class="pagination">
        <li class="page-item">
                <a href="{{ url($path.'?page=1') }}" class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            @for ($i = 1; $i <= $pages; $i++)
                <li class="page-item {{ $current_page == $i ? ' active' : '' }}">
                    <a href="{{ url($path.'?page='.$i) }}" class="page-link">{{ $i }}</a>
                </li>
                @if ($i > 7) 
                    @break
                @endif
            @endfor

            <li class="page-item">
                <a href="{{ url($path.'?page='.$pages) }}" class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
@endif
@if ($result_info)
    </div>
@endif