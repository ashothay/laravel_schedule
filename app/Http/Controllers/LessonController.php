<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Http\Requests\LessonRequest;
use App\Lesson;
use App\Subject;
use App\User;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Lesson::class);
        return view('lesson.form')
            ->with('grades', Grade::query()->select(['id', 'name'])->get())
            ->with('subjects', Subject::query()->select(['id', 'name'])->get())
            ->with('teachers', User::query()->teachers()->select(['id', 'name', 'roles'])->get())
            ->with('lesson', new Lesson());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LessonRequest $request
     * @return void
     */
    public function store(LessonRequest $request)
    {
        Lesson::create($request->toArray());
        $gradeId = $request->get('grade_id');
        return redirect()->route('grades.show', $gradeId)->with('success', 'Lesson successfully updated!');
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
        $this->authorize('update', $lesson);
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
        $this->authorize('update', $lesson);
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
        $this->authorize('delete', $lesson);
        $lesson->delete();

        return back()->with('success', 'Lesson successfully deleted!');
    }
}
