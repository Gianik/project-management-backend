<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_Todos extends Model
{
    protected $fillable = [
        'title',
        'content',
        'completion_date',
        'status',
        'project_id',
        'user_id',
        'due_date'
    ];
    public function project()
    {
        return $this->belongsTo('App\Projects', 'project_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
