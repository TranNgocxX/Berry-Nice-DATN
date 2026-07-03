<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'short_description',
        'long_description',
        'duration',
        'image',
        'max_slot',
        'price'
    ];

    protected $casts = [
        'duration' => 'integer',
        'max_slot' => 'integer',
        'price' => 'decimal:2',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_services');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilter($query, array $filters)
    {
        $keyword = trim($filters['keyword'] ?? '');
        $categoryId = $filters['category_id'] ?? null;

        return $query->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($sub) use ($keyword) {
                $sub->where('name', 'like', "%{$keyword}%")
                    ->orWhere('short_description', 'like', "%{$keyword}%")
                    ->orWhereHas('category', fn($cat) => $cat->where('name', 'like', "%{$keyword}%"));
            });
        })
        ->when($categoryId, fn($q) => $q->where('category_id', $categoryId));
    }
}
