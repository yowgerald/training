<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\MClass;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserRequest;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
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
        $students = $this->userRepository
            ->getStudents($request->all())
            ->paginate(5);
        $teachers = $this->userRepository
            ->getTeachers()
            ->get();
        $classes = MClass::get();

        return view('admin.student.list', compact('students', 'teachers', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $savedUser = User::register($request);

        if (!empty($savedUser)) {
            Session::flash('message', 'Record created successfully.');

            return redirect()->back();
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
        $student = User::find($id);

        return view('admin.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $isSuccess = User::find($id)->update($request->all());

        if ($isSuccess) {
            Session::flash('message', 'Record updated successfully.');

            return redirect()->route('student.index');
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
        $isSuccess = User::find($id)->delete();

        if ($isSuccess) {
            Session::flash('message', 'Record deleted successfully.');

            return redirect()->route('student.index');
        }
    }

    public function import()
    {
        Excel::import(new StudentsImport, request()->file('file'));
        Session::flash('message', 'Record imported successfully.');

        return back();
    }
}
