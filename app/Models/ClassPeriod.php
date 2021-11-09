<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassPeriod extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'period_start',
        'period_end',
        'class_id',
    ];

    public function class()
    {
        return $this->belongsTo('App\Models\MClass');
    }
}
