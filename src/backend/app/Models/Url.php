<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $original_url
 * @property string $short_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $custom_alias
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property int $clicks
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereCustomAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Url withoutTrashed()
 * @mixin \Eloquent
 */
class Url extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
