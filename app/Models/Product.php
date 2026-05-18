<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    public static function imageUrl(?string $gallery): string
    {
        $gallery = trim((string) $gallery);

        if ($gallery === '') {
            return '';
        }

        if (Str::startsWith($gallery, ['http://', 'https://'])) {
            return $gallery;
        }

        if (Str::startsWith($gallery, '//')) {
            return 'https:'.$gallery;
        }

        return asset(ltrim($gallery, '/'));
    }

    public function getGalleryUrlAttribute(): string
    {
        return self::imageUrl($this->gallery);
    }
}
