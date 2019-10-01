<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Http\Requests\GradeRequest;
use Illuminate\Http\Response;
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
        $grade = Grade::query()->find($grade_id)->load('lessons');
        $starts_at = strtotime($grade->lessons->min('starts_at'));
        $ends_at = strtotime($grade->lessons->max('ends_at'));
        $duration = $ends_at - $starts_at;

        return view('grade.show')
            ->with('grade', $grade)
            ->with('schedule', compact('starts_at', 'ends_at', 'duration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Grade $grade
     * @return Response
     */
    public function edit(Grade $grade)
    {
        $this->authorize('update', $grade);
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

        return redirect()->route('grades.index')->with('success', 'Class successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Grade $grade
     * @return Response
     */
    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Class successfully deleted!');
    }

}
