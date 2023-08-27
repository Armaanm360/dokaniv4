<?php

namespace App\Models\Terms;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $table = "terms";
    protected $primaryKey = 'terms_id';
    protected $guarded = [];
}