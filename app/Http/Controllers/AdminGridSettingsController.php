<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Auth;
use Log;
use App\Services\AdminGridSettingsService;

class AdminGridSettingsController extends Controller
{
    
    public function grid_view_settings(Request $request)
    {
        $grid = $filter = $pagination = $export = $global = [];
        
        $data = ['filter' => [], 'grid' => [], 'pagination' => [], 'export' => [], 'global' => []];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['id', 'model', '_token'])) {
                continue;
            }
            $key_values = explode('-', $key);
            $settings_type = $key_values[0];
            $field_action = $key_values[1];
            $field = $key_values[2];
            $data[$settings_type][$field . '-' . $field_action] = $value;
        }
        
        if($data['filter']) { $filter = $this->filter_settings($data['filter']); }
        if($data['grid']) { $grid = $this->grid_settings($data['grid']); }
        if($data['pagination']) { $pagination = $this->pagination_settings($data['pagination']); }
        if($data['export']) { $export = $this->export_settings($data['export']); }
        if($data['global']) { $global = $this->global_settings($data['global']); }
        
        $db_data = [
            'user_id' => Auth::id(),
            'name' => $request->model,
            'saved' => 0,
        ];
        if($grid || $request->id == 'new') { $db_data['grid_settings'] = json_encode($grid); }
        if($filter || $request->id == 'new') { $db_data['filter_settings'] = json_encode($filter); }
        if($pagination || $request->id == 'new') { $db_data['pagination_settings'] = json_encode($pagination); }
        if($export || $request->id == 'new') { $db_data['export_settings'] = json_encode($export); }
        if($global || $request->id == 'new') { $db_data['global_actions'] = json_encode($global); }

        if ($request->id == 'new') {
            DB::table('admin_grid_settings')
            ->insert($db_data);
        } else {
            DB::table('admin_grid_settings')
            ->where('id', $request->id)
            ->update($db_data);
        }
        
        $model = $request->model ?? '';
        
        return redirect('/admin/' . $model);
    }


    private function grid_settings($data)
    {
        $grid = [];

        foreach ($data as $field_actions => $value) {
            $fields = explode('-', $field_actions);
            $field_name = $fields[0];
            $field_action = $fields[1];

            if ($field_name == 'action') {
                $grid['actions'][] = $field_action;
            }
            elseif ($field_name == 'image') {
                $grid['include_image'] = true;
            } elseif ($field_name == 'row_numbers') {
                $grid['row_numbers'] = true;
            }
            else {
                $grid['fields'][$field_name][$field_action] = $value;
                if ($field_action == 'active' && (!isset($grid['visible_fields']) || !in_array($field_name, $grid['visible_fields']))) {
                    $grid['visible_fields'][] = $field_name;
                }
                if ($field_action == 'trueValue' && $grid['fields'][$field_name]['type'] == 'flag') {
                    $grid['fields'][$field_name]['value'][0] = $value;
                    unset($grid['fields'][$field_name][$field_action]);

                }
                if ($field_action == 'falseValue' && $grid['fields'][$field_name]['type'] == 'flag') {
                    $grid['fields'][$field_name]['value'][1] = $value;
                    unset($grid['fields'][$field_name][$field_action]);
                }
                if ($field_action == 'activable') {
                    $grid['fields'][$field_name]['additional'] = ['activable' => true, 'activation_path' => '/activate/'];

                    unset($grid['fields'][$field_name][$field_action]);
                }
            }
        }

        foreach ($grid['fields'] as $field_name => &$field) {
            $field['sortable'] = !isset($field['sortable']) ? 0 : 1;
            if (!isset($field['value'])) {
                $field['value'] = [$field_name, ''];
            }
        }

        return $grid;
    }

    private function filter_settings($data)
    {
        $filter = [];
        Log::info(basename(__FILE__).":".__LINE__. " data\n" . print_r($data, true));

        foreach ($data as $field_actions => $value) {
            if($field_actions == 'filter-show') {
                continue;
            }
            $fields = explode('-', $field_actions);
            $field_name = $fields[0];
            $field_action = $fields[1];

            $filter['filter_fields'][$field_name][$field_action] = $value;
            if ($field_action == 'active' && (!isset($filter['visible_fields']) || !in_array($field_name, $filter['visible_fields']))) {
                $filter['visible_fields'][] = $field_name;
            }
        }

        $filter['show_filter'] = $data['filter-show'] ?? 0;

        return $filter;
    }

    private function pagination_settings($data)
    {
        $pagination = [];

        foreach ($data as $field_actions => $value) {
            $fields = explode('-', $field_actions);
            $field_name = $fields[0];
            $field_action = $fields[1];

            $pagination[$field_action] = $value;
        }

        return $pagination;
    }

    private function export_settings($data)
    {

    }

    private function global_settings($data)
    {

    }
}
