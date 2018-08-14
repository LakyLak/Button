<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Schema;
use Log;
// use App\Http\Traits\SettingsTrait;
use App\Services\AdminGridSettingsService;

class CategoryController extends Controller
{
    // use SettingsTrait;

    public function index(Request $request) 
    {       
        $table = 'categories';

        $service = new AdminGridSettingsService();
        
        $data = $service->getData($table);
        // Log::info("data Categories controller\n" . print_r($data, true));

        $data['pagination']['current_page'] = $request->page;
        $data['filter']['filter_data'] = $request->except('page', 'sort', 'order');

        
        $conditions = filter_conditions($data['filter']['filter_data']);
        $data['pagination']['total'] = Category::where($conditions)->count();
        $items = Category::where($conditions)->sortable()->paginate($data['pagination']['per_page']);

        return view('admin.categories.index', compact(['items', 'data']));
    }

    public function activate($id, $status)
    {
        $category = Category::find($id);
        if ($status != $category->status) {
            $category->status = $status;
            $category->save();

        }
        return redirect()->back();
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
