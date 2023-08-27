<?php

namespace App\Models\CompanyInfo;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $table = "company_infos";
    protected $primaryKey = 'company_info_id';
    protected $guarded = [];
}