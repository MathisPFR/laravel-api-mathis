<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *      title="Product",
 *      description="Product model",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="The unique identifier for the product",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          description="The title of the product",
 *          example="Smartphone"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="The description of the product",
 *          example="A high-quality smartphone with advanced features"
 *      ),
 *      @OA\Property(
 *          property="price",
 *          type="number",
 *          format="float",
 *          description="The price of the product",
 *          example=499.99
 *      ),
 *      @OA\Property(
 *          property="stock",
 *          type="integer",
 *          description="The available stock quantity of the product",
 *          example=100
 *      ),
 *      @OA\Property(
 *          property="image",
 *          type="string",
 *          format="url",
 *          description="The URL of the product image",
 *          example="http://example.com/image.jpg"
 *      )
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}



