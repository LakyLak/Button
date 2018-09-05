<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Schema;
use App\Services\AdminGridSettingsService;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'items';

        $service = new AdminGridSettingsService($table);

        $data = $service->getData($table);

        $data['filter']['filter_data'] = $request->except('page', 'sort', 'order');

        $conditions = filter_conditions($data['filter']['filter_data']);
        if ($data['pagination']['active']) {
            $data['pagination']['current_page'] = $request->page;
            $data['pagination']['total'] = Item::where($conditions)->count();
            $items = Item::where($conditions)->sortable()->paginate($data['pagination']['per_page']);
        } else {
            $items = Item::where($conditions)->sortable()->get();
        }

        // TODO refactor required for dynamical relations
        $data['filter']['select_items'] = Item::get();

        return view('admin.items.index', compact(['items', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
