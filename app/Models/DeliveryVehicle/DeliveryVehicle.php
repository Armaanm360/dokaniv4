<?php

namespace App\Models\DeliveryVehicle;

use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{
    protected $table = "delivery_vehicles";
    protected $primaryKey = 'delivery_vehicles_id';
    protected $guarded = [];
}