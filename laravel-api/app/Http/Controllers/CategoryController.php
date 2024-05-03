<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $category = new Category;
        $category->title = $request->title;
        $category->save();

        return "effectuer avec succés";
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        // $category= Category::find($id);
        $category = Category::with("products")->find($id);

        $productsShow = $category->products->pluck('title');

        return response()->json([
            // "category" => $category,
            "category" => $category,
        ]);

        // return $category;

    }

   

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'title' => 'required|max:255',
        ]);
    
        $category = Category::find($id);
        $category->update($request->all());
        return $category;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return "c'est supprmimer ahaha trop bien !";
        
   
    }
}

