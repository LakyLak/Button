@extends('layouts.admin.admin_layout')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Item Categories</h4>
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
    {{-- TODO Vymazat falsh messages su tu len pre kopirovanie do dalsich views --}}
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
            <div class="col-12" style="margin:1rem 1rem 0;width:95%;">
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>{!! session('flash_success_message') !!}</strong>
                </div>
            </div>
        </div>
    @endif

    {{-- filter --}}
    <div class="row">
        <div class="col-md-12">
            <br>
            <a class="card-header link collapsed border-top filter-button collapsed" style="margin:0 0 0 18px; padding:0.75rem 2.75rem;" 
                data-toggle="collapse" data-parent="#filter" href="#Toggle-filter" aria-expanded="true" aria-controls="Toggle-filter">
                <i class="fas fa-search" aria-hidden="true"></i>
                <span>Filter</span>
            </a>
            <div id="Toggle-filter" class="collapse multi-collapse show">
                <div class="card-body widget-content filter-accordion-body">
                    <div class="card">
                        <form class="form-horizontal" method="post" action="{{ url('/admin/categories/filter') }}" 
                            name="filter_categories" id="filter_categories" novalidate="novalidate">{{ csrf_field() }}
                            <div class="card-body">
                                <h5 class="card-title">Filter Categories</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="name_like">Name</label>
                                            <input type="text" id="name_like" name="name_like" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="description_like">Description</label>
                                            <input type="text" id="description_like" name="description_like" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Created From</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Created To</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">Categories List</h5>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><b>Name</b></th>
                                <th scope="col"><b>Description</b></th>
                                <th scope="col"><b>Status</b></th>
                                <th scope="col"><b>Items</b></th>
                                <th scope="col"><b>Actions</b></th>
                                <th scope="col"><b>Image</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td class="text-{{ $category->status == 0 ? 'danger' : 'success' }}">
                                    {{ $category->status == 0 ? 'Not Active' : 'Active' }}
                                    @if ( $category->status == 0)
                                    <a href="{{ url('/admin/categories/change_status/'.$category->id.'/1') }}" 
                                        data-toggle="tooltip" data-placement="top" title="Activate">
                                        <i class="mdi mdi-check"></i>
                                    </a>
                                    @else
                                    <a href="{{ url('/admin/categories/change_status/'.$category->id.'/0') }}" 
                                        data-toggle="tooltip" data-placement="top" title="Deactivate">
                                        <i class="mdi mdi-close"></i>
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <a class="card-header link collapsed border-top" data-toggle="collapse" data-parent="#itmes" 
                                        href="#Toggle-{{ $category->id }}" aria-expanded="false" aria-controls="Toggle-{{ $category->id }}">
                                        <i class="fas fa-list-ul" aria-hidden="true"></i>
                                        <span>Items</span>
                                    </a>
                                    <div id="Toggle-{{ $category->id }}" class="collapse multi-collapse">
                                        <div class="card-body widget-content categories-grid-accordion-body">
                                            <ul class="categories-grid-accordion-ul">
                                                <li class="categories-grid-accordion-li">First Item</li>
                                                <li>First Item</li>
                                                <li>First Item</li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('/admin/categories/view/' . $category->id) }}"
                                         data-toggle="tooltip" data-placement="top" title="View">
                                        <i class="fas fa-eye"></i>  
                                    </a>
                                    <a href="{{ url('/admin/categories/edit/' . $category->id) }}" 
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="{{ url('/admin/categories/delete/' . $category->id) }}" 
                                        onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <td>
                                    {{ $category->image }}    
                                </td>  
                            </tr> 
                            @endforeach   
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection