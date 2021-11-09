<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    protected $table = 'teacher_details';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
    ];
}
