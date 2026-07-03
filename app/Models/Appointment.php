<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'user_id',
        'service_id',
        'employee_id',
        'start_time',
        'end_time',
        'status',
        'price',
        'total_price',
        'payment_method',
        'payment_status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
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
        })
            ->when($filters['date'] ?? null, function ($q, $date) {
                $q->whereDate('start_time', $date);
            })
            ->when($filters['employee_id'] ?? null, function ($q, $employeeId) {
                $q->where('employee_id', $employeeId);
            })
            ->when($filters['service_id'] ?? null, function ($q, $serviceId) {
                $q->where('service_id', $serviceId);
            })
            // Tìm theo tên KH
            ->when($filters['customer_name'] ?? null, function ($q, $customerName) {
                $q->whereHas('user', fn($innerQ) => $innerQ->where('name', 'like', "%{$customerName}%"));
            })
            // Tìm kiếm từ khóa theo tên dịch vụ 
            ->when($filters['keyword'] ?? null, function ($q, $keyword) {
                $q->whereHas('service', fn($innerQ) => $innerQ->where('name', 'like', "%{$keyword}%"));
            })
            // sx: mới nhất (desc) / cũ nhất (asc)
            ->when($filters['sort'] ?? null, function ($q, $sort) {
                $direction = $sort === 'oldest' ? 'asc' : 'desc';
                $q->orderBy('created_at', $direction);
            }, function ($q) {
                // Nếu 0 chọn bộ lọc sắp xếp, mặc định xếp mới nhất
                $q->latest();
            });
    }
}
