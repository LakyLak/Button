@extends('layouts.admin.admin_layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal" method="post" action="{{ url('/admin/categories/add') }}" 
                    name="add_category" id="add_category" novalidate="novalidate">{{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Category Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                        id="name" name="name" placeholder="Category Name Here">
                                    <small class="float-right text-danger">{{ $errors->first('name') }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Is Active</label>
                                <div class="col-sm-9">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" checked="checked">
                                        <label class="custom-control-label" for="status"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 text-right control-label col-form-label">Upload Image</label>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input {{ $errors->has('current_pwd') ? 'is-invalid' : '' }}" id="image" name="image"  required>
                                        <label class="custom-file-label" for="image">Choose file...</label>
                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 text-right control-label col-form-label">Category Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="description" name="description">Category Description Here</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Create Category</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="row el-element-overlay">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="el-card-item">
                                {{-- <div class="el-card-avatar el-overlay-1"> <img src="{{ URL::asset('../backend/assets/images/big/img1.jpg') }}" alt="user" /> --}}
                                <div class="el-card-avatar el-overlay-1"> <img src="{{ URL::asset('../backend/assets/images/empty-image.png') }}" alt="user" />
                                    <div class="el-overlay">
                                        <ul class="list-style-none el-info">
                                            {{-- <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="../backend/assets/images/big/img1.jpg"><i class="mdi mdi-magnify-plus"></i></a></li> --}}
                                            <li class="el-item"><a class="btn default btn-outline el-link" href="javascript:void(0);"><i class="mdi mdi-link"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="el-card-content">
                                    <h4 class="m-b-0">Project title</h4> <span class="text-muted">subtitle of project</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection