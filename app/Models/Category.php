<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    // Accessor để lấy logo dựa trên tên danh mục
    public function getLogoAttribute()
    {
        $name = Str::lower($this->name);

        if (Str::contains($name, 'da mặt')) {
            return 'facial.png';
        } elseif (Str::contains($name, 'massage')) {
            return 'massage.png';
        } elseif (Str::contains($name, 'tóc')) {
            return 'hair.png';
        } elseif (Str::contains($name, 'tắm')) {
            return 'bath.png';
        } elseif (Str::contains($name, 'waxing')) {
            return 'waxing.png';
        } elseif (Str::contains($name, 'tẩy da')) {
            return 'scrub.png';
        }

        return 'default.png';
    }
}
