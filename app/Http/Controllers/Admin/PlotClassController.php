<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassUserRequest;
use App\Models\ClassPeriod;
use App\Models\ClassUser;
use App\Models\MClass;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use App\Repository\ClassUserRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Helper;

class PlotClassController extends Controller
{
    private $classUserRepository;

    public function __construct(ClassUserRepositoryInterface $classUserRepository)
    {
        $this->classUserRepository = $classUserRepository;
    }

        /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classCriteria = [];
        $classes = MClass::get();

        $selectedClass = MClass::
            where(function ($query) use ($request) {
                $classId = $request->get('class_id');

                if (!empty($classId)) {
                    $query->where('id', $classId);
                }
            })
            ->first();

        $classCriteria['id'] = $selectedClass->id;

        $period = Helper::normalizePeriodData($request->period);
        $classCriteria['period_start'] = $period['period_start'];
        $classCriteria['period_end'] = $period['period_end'];

        $students = $this->classUserRepository
            ->getNotInClassStudents($classCriteria)
            ->get();

        $classStudents = $this->classUserRepository
                ->getClassStudents($classCriteria)
                ->paginate(5);

        return view('admin.plot.class',
            compact(
                'classes',
                'students',
                'classStudents',
                'selectedClass'
            )
        );
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
     * @param  \App\Http\Requests\ClassUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassUserRequest $request)
    {
        $periodData = Helper::normalizePeriodData($request->period);
        $period = ClassPeriod::firstOrCreate([
            'period_start' => $periodData['period_start'],
            'period_end' => $periodData['period_end'],
            'class_id' => $request->class_id
        ]);

        $classUser = ClassUser::firstOrCreate([
            'user_id' => $request->user_id,
            'class_id' => $request->class_id,
        ]);

        $attendance = new StudentAttendance;
        $attendance->class_user_id = $classUser->id;
        $attendance->class_period_id = $period->id;
        $attendance->save();

        Session::flash('message', 'Student added to class successfully.');

        return redirect()->route('plot_class.index');
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
        $attendance = StudentAttendance::find($id);

        if (!empty($attendance)) {
            $attendance->delete();
            Session::flash('message', 'Student removed from class successfully.');

            return redirect()->route('plot_class.index');
        }
    }
}
