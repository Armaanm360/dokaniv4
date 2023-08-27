<?php

namespace App\Models\Attribute;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = "attribute_values";
    protected $primaryKey = 'attributes_value_id';
    protected $guarded = [];
}