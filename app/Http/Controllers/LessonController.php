<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('grade.index')->with('grades', Grade::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('grade.form')->with('grade', new Grade());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
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
        $grade = Grade::with(['lessons.teacher', 'lessons.subject'])->findOrFail($grade_id);
        $periods = $grade->lessons()->select(['starts_at', 'ends_at'])->orderBy('starts_at')->toArray();
        return view('grade.show')
            ->with('grade', $grade)
            ->with('periods', $periods);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lesson $schedule
     * @return Response
     * @internal param Grade $grade
     */
    public function edit(Lesson $schedule)
    {
        return view('schedule.form')
            ->with('schedule', $schedule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return Response
     */
    public function update(Request $request, Grade $grade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lesson $schedule
     * @return Response
     */
    public function destroy(Lesson $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Lesson successfully deleted!');
    }
}
