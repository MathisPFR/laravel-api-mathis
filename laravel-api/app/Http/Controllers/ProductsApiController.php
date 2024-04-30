<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductsResource;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $products = new Products;
        $products->title = $request->title;
        $products->description = $request->description;
        $products->price = $request->price;
        $products->stock = $request->stock;
        $products->save();

        return "effectuer avec succés";
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $products= Products::find($id);
        return $products;

    }

   

    
    //comme le blog fdp !

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
    
        $products = Products::find($id);
        $products->update($request->all());
        return $products;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $products = Products::find($id);
        $products->delete();
        return "c'est supprmimer bouffon";
        
   
    }
}
