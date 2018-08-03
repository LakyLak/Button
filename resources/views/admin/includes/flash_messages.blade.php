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