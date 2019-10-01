@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Teachers</div>

            <div class="card-body">

                <form action="{{ $lesson->id ? route('lessons.update', $lesson->id) : route('lessons.store') }}" method="post">
                    @csrf
                    @if ($lesson->id)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="lesson-class-input" class="form-check-label">Class</label>
                        <select name="grade_id" id="lesson-class-input" class="form-control @error('grade_id') is-invalid @enderror">
                            @foreach($grades as $grade)
                                @if ($grade->id === $lesson->subject_id)
                                    <option value="{{ $grade->id }}" selected="selected">{{ $grade->name }}</option>
                                @else
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endif
                            @endforeach
                            @error('grade_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lesson-weekday-input">Week Day</label>
                        <select name="weekday" id="lesson-weekday-input" class="form-control @error('weekday') is-invalid @enderror">
                            @foreach([0, 1, 2, 3, 4] as $weekday)
                                @if ($weekday === $lesson->weekday)
                                    <option value="{{ $weekday }}" selected="selected">{{ jddayofweek($weekday, 1) }}</option>
                                @else
                                    <option value="{{ $weekday }}">{{ jddayofweek($weekday, 1) }}</option>
                                @endif
                            @endforeach
                            @error('weekday')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lesson-subject-input" class="form-check-label">Subject</label>
                        <select name="subject_id" id="lesson-subject-input" class="form-control @error('subject_id') is-invalid @enderror">
                            @foreach($subjects as $subject)
                                @if ($subject->id === $lesson->subject_id)
                                    <option value="{{ $subject->id }}" selected="selected">{{ $subject->name }}</option>
                                @else
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endif
                            @endforeach
                            @error('subject_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lesson-teacher-input">Teacher</label>
                        <select name="teacher_id" id="lesson-teacher-input" class="form-control @error('teacher_id') is-invalid @enderror">
                            @foreach($teachers as $teacher)
                                @if ($teacher->id === $lesson->teacher_id)
                                    <option value="{{ $teacher->id }}" selected="selected">{{ $teacher->name }}</option>
                                @else
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endif
                            @endforeach
                            @error('teacher_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lesson-starts_at-input">Starts at</label>
                        <input id="lesson-starts_at-input" name="starts_at" class="form-control @error('starts_at') is-invalid @enderror" value="{{ substr($lesson->starts_at, 0, -3) }}" type="time" pattern="[0-9]{2}:[0-9]{2}">
                        @error('starts_at')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lesson-ends_at-input">Ends at</label>
                        <input id="lesson-ends_at-input" name="ends_at" class="form-control @error('ends_at') is-invalid @enderror" value="{{ substr($lesson->ends_at, 0, -3) }}" type="time" pattern="[0-9]{2}:[0-9]{2}">
                        @error('ends_at')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                        <a href="{{ route('grades.show', $lesson->grade_id) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
