<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Datatables;

class ProductController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
    if(request()->ajax()) {
        return datatables()->of(Product::select('*'))
        ->addColumn('action', 'products.action')
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

    return view('products.index');
}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    return view('products.create');
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'quantity' => 'required',
        'category' => 'required',
    ]);

    $product = new Product;

    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->category = $request->category;

    $product->save();

    return redirect()->route('products.index')
    ->with('success','Product has been created successfully.');
}

/**
* Display the specified resource.
*
* @param  \App\product  $product
* @return \Illuminate\Http\Response
*/
public function show(Product $product)
{
    return view('products.show',compact('product'));
} 
/**
* Show the form for editing the specified resource.
*
* @param  \App\Product  $product
* @return \Illuminate\Http\Response
*/
public function edit(Product $product)
{
    return view('products.edit',compact('product'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  \App\product  $product
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'quantity' => 'required',
        'category' => 'required',
    ]);

    $product = Product::find($id);

    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->category = $request->category;
 
    $product->save();

    return redirect()->route('products.index')
    ->with('success','Product has been updated successfully');
}

/**
* Remove the specified resource from storage.
*
* @param  \App\Product  $product
* @return \Illuminate\Http\Response
*/
public function destroy(Request $request)
{
    $com = Product::where('id',$request->id)->delete();
    
    return Response()->json($com);
}
}
