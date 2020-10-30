<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budgets extends Model
{
    protected $fillable = [
        'project_id',
        'remaining_budget',
        'current_budget',
        'original_budget'


    ];
    public function project()
    {
        return $this->belongsTo('App\Projects', 'project_id');
    }
    public function expenses()
    {
        return $this->hasMany('App\Expenses', 'budget_id');
    }
}
