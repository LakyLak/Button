<?php
    $settings = $data['settings'];
    $id = $settings->id ?? 'new';
    $columns = $data['grid']['available_columns'];
    // $column_types = array_unique(array_values($columns));
    $model = $data['model'];
    $grid_fields = $data['grid']['fields'];
    $grid_visible_fields = $data['grid']['visible_fields'];
    $gird_available_actions = $data['grid']['available_actions'];
    $gird_actions = $data['grid']['actions'];
    $filter_fields = $data['filter']['filter_fields'];
    $filter_visible_fields = $data['filter']['visible_fields'];
?>

<div id="settings_modal" class="fade modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h2 class="modal-title">Settings</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <h5>Choose settings type</h5>
                <br>    
                <form id="settings-form" class="form-horizontal" method="post" action="{{ url('/admin/settings/grid_view_settings/'. $id   ) }}" 
                    name="grid_settings" id="grid_settings" novalidate="novalidate">{{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="model" value="{{ $model }}">
                    @include('admin.includes.settings.filter_settings')

                    @include('admin.includes.settings.grid_settings')
                    {{-- @include('admin.includes.settings.grid_settings_update') --}}

                    @include('admin.includes.settings.pagination_settings')
                    @include('admin.includes.settings.export_settings')
                    @include('admin.includes.settings.global_actions')
                </form>

            </div>
            <!-- Footer -->
            <div class="modal-footer">
                <button type="submit" form="settings-form" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


