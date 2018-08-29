{{-- Pagination settings --}}
    <div class="settings-accordion-button">
        <a class="form-control link collapsed"
            data-toggle="collapse" data-parent="#pagination_settings" href="#Toggle-pagination-settings" 
            aria-expanded="false" aria-controls="Toggle-pagination">
            <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
            <span>Pagination Settings</span>
        </a>
    </div>    
    <div id="Toggle-pagination-settings" class="collapse multi-collapse">
        <div class="card-body widget-content pagination-settings-accordion-body">
            <ul>
                <li>simple - condensed</li>
                <li>radio button: slider - pagination - no pagination</li>
            </ul>

            <div class="form-group row">
                <label for="pagination-active-pagination" class="col-sm-3 text-right control-label col-form-label">Allow Pagination</label>
                <div class="col-sm-9">
                    <input type="checkbox" class="custom-checkbox form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                        id="pagination-active-pagination" name="pagination-active-pagination" 
                        {{ $data['pagination']['active'] ? 'checked' : '' }}
                        {{-- {{ in_array($field_name, $grid_visible_fields) ? 'checked' : '' }} --}}
                        >
                    <small class="float-right text-danger">{{ $errors->first('name') }}</small>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="pagination-per_page-pagination" class="col-sm-3 text-right control-label col-form-label">Per page</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                        id="pagination-per_page-pagination" name="pagination-per_page-pagination" 
                        value={{ $data['pagination']['per_page'] }}>
                    <small class="float-right text-danger">{{ $errors->first('name') }}</small>
                </div>
            </div>

        </div>
    </div>
    <br>