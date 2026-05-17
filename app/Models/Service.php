<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
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

    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('short_description', 'like', "%{$keyword}%")
                ->orWhere('long_description', 'like', "%{$keyword}%")
                ->orWhereHas('category', function ($catQuery) use ($keyword) {
                    $catQuery->where('name', 'like', "%{$keyword}%");
                });
        });
    }
}
