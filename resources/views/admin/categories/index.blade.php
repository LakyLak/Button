@extends('layouts.admin.admin_layout')
@section('content')

@include('admin.includes.filter')

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