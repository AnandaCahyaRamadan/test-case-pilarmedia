<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobOrder;
use Illuminate\Support\Str;

class JobOrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'order_number'        => 'JO-'.Str::random(6),
                'origin_city_id'      => '501',
                'origin_city_name'    => 'Jakarta',
                'destination_city_id' => '114', 
                'destination_city_name'=> 'Bandung',
                'cost'                => 150000.00,
                'distance'            => 150.5,
                'estimate'            => '2 days',
                'driver_name'         => 'Budi Santoso',
                'vehicle_number'      => 'B 1234 XY',
                'vehicle_type'        => 'Truck',
                'contact_number'      => '081234567890',
                'status'              => 'waiting',
            ],
            [
                'order_number'        => 'JO-'.Str::random(6),
                'origin_city_id'      => '114',
                'origin_city_name'    => 'Bandung',
                'destination_city_id' => '501',
                'destination_city_name'=> 'Jakarta',
                'cost'                => 200000.00,
                'distance'            => 150.5,
                'estimate'            => '2 days',
                'driver_name'         => 'Andi Prasetyo',
                'vehicle_number'      => 'D 5678 AB',
                'vehicle_type'        => 'Pickup',
                'contact_number'      => '081298765432',
                'status'              => 'on_route',
            ],
        ];

        foreach ($orders as $order) {
            JobOrder::create($order);
        }
    }
}
