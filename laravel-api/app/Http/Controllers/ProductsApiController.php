<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductsResource;
use App\Models\Product;
use App\Models\Category;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Operations related to products"
 * )
 */
class ProductsApiController extends Controller
{
    /**
     * Retrieve all products.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * 
     * @OA\Get(
     *      path="/products",
     *      operationId="indexProducts",
     *      tags={"Products"},
     *      summary="Retrieve all products",
     *      description="Returns all products.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      )
     * )
     */
    public function index()
    {
        $products = Product::all();
        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     * 
     * @OA\Post(
     *      path="/products",
     *      operationId="storeProduct",
     *      tags={"Products"},
     *      summary="Store a new product",
     *      description="Creates a new product.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title", "description", "price", "stock", "image", "categories"},
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="price", type="number", format="float"),
     *              @OA\Property(property="stock", type="integer"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="categories", type="array", @OA\Items(type="integer"))
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Operation réussie"
     *          )
     *      )
     * )
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

       

        // $category = json_decode($request->categories);
        // $request->merge(["categories" => $category]);

        // $products->categories()->attach($request->categories);


        if ($request->has('categories')) {
            $categories = $request->categories;
    
            // Vérifiez si $categories est une chaîne JSON valide
            if (is_string($categories) && json_decode($categories) !== null) {
                $categories = json_decode($categories);   
            }  
                
            $products->categories()->attach($categories);
        }

        return "effectuer avec succés"; 
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Get(
     *      path="/products/{id}",
     *      operationId="showProduct",
     *      tags={"Products"},
     *      summary="Display a product",
     *      description="Returns the specified product.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="products", ref="#/components/schemas/Product"),
     *              @OA\Property(property="category", type="array", @OA\Items(type="string"))
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Product not found"
     *          )
     *      )
     * )
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

    /**
     * Update the specified product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Put(
     *      path="/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      summary="Update a product",
     *      description="Updates the specified product.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title", "description", "price", "stock", "image", "categories"},
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="price", type="number", format="float"),
     *              @OA\Property(property="stock", type="integer"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="categories", type="array", @OA\Items(type="integer"))
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Product"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Product not found"
     *          )
     *      )
     * )
     */
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
     * Remove the specified product.
     *
     * @param  int  $id
     * @return string
     * 
     * @OA\Delete(
     *      path="/products/{id}",
     *      operationId="deleteProduct",
     *      tags={"Products"},
     *      summary="Delete a product",
     *      description="Deletes the specified product.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Operation réussie"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Product not found"
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        $products = Product::find($id);
        $products->delete();
        return "c'est supprmimer";
    }

    /**
     * Store the image for the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    private function storeImage(Product $products)
    {
        if(request('image')) {
            $res = request('image')->store('avatars', 'public');
            $products->update([
                'image' => $res
            ]);
            
        }
    }
}
