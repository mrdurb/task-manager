<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model 
{
    protected $fillable = [
        'title', 'employee', 'status'
    ];

    public static function employees() {
        return Employee::all();
    }
}
