@extends('layouts.admin.admin_layout')

@section('content')
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
                                    <input type="password" class="form-control {{ $errors->has('new_pwd') ? 'is-invalid' : '' }}" 
                                        id="new_pwd" name="new_pwd" placeholder="New Password Here">
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