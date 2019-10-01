<?php

namespace App\Http\Controllers;

use App\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $grades = Grade::paginate(10);
        return view('grade.index')->with('grades', $grades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('grade.form')->with('grade', new Grade());
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
     * @param int $grade_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param Grade $grade
     */
    public function show($grade_id)
    {
        $grade = Grade::findOrFail($grade_id)->with('lessons')->first();
        $starts_at = strtotime($grade->lessons->min('starts_at'));
        $ends_at = strtotime($grade->lessons->max('ends_at'));
        $duration = $ends_at - $starts_at;
//        $periods = $grade->lessons()->select(['starts_at', 'ends_at'])->orderBy('starts_at')->get();
        return view('grade.show')
            ->with('grade', $grade)
            ->with('schedule', compact('starts_at', 'ends_at', 'duration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        //
    }
}
