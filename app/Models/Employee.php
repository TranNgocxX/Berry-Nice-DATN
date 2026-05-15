<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
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
}
