<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Item extends Model
{
    use Sortable;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'status', 'image'];

    public $sortable = ['id', 'category_id', 'name', 'description', 'price', 'deleted', 'created_at', 'updated_at', 'status'];

    public function activeSortable($query, $direction)
    {
        $direction = $direction == 'asc' ? 'desc' : 'asc';
        return $query->orderBy('status', $direction)
            ->select('categories.*');
    }
}
