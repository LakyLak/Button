<?php

    function filter_conditions($filter_data)
    {


        $datetimes = ['created_at', 'updated_at', 'date'];
        $conditions = [];
        
        foreach ($filter_data as $field => $value) {
            if (empty($value) || $field == '_token') {continue;}

            $data_field = explode('_', $field);

            if (substr_count($field, '_') > 1) {
                $options = [implode('_', explode('_', $field, -1)), end($data_field)];
            } else {
                $options = $data_field;
            }

            if (in_array($options[0], $datetimes)) {
                $value = date("Y-m-d h:i:s", strtotime($value));
            }

            // echo '<pre>'; print_r($options); die;

            switch ($options[1]) {
                case 'like':
                    $conditions[] = [$options[0], 'LIKE', '%'.$value.'%'];
                    break;
                case 'gt':
                    $conditions[] = [$options[0], '>', $value];
                    break;
                case 'lt':
                    $conditions[] = [$options[0], '<', $value];
                    break;
                case 'gte':
                    $conditions[] = [$options[0], '>=', $value];
                    break;
                case 'lte':
                    $conditions[] = [$options[0], '<=', $value];
                    break;
                default:
                    $conditions[] = [$options[0], '=', $value];
            }

        }

        return $conditions;
    }
