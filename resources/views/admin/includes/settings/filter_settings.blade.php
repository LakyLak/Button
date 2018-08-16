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
                <div class="card-body">
                    <h5 class="card-title m-b-0">Filter Fields</h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
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
                                            <input type="checkbox" class="listCheckbox" {{ in_array($field_name, $filter_visible_fields) ? 'checked' : '' }}/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <td>{{ $filter_fields[$field_name]['label'] }}</td>
                                    <td>{{ $filter_fields[$field_name] ['type'] }}</td>
                                    <td>{{ $filter_fields[$field_name] ['condition'] }}</td>
                                </tr>                       
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>