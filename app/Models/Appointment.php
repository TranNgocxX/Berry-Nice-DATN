<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'user_id',
        'service_id',
        'employee_id',
        'start_time',
        'end_time',
        'status',
        'payment_method',
        'payment_status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function appointmentDetail()
    {
        return $this->hasOne(AppointmentDetail::class);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        })->when($filters['date'] ?? null, function ($q, $date) {
            $q->whereDate('start_time', $date);
        })->when($filters['keyword'] ?? null, function ($q, $keyword) {
            $q->whereHas('service', function ($innerQ) use ($keyword) {
                $innerQ->where('name', 'like', "%{$keyword}%");
            });
        });
    }
}
