    <div class="settings-accordion-button">
        <a class="form-control link collapsed"
            data-toggle="collapse" data-parent="#grid_settings" href="#Toggle-grid-settings" 
            aria-expanded="false" aria-controls="Toggle-filter">
            <i class="fas fa-list-ol" aria-hidden="true"></i>
            <span>Grid Settings</span>
        </a>
    </div>    
    <div id="Toggle-grid-settings" class="collapse multi-collapse">
        <div class="card-body widget-content filter-settings-accordion-body">

            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Grid View Fields</h5>
                        </div>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Active</th>
                                <th scope="col">Label</th>
                                <th scope="col">Type</th>
                                <th scope="col">Sortable</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody class="customtable">
                            @foreach ($columns as $field_name => $type)
                                @if (in_array($field_name, ['remember_token', 'image']))
                                    @continue
                                @endif
                                <tr>
                                    <td>
                                        <label class="customcheckbox">
                                            <input type="checkbox" class="listCheckbox" id="grid-active-{{ $field_name }}" 
                                                name="grid-active-{{ $field_name }}"
                                                {{ in_array($field_name, $grid_visible_fields) ? 'checked' : '' }}/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                            id="grid-label-{{ $field_name }}" name="grid-label-{{ $field_name }}" 
                                            placeholder="Field Label" value={{ $grid_fields[$field_name]['label'] }}>
                                        {{-- <small class="float-right text-danger">{{ $errors->first('grid-label-{{ $field_name }}') }}</small> --}}
                                    </td>
                                    <td>
                                        {{ $type }}
                                        {{-- <input type="hidden" id="grid-type-{{ $field_name }}"" name="grid-type-{{ $field_name }}"
                                            value={{ $grid_fields[$field_name]['type'] }}> --}}

                                        <input type="hidden" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                            id="grid-type-{{ $field_name }}" name="grid-type-{{ $field_name }}" 
                                            placeholder="Field Type" value={{ $grid_fields[$field_name]['type'] }}>
                                        {{-- <small class="float-right text-danger">{{ $errors->first('grid-type-{{ $field_name }}') }}</small> --}}
                                    </td>
                                    <td>
                                        <input type="checkbox" class="listCheckbox" id="grid-sortable-{{ $field_name }}" 
                                            name="grid-sortable-{{ $field_name }}" {{ $grid_fields[$field_name]['sortable'] ? 'checked' : '' }}/>
                                        <span class="checkmark"></span>
                                    <td></td>
                                </tr>
                                @if ($type == 'boolean')
                                    <tr>
                                        <td class="border-top-0">Values</td>
                                        <td class="border-top-0">
                                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                                id="grid-trueValue-{{ $field_name }}" name="grid-trueValue-{{ $field_name }}" 
                                                placeholder="Field value if true" value={{ $grid_fields[$field_name]['value'][0] ?? 'yes' }}>
                                        </td>
                                        <td class="border-top-0">
                                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                                                id="grid-falseValue-{{ $field_name }}" name="grid-falseValue-{{ $field_name }}" 
                                                placeholder="Field value if false" value={{ $grid_fields[$field_name]['value'][1] ?? 'no' }}>
                                        </td>
                                        <td class="border-top-0">
                                            Activable
                                        </td>
                                        <td class="border-top-0">
                                            <div class="col-sm-12">
                                                
                                                <input type="checkbox" class="listCheckbox" id="grid-activable-{{ $field_name }}" 
                                                    name="grid-activable-{{ $field_name }}" {{ isset($grid_fields[$field_name]['additional']['activable']) ? 'checked' : '' }}/>
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Grid Actions</h5>
                        </div>
                        <tbody class="customtable">
                            <tr>
                                @foreach ($gird_available_actions as $action_name =>$action)
                                    <td scope="col">
                                        <label class="customcheckbox">
                                            <input type="checkbox" class="listCheckbox" name="grid-{{ $action_name }}-action"
                                                {{ in_array($action_name, $gird_actions) ? 'checked' : '' }}/>
                                            <span class="checkmark"></span>
                                        </label>
                                        {{ $action['label'] }}
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <h5 class="card-title m-b-0">Additional Actions</h5>
                </div>
                <div class="col-md-6">
                    @if (in_array('image', array_keys($columns)))
                        <label class="customcheckbox col-md-4">
                            Include Image
                        </label>
                        <input type="checkbox" name="grid-include-image" class="listCheckbox col-md-2" {{ $data['grid']['include_image'] ? 'checked' : '' }}/>
                            <span class="checkmark"></span>
                    @endif
                </div>
                <div class="col-md-6">
                    @if (in_array('image', array_keys($columns)))
                        <label class="customcheckbox col-md-4">
                            Number Rows
                        </label>
                        <input type="checkbox" name="grid-include-row_numbers" class="listCheckbox col-md-2" {{ $data['grid']['row_numbers'] ? 'checked' : '' }}/>
                            <span class="checkmark"></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br>