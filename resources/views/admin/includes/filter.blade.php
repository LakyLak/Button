{{-- filter --}}
<div class="row">
    <div class="col-md-12">
        <br>
        <a class="card-header link collapsed border-top filter-button collapsed" style="margin:0 0 0 18px; padding:0.75rem 2.75rem;" 
            data-toggle="collapse" data-parent="#filter" href="#Toggle-filter" 
            aria-expanded="{{ !empty($filter_data) ? 'true' : 'false' }}" aria-controls="Toggle-filter">
            <i class="fas fa-search" aria-hidden="true"></i>
            <span>Filter</span>
        </a>
        <div id="Toggle-filter" class="collapse multi-collapse {{ !empty($filter_data) ? 'show' : '' }}">
            <div class="card-body widget-content filter-accordion-body">
                <div class="card">
                    <form class="form-horizontal" method="post" action="{{ url($path) }}" 
                        name="filter_categories" id="filter_categories" novalidate="novalidate">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <h5 class="card-title">Filter Categories</h5>
                            <div class="row mb-3"> 
                                
                                @foreach ($filter_fields as $field)
                                    @if($field['type'] === 'text')
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                            <input type="{{ $field['type'] }}" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" class="form-control" 
                                            value="{{ !empty($filter_data) ? $filter_data[$field['form_name']] : '' }}">
                                        </div>
                                    </div>
                                    @endif
                                    @if($field['type'] === 'datepicker')
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" id="{{ $field['form_name'] }}" 
                                                    name="{{ $field['form_name'] }}" value="{{ !empty($filter_data) ? $filter_data[$field['form_name']] : '' }}">
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
    </div>
</div>