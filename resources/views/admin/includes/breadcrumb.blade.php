<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <?php  
                $data = explode('/', $path);
                $parent_path = "$data[0]/$parent";
                $model = $data[1];
                $model_path = "$data[0]/$data[1]";
                $action = $data[2] ?? null;
                $singular_model = Illuminate\Support\Pluralizer::singular($model);
            ?>
            <h4 class="page-title">{{ $action ? ucfirst($action) ." ". ucfirst($singular_model) : ucfirst($model) }}</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if($model != $parent)
                            <li class="breadcrumb-item active"><a href='{{ url($parent_path) }}'>{{ ucfirst($parent) }}</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href='{{ url($model_path) }}'>{{ ucfirst($model) }}</a></li>
                        @endif
                        @if($action)
                            <li class="breadcrumb-item"><a href='{{ url($path) }}'>{{ ucfirst($action) }}</a></li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
