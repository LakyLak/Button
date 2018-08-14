
{{-- import grid --}}
<?php 
    $path = Request::path(); 
    $show = $data['grid']['visible_fields'];
?>
<table class="table">
    @include('admin.grid.grid_header', ['show' => $show])
    @include('admin.grid.grid_fields', ['show' => $show])

</table>