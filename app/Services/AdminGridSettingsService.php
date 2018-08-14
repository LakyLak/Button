<?php  

namespace App\Services;

use Schema;
use Log;
use DB;
use Auth;

class AdminGridSettingsService
{
    public function getSettings($user, $saved = null)
    {
        $settings = DB::table('admin_grid_settings')->get();

        return $settings;
    }

    public function getColumnNames($table)
    {
        return Schema::getColumnListing($table);
    }

    public function getColumns($table)
    {
        $column_names = $this->getColumnNames($table);
        
        $columns = [];
        foreach ($column_names as $column) {
            $columns[$column] = Schema::getColumnType($table, $column);
        }
        
        return $columns;
    }

    public function getData($table)
    {
        $columns = $this->getColumns($table);

        $settings = $this->getSettingsData($table);

        $data['grid'] = $this->getGridData($settings, $columns);
        $data['filter'] = $this->getFilterData($settings, $columns);
        // $data['filter'] = $this->getDefaultFilterData($columns);
        $data['pagination'] = $this->getDefaultPaginationData();
        $data['settings'] = $settings;
        $data['model'] = $table;

        return $data;
    }

    public function getSettingsData($table)
    {
        // TODO for more settings row
        $settings = DB::table('admin_grid_settings')->where('user_id', Auth::id())->where('name', $table)->first();

        return $settings;
    }

    public function getGridData($settings, $columns)
    {
        $default_data = $this->getDefaultGridData($columns);
        if(!$settings || !$settings->grid_settings) {
            return $default_data;
        } 
        // return $default_data;

        $data  =$default_data;

        $settings = json_decode($settings->grid_settings, true);

        // take only visible fields from settings
        $default_data['visible_fields'] = $settings['visible_fields'];

        Log::info("settings\n" . print_r($settings, true));
        Log::info("default_data\n" . print_r($default_data, true));

        foreach ($settings as $field_name => $value) {
            $data[$field_name] = $value;
        }

        // TODO sorting modifications

        // $r = array_merge($settings, $default_data);
        // $r['fields']['name'] = array_merge($settings['fields']['name'], $default_data['fields']['name']);
        Log::info("data\n" . print_r($data, true));

        return $data;
    }

    public function getDefaultGridData($columns)
    {
        $grid = [];
        foreach ($columns as $name => $type) {
            if (in_array($name, ['remember_token'])) {
                continue;
            }

            if (in_array($type, ['integer'])) {
                $c['value'] = [$name, ''];
                $c['label'] = ucfirst($name);
                $c['type'] = 'number';
                $c['sortable'] = true;

                $grid['fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['string', 'text'])) {
                $c['value'] = [$name, ''];
                $c['label'] = ucfirst($name);
                $c['type'] = 'text';
                $c['sortable'] = true;

                $grid['fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['boolean'])) {
                $c['value'] = ['yes', 'no'];
                $c['label'] = ucfirst($name);
                $c['type'] = 'flag';
                $c['sortable'] = true;
                $c['additional'] = ['activable' => true, 'activation_path' => '/activate/'];

                $grid['fields'][$name] = $c;
                $c = [];
            }

            if (in_array($type, ['datetime'])) {
                $c['value'] = [$name, ''];
                $c['label'] = ucfirst($name);
                $c['type'] = 'text';
                $c['sortable'] = false;

                $grid['fields'][$name] = $c;
                $c = [];
            }

            if (in_array($name, ['image'])) {
                $grid['fields'][$name]['sortable'] = false;
            }

            // TODO add order option
            // Add columns by default in visible fields
            $grid['visible_fields'] = ['name', 'description', 'status'];
            $grid['available_actions'] = [
                'view' => ['action_path' => '/view/', 'label' => 'View', 'icon' => 'fas fa-eye'],
                'edit' => ['action_path' => '/edit/', 'label' => 'Edit', 'icon' => 'fas fa-pencil-alt'],
                'delete' => ['action_path' => '/delete/', 'label' => 'Delete', 'icon' => 'fas fa-trash', 'confirmation' => true]
            ];
            $grid['actions'] = ['view', 'edit', 'delete'];
            $grid['include_image'] = false;
            $grid['available_columns'] = $columns;
        }

        $default = [
            $default['value'] = [$name, ''],
            $default['label'] = ucfirst($name),
            $default['type'] = 'text',
            $default['sortable'] = true,
            $default['image'] = false,
            $default['options'] = [],
            $default['condition'] = 'eq',
            $default['additional'] = [],
            $xgrid['fields'][$name] = $default,
            $default = [],
        ];

        return $grid;
    }

    public function getFilterData($settings, $columns)
    {
        $default_data = $this->getDefaultFilterData($columns);
        if (!$settings || !$settings->filter_settings) {
            return $default_data;
        }
        $settings = json_decode($settings->filter_settings, true);

        return array_merge($settings, $default_data);
    }

    public function getDefaultFilterData($columns)
    {
        $name = 'name';

        $default = [
            $default['label'] = ucfirst($name),
            $default['condition'] = 'eq',
            $default['type'] = 'text',
            $default['form_name'] = $name . '_' . $default['condition'],
            $default['saved'] = 'filter_template_name',


            $default['options'] = [],
            $default['additional'] = [],
            $xgrid['fields'][$name] = $default,
            $default = [],
        ];

        $filter = [];
        foreach ($columns as $name => $type) {
            if (in_array($name, ['remember_token'])) {
                continue;
            }

            if (in_array($type, ['integer'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'number';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['string', 'text'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'text';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['boolean'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'flag';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }

            if (in_array($type, ['datetime'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'text';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }

            if (in_array($name, ['image'])) {
                $filter['filter_fields'][$name]['sortable'] = false;
            }
        }

        // $filter_fields = [
        //     'name' => [
        //         'form_name' => 'name_like',
        //         'label' => 'Name',
        //         'type' => 'text'
        //     ],
        //     'description' => [
        //         'form_name' => 'description_like',
        //         'label' => 'Description',
        //         'type' => 'text'
        //     ],
        //     'created_from' => [
        //         'form_name' => 'created_at_gte',
        //         'label' => 'Created From',
        //         'type' => 'datetime'
        //     ],
        //     'created_to' => [
        //         'form_name' => 'created_at_lte',
        //         'label' => 'Created To',
        //         'type' => 'datetime'
        //     ]
        // ];

        // $filter['filter_fields'] = $filter_fields;
        $filter['visible_fields'] = ['name', 'description'];

        return $filter;
    }

    public function getDefaultPaginationData()
    {
        $pagination['per_page'] = 15;

        return $pagination;
    }
}