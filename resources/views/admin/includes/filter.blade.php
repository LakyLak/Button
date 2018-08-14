{{-- filter --}}
<?php
    $path = Request::path();
    $filter_data = $data['filter']['filter_data'];
    $filter_fields = $data['filter']['filter_fields'];
    $visible_fields = $data['filter']['visible_fields'];
?>
<div class="row">
    <div class="col-md-12">
        <br>
        <a class="card-header link collapsed border-top filter-button collapsed grid-view-link"
            data-toggle="collapse" data-parent="#filter" href="#Toggle-filter" 
            aria-expanded="{{ !empty($filter_data) ? 'true' : 'false' }}" aria-controls="Toggle-filter">
            <i class="fas fa-search" aria-hidden="true"></i>
            <span>Filter</span>
        </a>
        <a class="card-header link grid-view-link" data-toggle="modal" data-target="#settings_modal">
            <i class="fas fa-cog" aria-hidden="true"></i>
            <span>Settings</span>
        </a>
        <a class="card-header link grid-view-link" href="{{ url($path) }}">
            <i class="fas fa-times" aria-hidden="true"></i>
            <span>Reset</span>
        </a>
        <div id="Toggle-filter" class="collapse multi-collapse {{ !empty($filter_data) ? 'show' : '' }}">
            <div class="card-body widget-content filter-accordion-body">
                <div class="card">
                    <form class="form-horizontal" method="get" action="{{ url($path) }}" 
                        name="filter_categories" id="filter_categories" novalidate="novalidate">
                        <div class="card-body">
                            <h5 class="card-title">Filter Categories</h5>
                            <div class="row mb-3"> 
                                @foreach ($filter_fields as $field_name => $field)
                                    @if(!in_array($field_name, $visible_fields))
                                        @continue
                                    @endif
                                
                                    @if($field['type'] === 'text')
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                            <input type="{{ $field['type'] }}" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" class="form-control" 
                                            value="{{ !empty($filter_data[$field['form_name']]) ? $filter_data[$field['form_name']] : '' }}">
                                        </div>
                                    </div>
                                    @endif

                                    @if($field['type'] === 'flag')
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                            <input type="checkbox" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" class="form-control" 
                                            {{ !empty($filter_data[$field['form_name']]) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    @endif

                                    @if($field['type'] === 'datetime')
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" id="{{ $field['form_name'] }}" 
                                                    name="{{ $field['form_name'] }}" 
                                                    value="{{ !empty($filter_data[$field['form_name']]) ? $filter_data[$field['form_name']] : '' }}">   
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                
                            </div>
                                    
                            <button type="submit" class="btn btn-success">Search</button>
                            <a type="button" href={{ url('/admin/categories') }} class="btn btn-primary">Clear Search</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('admin.includes.settings')
    </div>
</div>