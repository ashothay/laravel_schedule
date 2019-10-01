<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Http\Requests\GradeRequest;
use App\Lesson;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $grades = Grade::paginate(10);
        if (request()->expectsJson()) {
            $grades->each(function(Grade $grade) {
                $grade->setAttribute('can_edit', !Auth::guest() && Auth::user()->can('update', $grade));
                $grade->setAttribute('can_delete', !Auth::guest() && Auth::user()->can('delete', $grade));
            });
            $can_create = !Auth::guest() && Auth::user()->can('create', Grade::class);
            return response()->json(compact('grades', 'can_create'));
        }
        return view('grade.index')->with('grades', $grades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Grade::class);
        return view('grade.form')->with('grade', new Grade());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GradeRequest $request
     * @return Response
     */
    public function store(GradeRequest $request)
    {
        Grade::create($request->toArray());

        return redirect()->route('grades.index')->with('success', 'Class successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $grade_id
     * @return View
     * @internal param Grade $grade
     */
    public function show(int $grade_id)
    {
        $grade = Grade::query()->find($grade_id)->load('lessons.subject', 'lessons.teacher');
        $starts_at = strtotime($grade->lessons->min('starts_at'));
        $ends_at = strtotime($grade->lessons->max('ends_at'));
        $duration = $ends_at - $starts_at;
        $schedule = compact('starts_at', 'ends_at', 'duration');

        if (request()->expectsJson()) {
            $can_create_lesson = !Auth::guest() && Auth::user()->can('create', Lesson::class);
            $can_edit = !Auth::guest() && Auth::user()->can('update', $grade);
            $can_delete = !Auth::guest() && Auth::user()->can('delete', $grade);
            return response()->json(compact('grade', 'schedule', 'can_edit', 'can_delete', 'can_create_lesson'));
        }
        return view('grade.show')
            ->with('grade', $grade)
            ->with('schedule', $schedule);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Grade $grade
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Grade $grade)
    {
        $this->authorize('update', $grade);

        if (request()->expectsJson()) {
            return response()->json(compact('grade'));
        }
        return view('grade.form')->with('grade', $grade);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GradeRequest $request
     * @param Grade $grade
     * @return Response
     */
    public function update(GradeRequest $request, Grade $grade)
    {
        $grade->update($request->toArray());

        $message = 'Class successfully updated!';
        if (request()->expectsJson()) {
            return response()->json(['success' => $message]);
        }
        return redirect()->route('grades.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Grade $grade
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);
        $grade->delete();

        $message = 'Class successfully deleted!';
        if (request()->expectsJson()) {
            return response()->json(['success' => $message]);
        }
        return redirect()->route('grades.index')->with('success', $message);
    }

}
