<?php

namespace App\Http\Controllers;

use App\Models\Ajax;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Ajax::all();
        return view('ajaxs.index', compact('products'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Ajax::create($request->all());
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Ajax::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $product = Ajax::find($id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $product = Ajax::find($id);
        $product->delete();
        return response()->json($product);
        // Ajax::destroy($id);
        // return response()->json(['success' => 'Product deleted successfully.']);
    }
}
