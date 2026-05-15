<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetail extends Model
{
    protected $table = 'appointment_details';

    protected $fillable = [
        'appointment_id',
        'customer_name',
        'email',
        'phone',
        'address',
        'health_status',
        'notes'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
