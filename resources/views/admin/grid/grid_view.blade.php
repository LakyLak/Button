
{{-- import grid --}}
<?php 
    $path = Request::path(); 
    $show = $data['grid']['visible_fields'];
    // isset($data['pagination']['current_page']) &&
    if (isset($data['pagination']['current_page'])) {
        $current_page = $data['pagination']['current_page'] ? $data['pagination']['current_page'] -1 : 0;
        $row_number = 1 + ($current_page * $data['pagination']['per_page']);
    } else {
        $row_number = 1;
    }
?>
<table class="table">
    @include('admin.grid.grid_header', ['show' => $show])
    @include('admin.grid.grid_fields', ['show' => $show])

</table>