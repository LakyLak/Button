<tbody>
    @foreach ($items as $item)
        <tr>
            @if ($data['grid']['row_numbers'] == true)
                <td>{{ $row_number++ }}</td>
            @endif
            {{-- <td>{{ $data['grid']['fields']['row_number']['value'] }}</td> --}}
            @foreach ($data['grid']['fields'] as $field_name => $field)
                @if (!in_array($field_name, $show)) 
                    @continue
                @endif
                @if ($field['type'] == 'flag')
                    <td class="text-{{ $item->$field_name ? 'success' : 'danger' }}">
                        {{ $item->$field_name ? $field['value'][0] : $field['value'][1] }}
                        @if (isset($field['additional']['activable']) && $field['additional']['activable']) 
                            @if ($item->$field_name)
                            <a href="{{ url($path . $field['additional']['activation_path'] . $item->id.'/0') }}" 
                                data-toggle="tooltip" data-placement="top" title="Deactivate">
                                <i class="mdi mdi-close"></i>
                            </a>
                            @else
                            <a href="{{ url($path . $field['additional']['activation_path'] . $item->id.'/1') }}" 
                                data-toggle="tooltip" data-placement="top" title="Activate">
                                <i class="mdi mdi-check"></i>
                            </a>
                            @endif
                        @endif
                    </td>
                @endif
                
                @if ($field['type'] != 'flag')
                    <td>{{ $item->$field_name ?: $field['value'][1] }}</td>
                @endif
                
            @endforeach

            {{-- TODO instead of true use Custom fields --}}
            @if(true)
                <td>
                    <a class="card-header link collapsed border-top" data-toggle="collapse" data-parent="#itmes" 
                        href="#Toggle-{{ $item->id }}" aria-expanded="false" aria-controls="Toggle-{{ $item->id }}">
                        <i class="fas fa-list-ul" aria-hidden="true"></i>
                        <span>Items</span>
                    </a>
                    <div id="Toggle-{{ $item->id }}" class="collapse multi-collapse">
                        <div class="card-body widget-content categories-grid-accordion-body">
                            <ul class="categories-grid-accordion-ul">
                                {{-- TODO add foreach based on relation --}}
                                <li class="categories-grid-accordion-li">First Item</li>
                                <li>First Item</li>
                                <li>First Item</li>
                            </ul>
                        </div>
                    </div>
                </td>
            @endif

            @if ($data['grid']['actions'])
                <td>
                    @foreach ($data['grid']['available_actions'] as $action_name => $action)
                        @if(in_array($action_name, $data['grid']['actions']))
                            <a href="{{ url($path . $action['action_path'] . $item->id) }}" data-toggle="tooltip" data-placement="top" 
                                {{ !empty($action['confirmation']) ? "onclick=\"return confirm('Are you sure?')\"" : "" }} 
                                title="{{ $action['label'] }}">
                                <i class="{{ $action['icon'] }}"></i>  
                            </a>
                        @endif
                    @endforeach
                </td>
            @endif
            @if ($data['grid']['include_image'] )
                <td>{{ $item->image ?: 'Some general image' }}</td>
            @endif
        </tr>

    @endforeach
</tbody>

{{-- TODO Items or database relations grid view with accordion + actions --}}
{{-- 
    <td>
        <a class="card-header link collapsed border-top" data-toggle="collapse" data-parent="#itmes" 
            href="#Toggle-{{ $item->id }}" aria-expanded="false" aria-controls="Toggle-{{ $item->id }}">
            <i class="fas fa-list-ul" aria-hidden="true"></i>
            <span>Items</span>
        </a>
        <div id="Toggle-{{ $item->id }}" class="collapse multi-collapse">
            <div class="card-body widget-content categories-grid-accordion-body">
                <ul class="categories-grid-accordion-ul">
                    <li class="categories-grid-accordion-li">First Item</li>
                    <li>First Item</li>
                    <li>First Item</li>
                </ul>
            </div>
        </div>
    </td>
--}}


