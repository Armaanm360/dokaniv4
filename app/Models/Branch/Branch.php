<?php

namespace App\Models\Branch;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $table = "branches";
    protected $primaryKey = 'branch_id';
    protected $guarded = [];


    public static function branchName($id)
    {
        $data = Branch::where('branch_id',$id)->select('branch_name')->first();
        return $data;
    }
}
