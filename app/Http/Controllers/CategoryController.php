<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            echo '<pre>'; print_r($data); die;

            $category = new Category;
            $category->name = $data['name'];
            $category->status = $data['status'];
            $category->image = $data['image'];
            $category->description = $data['description'];

            $category->save();
        }
        
        // $this->validate($request, [
        //     'name' => 'required|max:24|unique:item_categories',
        //     // file upload validation
        // ]);

         return view('admin.categories.add_category');
    }
}
