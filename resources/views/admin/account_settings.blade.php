@extends('layouts.admin.admin_layout')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Account Settings</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('flash_error_message'))
        <div class="row">
            <div class="col-12" sstyle="margin:1rem 1rem 0;">
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{!! session('flash_error_message') !!}</strong>
                </div>
            </div>
        </div>
        @endif
    @if(Session::has('flash_success_message'))
        <div class="row">
            <div class="col-12" style="margin:1rem 1rem 0;">
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>{!! session('flash_success_message') !!}</strong>
                </div>
            </div>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="form-horizontal" method="post" action="{{ url('/admin/update_password') }}" >{{ csrf_field() }}
                        <div class="card-body">
                            <h4 class="card-title">Password Update</h4>
                            <div class="form-group row">
                                <label for="current_pwd" class="col-sm-3 text-right control-label col-form-label">Current Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control {{ $errors->has('current_pwd') ? 'is-invalid' : '' }}" id="current_pwd" name="current_pwd" placeholder="Current Password Here">
                                    <small class="float-right text-danger">{{ $errors->first('current_pwd') }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_pwd" class="col-sm-3 text-right control-label col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control {{ $errors->has('new_pwd') ? 'is-invalid' : '' }}" id="new_pwd" name="new_pwd" placeholder="New Password Here">
                                    <small class="float-right text-danger">{{ $errors->first('new_pwd') }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirm_pwd" class="col-sm-3 text-right control-label col-form-label">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control {{ $errors->has('confirm_pwd') ? 'is-invalid' : '' }}" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password Here">
                                    <small class="float-right text-danger">{{ $errors->first('confirm_pwd') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    
                </div>
            </div>
        </div>

    </div>
@endsection