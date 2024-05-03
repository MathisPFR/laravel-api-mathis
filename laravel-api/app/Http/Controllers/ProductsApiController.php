<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductsResource;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        
        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $products = new Product;
        $products->title = $request->title;
        $products->description = $request->description;
        $products->price = $request->price;
        $products->stock = $request->stock;
        $products->image = $request->image;
        $products->save();


        $this->storeImage($products);

        $category = json_decode($request->categories);
        $request->merge(["categories" => $category]);

        $products->categories()->attach($request->categories);

        


        return "effectuer avec succés";
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $products = Product::find($id);
        $titleCat = Product::with("categories")->find($id);

$categoryTitles = $titleCat->categories->pluck('title');



        
        return response()->json([
            "products" => $products,
            "category" => $categoryTitles,
        ]);

    }

   

    
    

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'sometimes|image|max:5000',
        ]);
    
        $products = Product::find($id);
        $products->update($request->all());

        $category = json_decode($request->categories);
        $request->merge(["categories" => $category]);

        $products->categories()->sync($request->categories);

        $this->storeImage($products);

        return $products;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $products = Product::find($id);
        $products->delete();
        return "c'est supprmimer bouffon";
        
   
    }





    private function storeImage(Product $products)
    {
        if(request('image')) {
            $res = request('image')->store('avatars', 'public');
            $products->update([
                'image' => $res
            ]);
            // dump($post);
            // dd($res);
        }
    }
}
