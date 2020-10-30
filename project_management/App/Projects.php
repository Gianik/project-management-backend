<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Projects extends Model
{
    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'priority',
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Project_Todos', 'project_id');
    }
    public function budget()
    {
        return $this->hasMany('App\Budgets', 'project_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
