<div class="settings-accordion-button">
        <a class="form-control link collapsed"
            data-toggle="collapse" data-parent="#filter_settings" href="#Toggle-filter-settings" 
            aria-expanded="false" aria-controls="Toggle-filter">
            <i class="fas fa-search" aria-hidden="true"></i>
            <span>Filter Settings</span>
        </a>
    </div>    
    <div id="Toggle-filter-settings" class="collapse multi-collapse">
        <div class="card-body widget-content filter-settings-accordion-body">
            <div class="card">
                <div class="col-md-6">
                        <label class="customcheckbox col-md-4">
                            Show Filter
                        </label>
                        <input type="checkbox" name="filter-show-filter" class="listCheckbox col-md-2" {{ $data['filter']['show_filter'] ? 'checked' : '' }}/>
                            <span class="checkmark"></span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Filter Fields</h5>
                        </div>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Active</th>
                                <th scope="col">Label</th>
                                <th scope="col">Type</th>
                                <th scope="col">Condition</th>
                            </tr>
                        </thead>
                        <tbody class="customtable">
                            @foreach ($columns as $field_name => $field)
                                @if (in_array($field_name, ['remember_token', 'image']))
                                    @continue
                                @endif
                                <tr>
                                    <th>
                                        <label class="customcheckbox">
                                            <input type="checkbox" class="listCheckbox" id="filter-active-{{ $field_name }}" 
                                                name="filter-active-{{ $field_name }}"
                                                {{ in_array($field_name, $filter_visible_fields) ? 'checked' : '' }}/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                            id="filter-label-{{ $field_name }}" name="filter-label-{{ $field_name }}" 
                                            placeholder="Field Label" value={{ $filter_fields[$field_name]['label'] }}>
                                    </td>
                                    <td>    
                                        @if (in_array($field, ['string', 'integer', 'boolean']))
                                            <select class="form-control" id="filter-type-{{ $field_name }}" 
                                            name="filter-type-{{ $field_name }}">
                                                <option value="{{ $field }}" {{ $filter_fields[$field_name]['type'] != 'select' ? 'selected' : '' }}>
                                                    {{ $field }}
                                                </option>
                                                <option value="select" {{ $filter_fields[$field_name]['type'] == 'select' ? 'selected' : '' }}>
                                                    select
                                                </option>
                                            </select>
                                        @else
                                            {{ $filter_fields[$field_name]['type'] }}
                                        @endif
                                    </td>
                                    <td>
                                        
                                        @if(!in_array($filter_fields[$field_name]['type'], ['boolean', 'select']))
                                        <select class="form-control" id="filter-condition-{{ $field_name }}" 
                                            name="filter-condition-{{ $field_name }}">
                                                <option value="eq" {{ $filter_fields[$field_name]['condition'] == 'eq' ? 'selected' : ''}}>eq</option>
                                            @if(in_array($field, ['string', 'text']))
                                                <option value="like"{{ $filter_fields[$field_name]['condition'] == 'like' ? 'selected' : ''}}>like</option>
                                            @endif
                                            @if(in_array($filter_fields[$field_name]['type'], ['datetime', 'integer']))
                                                <option value="lt" {{ $filter_fields[$field_name]['condition'] == 'lt' ? 'selected' : ''}}>lt</option>
                                                <option value="lte" {{ $filter_fields[$field_name]['condition'] == 'lte' ? 'selected' : ''}}>lte</option>
                                                <option value="gt" {{ $filter_fields[$field_name]['condition'] == 'gt' ? 'selected' : ''}}>gt</option>
                                                <option value="gte" {{ $filter_fields[$field_name]['condition'] == 'gte' ? 'selected' : ''}}>gte</option>
                                            @endif
                                        </select>
                                        @endif
                                    </td>
                                </tr>                       
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>