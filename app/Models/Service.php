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
}
