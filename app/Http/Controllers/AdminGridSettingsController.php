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
        $grid = $filter = $pagination = $export = $global_actions = null;

        $service = new AdminGridSettingsService();

        $columns = $service->getColumnNames($request->model);

        Log::info("request->all()\n" . print_r($request->all(), true));
        foreach($request->all() as $key => $value) {
            if (in_array($key, ['id', 'model', '_token'])) {
                continue;
            }
            
            $data = explode('-', $key);
            $settings_type = $data[0];
            $field_action = $data[1];
            $field = $data[2];

            if ($settings_type == 'filter') {
                $filter['filter_fields'][$field][$column] = $value;
            }
            if($settings_type == 'grid') {
                $grid['fields'][$field][$field_action] = $value;
                if($field_action == 'active' && (!isset($grid['visible_fields']) || !in_array($field, $grid['visible_fields']))) {
                    $grid['visible_fields'][] = $field;
                } 
                if($field_action == 'trueValue' && $grid['fields'][$field]['type'] == 'flag') {
                    $grid['fields'][$field]['value'][0] = $value;
                    unset($grid['fields'][$field][$field_action]);

                }
                if ($field_action == 'falseValue' && $grid['fields'][$field]['type'] == 'flag') {
                    $grid['fields'][$field]['value'][1] = $value;
                    unset($grid['fields'][$field][$field_action]);
                }
                if ($field_action == 'activable') {
                    $grid['fields'][$field]['additional'] = ['activable' => true, 'activation_path' => '/activate/'];

                    unset($grid['fields'][$field][$field_action]);
                }
            }
        }

        foreach ($grid['fields'] as $field_name => &$field) {
            $field['sortable'] = !isset($field['sortable']) ? 0 : 1;
            if (!isset($field['value'])) {
                $field['value'] =  [$field_name, ''];
            }
        }

        Log::info("grid Settings Controller\n" . print_r($grid, true));

        if ($request->id == 'new') {
            DB::table('admin_grid_settings')->insert([
                'user_id' => Auth::id(),
                'name' => $request->model,
                'grid_settings' => $grid ? json_encode($grid) : null,
                'filter_settings' => $filter ? json_encode($filter) : null,
                'pagination_settings' => $pagination ? json_encode($pagination) : null,
                'export_settings' => $export ? json_encode($export) : null,
                'global_actions' => $global_actions ? json_encode($global_actions) : null,
                'saved' => 0,
            ]);
        } else {
            $update_data = [
                'user_id' => Auth::id(),
                'name' => $request->model,
                'saved' => 0,
            ];

            if($grid) { $update_data['grid_settings'] = json_encode($grid); }
            if($filter) { $update_data['filter_settings'] = json_encode($filter); }
            if($pagination) { $update_data['pagination_settings'] = json_encode($pagination); }
            if($export) { $update_data['export_settings'] = json_encode($export); }
            if($global_actions) { $update_data['globbal_actions'] = json_encode($global_actions); }

            Log::info("update_data\n" . print_r($update_data, true));


            DB::table('admin_grid_settings')
                ->where('id', $request->id)
                ->update($update_data);
        }

        return redirect()->back();
    }
}
