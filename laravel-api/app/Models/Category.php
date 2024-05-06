<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *      title="Category",
 *      description="Category model",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="The unique identifier for the category",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          description="The title of the category",
 *          example="Electronics"
 *      )
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}

