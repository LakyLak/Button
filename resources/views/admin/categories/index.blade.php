@extends('layouts.admin.admin_layout')
@section('content')

<?php
    $filter_present = $data['filter']['show_filter'];
    $settings_present = true;
?>
<div class="row">
    <div class="col-md-12">
        <br>
        @if($filter_present)
            <a class="card-header link collapsed border-top filter-button collapsed grid-view-link"
            data-toggle="collapse" data-parent="#filter" href="#Toggle-filter" 
            aria-expanded="{{ !empty($filter_data) ? 'true' : 'false' }}" aria-controls="Toggle-filter">
            <i class="fas fa-search" aria-hidden="true"></i>
            <span>Filter</span>
        </a>
        @endif
        @if($settings_present)
        <a class="card-header link grid-view-link" data-toggle="modal" data-target="#settings_modal">
            <i class="fas fa-cog" aria-hidden="true"></i>
            <span>Settings</span>
        </a>
        @endif

        {{-- @if($filter_present) --}}
        <a class="card-header link grid-view-link" href="{{ url(Request::path()) }}">
            <i class="fas fa-times" aria-hidden="true"></i>
            <span>Reset</span>
        </a>
        {{-- @endif --}}
        @if($filter_present)
            @include('admin.includes.filter')
        @endif
        @if($settings_present)
            @include('admin.includes.settings.settings')
        @endif
    </div>
    
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title m-b-0 float-sm-left">Categories List</h5>
                    @include('admin.includes.pagination', ['result_info' => false])
                </div>
                @include('admin.grid.grid_view')
                @include('admin.includes.pagination', ['result_info' => true])
            </div>
        </div>
    </div>
</div>

@endsection