<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_services');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeWithBusyStatus($query, $startTime, $endTime)
    {
        return $query->withExists(['appointments as is_busy' => function ($q) use ($startTime, $endTime) {
            $q->where('status', 'confirmed')
                ->where('start_time', '<', $endTime)
                ->where('end_time', '>', $startTime);
        }]);
    }

    public function scopeSearch($query, $keyword)
    {
        $keyword = trim($keyword);

        if (!filled($keyword)) {
            return $query;
        }

        // gom nhóm các đk OR trong một sub-query để tránh lỗi logic SQL
        return $query->where(function ($subQuery) use ($keyword) {
            $subQuery->where('name', 'like', "%{$keyword}%")
                ->orWhere('phone', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                // Dùng Arrow Function 
                ->orWhereHas('services', fn($serviceQuery) => $serviceQuery->where('name', 'like', "%{$keyword}%"));
        });
    }
}
