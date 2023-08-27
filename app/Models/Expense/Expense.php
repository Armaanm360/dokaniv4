<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = "expenses";
    protected $primaryKey = 'expense_id';
    protected $guarded = [];
}
