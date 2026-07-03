<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'logo', 'description'];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}