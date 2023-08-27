<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = "staff";
    protected $primaryKey = 'staff_id';
    protected $guarded = [];
}
