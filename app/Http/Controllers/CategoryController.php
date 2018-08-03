<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request) 
    {
        $filter_fields = [
            [
                'form_name' => 'name_like',
                'label' => 'Name',
                'type' => 'text'
            ],
            [
                'form_name' => 'description_like',
                'label' => 'Description',
                'type' => 'text'
            ],
            [
                'form_name' => 'created_at_gte',
                'label' => 'Created From',
                'type' => 'datepicker'
            ],
            [
                'form_name' => 'created_at_lte',
                'label' => 'Created To',
                'type' => 'datepicker'
            ]
        ];
        // $simple_pagination = true;
        $per_page = 3;

        // echo '<pre>'; print_r($request->all()); die;    

        $data['pagination']['per_page'] = $per_page;
        $data['pagination']['current_page'] = $request->page;
        $filter_data = [];
        $total = Category::count();
        $categories = Category::paginate($per_page);
        
        if ($request->isMethod('post')) {
            $filter_data = $request->all();
            
            $data['filter']['filter_data'] = $filter_data;
            
            $conditions = filter_conditions($filter_data);
            $total = Category::where($conditions)->count();
            $categories = Category::where($conditions)->paginate($per_page);
        }
        $data['pagination']['total'] = $total;
        
        return view('admin.categories.index', compact(['categories', 'filter_data', 'filter_fields', 'data']));
    }

    public function change_status($id, $status)
    {
        $category = Category::find($id);
        if ($status != $category->status) {
            $category->status = $status;
            $category->save();

            return redirect()->back();
        }
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|max:24|unique:categories',
                // file upload validation
            ]);

            $data = $request->all();
            // echo '<pre>'; print_r($data); die;

            $category = new Category;
            $category->name = $data['name'];
            $category->status = !empty($data['status']) && $data['status'] == 'on' ? 1 : 0;
            $category->image = $data['image'];
            $category->description = $data['description'];

            $category->save();

            return redirect('/admin/categories')->with('flash_success_message', "Category $category->name has been created");
        } 
        
        return view('admin.categories.add');
    }

    // TODO edit action & view
    public function edit(Request $request)
    {
        $category = Category::find($request->id);
        if ($request->isMethod('post')) {
            
            $this->validate($request, [
                'name' => 'required|max:24|unique:categories',
                // file upload validation
            ]);

            $data = $request->all();

            $category->name = $data['name'];
            $category->status = !empty($data['status']) && $data['status'] == 'on' ? 1 : 0;
            $category->image = $data['image'];
            $category->description = $data['description'];

            $category->save();

            return redirect('/admin/categories')->with('flash_success_message', "Category $category->name has been updated");
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function delete($id) 
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();

            return redirect()->back()->with('flash_success_message', "Category $category->name has been deleted");
        }

    }
}
