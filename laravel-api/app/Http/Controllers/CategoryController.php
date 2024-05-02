<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
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
        
        $category= Category::find($id);
        return $category;

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

