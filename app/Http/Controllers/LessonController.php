<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Http\Requests\LessonRequest;
use App\Lesson;
use App\Subject;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
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
     * @param LessonRequest $request
     * @return void
     */
    public function store(LessonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $lesson_id
     * @return View
     * @internal param Lesson $lesson
     */
    public function show($lesson_id)
    {
        $lesson = Grade::with(['lessons.teacher', 'lessons.subject'])->findOrFail($lesson_id);
        $periods = $lesson->lessons()->select(['starts_at', 'ends_at'])->orderBy('starts_at')->toArray();
        return view('grade.show')
            ->with('grade', $lesson)
            ->with('periods', $periods);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lesson $lesson
     * @return Response
     * @internal param Lesson $lesson
     */
    public function edit(Lesson $lesson)
    {
        return view('lesson.form')
            ->with('grades', Grade::query()->select(['id', 'name'])->get())
            ->with('subjects', Subject::query()->select(['id', 'name'])->get())
            ->with('teachers', User::query()->teachers()->select(['id', 'name', 'roles'])->get())
            ->with('lesson', $lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LessonRequest $request
     * @param Lesson $lesson
     * @return void
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->toArray());
        $gradeId = $request->get('grade_id', $lesson->grade_id);
        return redirect()->route('grades.show', $gradeId)->with('success', 'Lesson successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lesson $lesson
     * @return Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return back()->with('success', 'Lesson successfully deleted!');
    }
}
