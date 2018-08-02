<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function filter(Request $request)
    {
        $data = $request->all();
        $cond = [];
        $conditions = [];
        
        foreach ($data as $field => $value) {
            if (empty($value) || $field == '_token') {continue;}
            // echo '<pre>'; print_r($field);
            $options = explode('_', $field);

            // echo '<pre>'; print_r($options); die;

            switch ($options[1]) {
                case 'like':
                    $cond['like'] = [$options[0] => $value];
                    $conditions[] = [$options[0], 'LIKE', '%'.$value.'%'];
                    break;
                case 'gt':
                    $cond['gt'] = [$options[0] => $value];
                    $conditions[] = [$options[0], '>', $value];
                    break;
                    case 'lt':
                    $cond['lt'] = [$options[0] => $value];
                    $conditions[] = [$options[0], '<', $value];
                    break;
                    case 'gte':
                    $cond['gte'] = [$options[0] => $value];
                    $conditions[] = [$options[0], '>=', $value];
                    break;
                    case 'lte':
                    $cond['lte'] = [$options[0] => $value];
                    $conditions[] = [$options[0], '<=', $value];
                    break;
                    default:
                    $cond['eq'] = [$options[0] => $value];
                    $conditions[] = [$options[0], '=', $value];
            }

        }

        
        echo '<pre>'; print_r($conditions); die;


        
        $categories = Category::where($conditions)->get();

        return view('admin.categories.index', compact('categories'));
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
