<?php

namespace App\Models\Attribute;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = "attributes";
    protected $primaryKey = 'attributes_id';
    protected $guarded = [];
}