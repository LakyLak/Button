<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;

    protected $fillable = ['name', 'description', 'status', 'image'];

    public $sortable = ['id', 'name', 'description', 'created_at', 'updated_at', 'status'];

    public function activeSortable($query, $direction)
    {
        $direction = $direction == 'asc' ? 'desc' : 'asc';
        return $query->orderBy('status', $direction)
            ->select('categories.*');
    }
}
