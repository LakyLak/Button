<?php  

namespace App\Services;

use Schema;
use Log;
use DB;
use Auth;

class AdminGridSettingsService
{
    public function __construct($table)
    {
        $this->table = $table;
    }

    
    public function getSettings($user, $saved = null)
    {
        $settings = DB::table('admin_grid_settings')->get();

        return $settings;
    }

    public function getColumnNames()
    {
        return Schema::getColumnListing($this->table);
    }

    public function getColumns()
    {
        $column_names = $this->getColumnNames();
        
        $columns = [];
        foreach ($column_names as $column) {
            $columns[$column] = Schema::getColumnType($this->table, $column);
        }
        
        return $columns;
    }

    public function getData($table)
    {
        $columns = $this->getColumns($table);

        $settings = $this->getSettingsData();

        $data['grid'] = $this->getGridData($settings, $columns);
        $data['filter'] = $this->getFilterData($settings, $columns);
        // $data['filter'] = $this->getDefaultFilterData($columns);
        $data['pagination'] = $this->getPaginationData($settings);
        // $data['pagination'] = $this->getDefaultPaginationData();
        $data['settings'] = $settings;
        $data['model'] = $table;

        return $data;
    }

    public function getSettingsData()
    {
        // TODO for more settings row
        $settings = DB::table('admin_grid_settings')->where('user_id', Auth::id())->where('name', $this->table)->first();

        return $settings;
    }

    public function getGridData($settings, $columns)
    {
        $custom_data = $this->getGridCustomFields();
        $default_data = $this->getDefaultGridData($columns);
        if(!$settings || empty($settings->grid_settings)) {
            return $default_data;
        } 
        $data  = $default_data;

        $settings = json_decode($settings->grid_settings, true);

        foreach ($settings as $field_name => $value) {
            $data[$field_name] = $value;
        }

        // TODO sorting modifications
        
        return $data;
    }

    private function getGridCustomFields()
    {

    }

    public function getDefaultGridData($columns)
    {
        $grid = [];

        foreach ($columns as $name => $type) {
            if (in_array($name, ['remember_token'])) {
                continue;
            }

            if (in_array($type, ['integer', 'decimal'])) {
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
            $grid['row_numbers'] = false;
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
        if (!$settings || empty($settings->filter_settings)) {
            return $default_data;
        }
        $settings = json_decode($settings->filter_settings, true);

        $filter = $default_data;

        $filter['visible_fields'] = $settings['visible_fields'];
        $filter['show_filter'] = $settings['show_filter'];
        $filter['filter_fields'] = $default_data['filter_fields'];

        foreach ($settings['filter_fields'] as $field_name => $actions) {
            foreach ($actions as $action => $value) {
                $filter['filter_fields'][$field_name][$action] = $value;
                if($action == 'condition') {
                    $filter['filter_fields'][$field_name]['form_name'] = $field_name . '_' . $value;
                }
            }
        }

        return $filter;
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

            if (in_array($type, ['integer', 'decimal'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'number';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['string'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = $type;
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';


                $filter['filter_fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['text'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = $type;
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }
            if (in_array($type, ['boolean'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'boolean';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }

            if (in_array($type, ['datetime'])) {
                $c['label'] = ucfirst($name);
                $c['type'] = 'datetime';
                $c['form_name'] = $name . '_eq';
                $c['condition'] = 'eq';
                

                $filter['filter_fields'][$name] = $c;
                $c = [];
            }

        }

        $filter['show_filter'] = true;
        $filter['visible_fields'] = ['name', 'description'];

        return $filter;
    }

    private function getPaginationData($settings)
    {
        $default_data = $this->getDefaultPaginationData();

        if (!$settings || empty($settings->pagination_settings)) {
            return $default_data;
        }

        return json_decode($settings->pagination_settings, true);
    }

    public function getDefaultPaginationData()
    {
        $pagination['per_page'] = 15;
        $pagination['active'] = true;

        return $pagination;
    }
}