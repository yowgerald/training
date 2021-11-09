<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassPeriod;
use App\Models\StudentAttendance;
use App\Repository\ClassUserRepositoryInterface;
use App\Repository\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    private $classUserRepository;
    private $teacherRepository;

    public function __construct(
        ClassUserRepositoryInterface $classUserRepository,
        TeacherRepositoryInterface $teacherRepository
    )
    {
        $this->classUserRepository = $classUserRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criteria['id'] = auth()->user()->id;

        $classes = $this->teacherRepository
            ->getTeacherClassesWithPeriods($criteria)
            ->get();

        return view('teacher.attendance.class_list', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showStudents($id)
    {
        $classPeriod = ClassPeriod::find($id);
        $criteria['id'] = $classPeriod->class_id;
        $criteria['period_start'] = $classPeriod->period_start;
        $criteria['period_end'] = $classPeriod->period_end;

        $students = $this->classUserRepository
            ->getClassStudents($criteria)
            ->paginate(5);

        return view(
            'teacher.attendance.student_list',
            compact('classPeriod','students')
        );
    }

    public function take(Request $request)
    {
        $attendanceRecords = $request->except('_token', 'class_period_id'); //get only is_present data

        foreach ($attendanceRecords as $key => $is_present) {
            $classUserId = explode('_', $key)[2];
            StudentAttendance::updateOrCreate(
                ['class_user_id' => $classUserId],
                ['is_present' => $is_present],
                ['class_period_id' => $request->class_period_id]
            );
        }

        Session::flash('message', 'Attendance updated successfully.');

        return back();
    }
}
