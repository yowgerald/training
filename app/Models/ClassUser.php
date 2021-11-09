<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassUser extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'class_id',
    ];

    public function class()
    {
        return $this->belongsTo('App\Models\MClass');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
