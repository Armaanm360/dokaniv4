<?php

namespace App\Models\ExpenseHead;

use Illuminate\Database\Eloquent\Model;

class ExpenseHead extends Model
{

    protected $table = "expense_heads";
    protected $primaryKey = 'expensehead_id';
    protected $guarded = [];
}
