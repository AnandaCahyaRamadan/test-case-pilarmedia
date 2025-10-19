<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';

    protected $fillable = [
        'order_number',
        'origin_city_id',
        'origin_city_name',
        'destination_city_id',
        'destination_city_name',
        'cost',
        'estimate',
        'driver_name',
        'vehicle_number',
        'vehicle_type',
        'contact_number',
        'status',
    ];
}
