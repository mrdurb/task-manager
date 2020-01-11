<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model 
{
    protected $fillable = [
        'title', 'employee', 'status', 'employee_id'
    ];

    public static function employees() {
        return Employee::all();
    }

    public function employee() {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
