<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MClass;
use App\Http\Requests\ClassRequest;
use Session;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = MClass::get();

        return view('admin.class.list', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.class.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequest $request)
    {
        $class = new MClass;
        $class = $class->fill($request->all());
        $class->save();

        if (!empty($class)) {
            Session::flash('message', 'Record created successfully.');

            return redirect()->route('class.index');
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
        $class = MClass::find($id);

        return view('admin.class.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRequest $request, $id)
    {
        $isSuccess = MClass::find($id)->update($request->all());

        if ($isSuccess) {
            Session::flash('message', 'Record updated successfully.');

            return redirect()->route('class.index');
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
        //TODO: what if there's a student/teacher using the class?
        $isSuccess = MClass::find($id)->delete();

        if ($isSuccess) {
            Session::flash('message', 'Record deleted successfully.');

            return redirect()->route('class.index');
        }
    }
}
