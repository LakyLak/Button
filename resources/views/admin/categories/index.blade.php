@extends('layouts.admin.admin_layout')
@section('content')

    @include('admin.includes.filter', ['path' => Request::path()])

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 float-sm-left">Categories List</h5>
                        @include('admin.includes.pagination', ['result_info' => false])
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
                    @include('admin.includes.pagination', ['result_info' => true])
                </div>
            </div>
        </div>
    </div>
@endsection