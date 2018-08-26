<thead>
    <tr>
        @if ($data['grid']['row_numbers'] == true)
            <th></th>
        @endif
        @foreach ($data['grid']['fields'] as $field_name => $field)
            @if (!in_array($field_name, $show) || $field_name == 'image')
                @continue
            @endif
            @if ($field['sortable']) 
                <th title="Sort by clicking" scope="col">@sortablelink($field_name, $field['label'])</th>
            @else
                <th scope="col"><b>{{ $field['label'] }}</b></th>
            @endif
        @endforeach 
        {{-- TODO instead of true use Custom fields --}}
        @if(true)
            <th>Items</th>
        @endif
        @if ($data['grid']['actions'])
            <th scope="col"><b>Actions</b></th>
        @endif 
        @if ($data['grid']['include_image'])
            <th scope="col"><b>Image</b></th>
        @endif    
    </tr>
</thead>