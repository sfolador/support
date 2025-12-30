<?php

namespace Sfolador\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sfolador\Support\Database\Factories\SupportRequestFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $support_type
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'support_type',
        'content',
    ];

    protected static function newFactory(): SupportRequestFactory
    {
        return SupportRequestFactory::new();
    }
}
