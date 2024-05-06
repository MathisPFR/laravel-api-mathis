<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;



/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Operations related to categories"
 * )
 */
class CategoryController extends Controller
{

    /**
 * Retrieve all categories.
 *
 * @return \Illuminate\Http\JsonResponse
 * 
 * @OA\Get(
 *     path="/categories",
 *     summary="Retrieve all categories",
 *     tags={"Categories"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Category")
 *         )
 *     )
 * )
 */
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }


    /**
     * Store a newly created category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     * 
     * @OA\Post(
     *      path="/categories",
     *      operationId="storeCategory",
     *      tags={"Categories"},
     *      summary="Store a new category",
     *      description="Creates a new category.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title"},
     *              @OA\Property(property="title", type="string", example="Electronics")
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
        $category = new Category;
        $category->title = $request->title;
        $category->save();

        return "Operation réussie";
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Get(
     *      path="/categories/{id}",
     *      operationId="showCategory",
     *      tags={"Categories"},
     *      summary="Display a category",
     *      description="Returns the specified category.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category ID",
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
     *              ref="#/components/schemas/Category"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Category not found"
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return new CategoryResource($category);
    }

    /**
     * Update the specified category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * 
     * @OA\Put(
     *      path="/categories/{id}",
     *      operationId="updateCategory",
     *      tags={"Categories"},
     *      summary="Update a category",
     *      description="Updates the specified category.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title"},
     *              @OA\Property(property="title", type="string", example="Electronics")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Category"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Category not found"
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->only('title'));
        return new CategoryResource($category);
    }

    /**
     * Remove the specified category.
     *
     * @param  int  $id
     * @return string
     * 
     * @OA\Delete(
     *      path="/categories/{id}",
     *      operationId="deleteCategory",
     *      tags={"Categories"},
     *      summary="Delete a category",
     *      description="Deletes the specified category.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category ID",
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
     *          description="Category not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Category not found"
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return "Operation réussie";
    }
}

