<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *      title="User",
 *      description="User model",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="The unique identifier for the user",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="The name of the user",
 *          example="John Doe"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          description="The email address of the user",
 *          example="john@example.com"
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          description="The password of the user",
 *          example="secret"
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          type="string",
 *          format="date-time",
 *          description="The date and time when the email address was verified",
 *          example="2022-05-01T12:00:00Z"
 *      ),
 *      @OA\Property(
 *          property="profile_photo_url",
 *          type="string",
 *          format="url",
 *          description="The URL of the user's profile photo",
 *          example="http://example.com/profile.jpg"
 *      )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
