<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MClass extends Model
{
    protected $table = 'classes';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function periods(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\ClassPeriod', 'class_id', 'id');
    }
}
