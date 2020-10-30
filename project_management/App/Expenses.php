<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = [
        'name',
        'budget_id',
        'expenses_price',
        'user_id',
        'expenses_date'
    ];
    public function budget()
    {
        return $this->belongsTo('App\Budgets', 'budget_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
