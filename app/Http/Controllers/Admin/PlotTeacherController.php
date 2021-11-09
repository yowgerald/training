<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassUserRequest;
use App\Models\ClassPeriod;
use App\Models\ClassUser;
use App\Repository\TeacherRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Helper;

class PlotTeacherController extends Controller
{
    private $userRepository;
    private $teacherRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TeacherRepositoryInterface $teacherRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teacherCriteria = [];

        $selectedTeacher = $this->userRepository
            ->getTeachers()
            ->where(function ($query) use ($request) {
                $teacherId = $request->get('user_id');
                if (!empty($teacherId)) {
                    $query->where('users.id', $teacherId);
                }
            })
            ->first();

        $teacherCriteria['id'] = $selectedTeacher->id;

        $period = Helper::normalizePeriodData($request->period);
        $teacherCriteria['period_start'] = $period['period_start'];
        $teacherCriteria['period_end'] = $period['period_end'];

        $teachers = $this->userRepository->getTeachers()->get();

        $classes = $this->teacherRepository
            ->getNotInTeacherClasses($teacherCriteria)
            ->get();

        $teacherClasses = $this->teacherRepository
            ->getTeacherClasses($teacherCriteria)
            ->paginate(5);

        return view('admin.plot.teacher',
            compact('teachers',
                'teacherClasses',
                'classes',
                'selectedTeacher'
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
        $teacherCriteria['id'] = $request->user_id;

        $periodData = Helper::normalizePeriodData($request->period);
        $teacherCriteria['period_start'] = $periodData['period_start'];
        $teacherCriteria['period_end'] = $periodData['period_end'];
        $classesCount = $this->teacherRepository
            ->getTeacherClasses($teacherCriteria)
            ->count();

        if ($classesCount > 0) {
            Session::flash('error', 'Cannot add class in selected period!');
            return redirect()->back();
        }

        ClassPeriod::firstOrCreate([
            'period_start' => $periodData['period_start'],
            'period_end' => $periodData['period_end'],
            'class_id' => $request->class_id
        ]);

        ClassUser::firstOrCreate([
            'user_id' => $request->user_id,
            'class_id' => $request->class_id,
        ]);

        Session::flash('message', 'Class added to teacher classes successfully.');

        return redirect()->route('plot_teacher.index');
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
        $period = ClassPeriod::find($id);

        if (!empty($period)) {
            $period->delete();
            Session::flash('message', 'Class removed from teacher classes successfully.');

            return redirect()->route('plot_teacher.index');
        }
    }
}
