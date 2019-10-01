<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Http\Requests\LessonRequest;
use App\Lesson;
use App\Subject;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Lesson::class);

        $grades = Grade::query()->select(['id', 'name'])->get();
        $subjects = Subject::query()->select(['id', 'name'])->get();
        $teachers = User::query()->teachers()->select(['id', 'name', 'roles'])->get();

        if (request()->expectsJson()) {
            return response()->json(compact('grades', 'subjects', 'teachers'));
        }
        return view('lesson.form')
            ->with('grades', $grades)
            ->with('subjects', $subjects)
            ->with('teachers', $teachers)
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
     * @throws AuthorizationException
     * @internal param Lesson $lesson
     */
    public function edit(Lesson $lesson)
    {
        $this->authorize('update', $lesson);

        $grades = Grade::query()->select(['id', 'name'])->get();
        $subjects = Subject::query()->select(['id', 'name'])->get();
        $teachers = User::query()->teachers()->select(['id', 'name', 'roles'])->get();

        if (request()->expectsJson()) {
            return response()->json(compact('grades', 'subjects', 'teachers', 'lesson'));
        }
        return view('lesson.form')
            ->with('grades', $grades)
            ->with('subjects', $subjects)
            ->with('teachers', $teachers)
            ->with('lesson', $lesson);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LessonRequest $request
     * @param Lesson $lesson
     * @return void
     * @throws AuthorizationException
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson);
        $lesson->update($request->toArray());
        $gradeId = $request->get('grade_id', $lesson->grade_id);
        $message = 'Lesson successfully updated!';

        if (request()->expectsJson()) {
            return response()->json(['success' => $message]);
        }
        return redirect()->route('grades.show', $gradeId)->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lesson $lesson
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Lesson $lesson)
    {
        $this->authorize('delete', $lesson);
        $lesson->delete();

        $message = 'Lesson successfully deleted!';
        if (request()->expectsJson()) {
            return response()->json(['success' => $message]);
        }
        return back()->with('success', $message);
    }
}
