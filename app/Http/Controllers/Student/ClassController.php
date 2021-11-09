<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MClass;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = MClass::select(
                'classes.*',
                'class_users.id as class_user_id',
                'class_periods.id as class_period_id',
                'class_periods.period_start',
                'class_periods.period_end'
            )
            ->join('class_users', 'class_users.class_id', '=', 'classes.id')
            ->join('class_periods', 'class_periods.class_id', 'classes.id')
            ->where('class_users.user_id', auth()->user()->id)
            ->orderBy('class_periods.id')
            ->get();

        return view('student.class.list', compact('classes'));
    }
}
