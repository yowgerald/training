<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TeachersImport;
use App\Models\MClass;
use App\Models\User;
use App\Models\TeacherDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\Http\Requests\UserRequest;
use App\Repository\UserRepositoryInterface;

class TeacherController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teachers = $this->userRepository
            ->getTeachers($request->all())
            ->paginate(5);

        $classes = MClass::get();

        return view('admin.teacher.list', compact('teachers', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $savedUser = User::register($request);

        if (!empty($savedUser)) {
            $teacherDetail = new TeacherDetail;
            $teacherDetail->title = $request->title;
            $teacherDetail->user_id = $savedUser->id;
            $teacherDetail->save();

            if (!empty($teacherDetail)) {
                Session::flash('message', 'Record created successfully.');

                return redirect()->route('teacher.index');
            }
        }
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
        $teacher = User::find($id);

        return view('admin.teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $isSuccess = User::find($id)->update($request->all());

        if ($isSuccess) {
            TeacherDetail::where('user_id', $id)->update([
                'title' => $request->title
            ]);

            Session::flash('message', 'Record updated successfully.');

            return redirect()->route('teacher.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isSuccess = TeacherDetail::where('user_id', $id)->delete();

        if ($isSuccess) {
            User::find($id)->delete();

            Session::flash('message', 'Record deleted successfully.');

            return redirect()->route('teacher.index');
        }
    }

    public function import()
    {
        Excel::import(new TeachersImport, request()->file('file'));
        Session::flash('message', 'Record imported successfully.');

        return back();
    }
}
