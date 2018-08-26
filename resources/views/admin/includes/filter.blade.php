{{-- filter --}}
<?php
    $filter_data = $data['filter']['filter_data'];
    $filter_fields = $data['filter']['filter_fields'];
    $visible_fields = $data['filter']['visible_fields'];
?>
<?php $available_options = []; ?>
<div id="Toggle-filter" class="collapse multi-collapse {{ !empty($filter_data) ? 'show' : '' }}">
    <div class="card-body widget-content filter-accordion-body">
        <div class="card">
            <form class="form-horizontal" method="get" action="{{ url(Request::path()) }}" 
                name="filter_categories" id="filter_categories" novalidate="novalidate">
                <div class="card-body">
                    <h5 class="card-title">Filter Categories</h5>
                    <div class="row mb-3"> 
                        @foreach ($filter_fields as $field_name => $field)
                            @if(!in_array($field_name, $visible_fields))
                                @continue
                            @endif

                        
                            @if ($field['type'] == 'select' )
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                    <select class="form-control" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}">
                                        <option value="" {{ (count($items) == 0 || empty($filter_data) || !isset($filter_data[$field['form_name']])) ? 'selected' : ''}}>
                                            Choose {{ $field_name }}
                                        </option>
                                        {{-- @if(in_array($field_name, ['status'])) --}}
                                        @if($data['grid']['fields'][$field_name]['type'] == 'flag')
                                            <option value="on" {{ !empty($filter_data) && $filter_data[$field['form_name']] == 'on' ? 'selected' : ''}}>
                                                {{ $data['grid']['fields'][$field_name]['value'][0] }}
                                            </option>
                                            <option value="off" {{ !empty($filter_data) && $filter_data[$field['form_name']] == 'off' ? 'selected' : ''}}>
                                                {{ $data['grid']['fields'][$field_name]['value'][1] }}
                                            </option>
                                        @else
                                            @foreach (count($items) > 0 ? $items : $data['filter']['select_items'] as $item)
                                                @if(!in_array($item->$field_name, $available_options)) {
                                                    <?php $available_options[] = $item->$field_name ?>
                                                    <option value="{{ $item->$field_name }}" 
                                                        {{ (count($items) > 0 && !empty($filter_data) && $filter_data[$field['form_name']] == $item->$field_name) ? 'selected' : ''}}>
                                                        {{ $item->$field_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif

                            @if($field['type'] === 'integer')
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" 
                                    class="form-control"
                                    value="{{ !empty($filter_data[$field['form_name']]) ? $filter_data[$field['form_name']] : '' }}">
                                </div>
                            </div>
                            @endif
                            
                            @if($field['type'] === 'string')
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" 
                                    class="form-control" placeholder="Type {{ $field['label'] }}"
                                    value="{{ !empty($filter_data[$field['form_name']]) ? $filter_data[$field['form_name']] : '' }}">
                                </div>
                            </div>
                            @endif
                            
                            @if($field['type'] === 'text')
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" 
                                    class="form-control" placeholder="Type {{ $field['label'] }}"
                                    value="{{ !empty($filter_data[$field['form_name']]) ? $filter_data[$field['form_name']] : '' }}">
                                </div>
                            </div>
                            @endif
                        
                            @if($field['type'] === 'boolean')
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="{{ $field['form_name'] }}">{{ $field['label'] }}</label>
                                    <input type="hidden" name="{{ $field['form_name'] }}" value="0">
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
                                        <input type="text" class="form-control mydatepicker" placeholder="dd-mm-yyyy" 
                                            id="{{ $field['form_name'] }}" name="{{ $field['form_name'] }}" 
                                            value="{{ !empty($filter_data[$field['form_name']]) ? $filter_data[$field['form_name']] : '' }}">   
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="created_at_gte">Created From</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="dd-mm-yyyy" 
                                        id="created_at_gte" name="created_at_gte" 
                                        value="{{ !empty($filter_data['created_at_gte']) ? $filter_data['created_at_gte'] : '' }}">   
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="created_at_lte">Created To</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="dd-mm-yyyy" 
                                        id="created_at_lte" name="created_at_lte" 
                                        value="{{ !empty($filter_data['created_at_lte']) ? $filter_data['created_at_lte'] : '' }}">   
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                            
                    <button type="submit" class="btn btn-success">Search</button>
                    <a type="button" href={{ url('/admin/categories') }} class="btn btn-primary">Clear Search</a>
                </div>
            </div>
        </form>
    </div>
</div>