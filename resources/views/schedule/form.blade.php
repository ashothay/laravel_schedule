@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Teachers</div>

            <div class="card-body">

                <form action="{{ $schedule->id ? route('schedules.update', $schedule->id) : route('schedules.store') }}" method="post">
                    @csrf
                    @if ($schedule->id)
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="user-name-input">Name</label>
                        <input id="user-name-input" type="text" name="name" value="{{ $schedule->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-email-input">E-mail</label>
                        <input id="user-email-input" type="text" name="email" value="{{ $schedule->email }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-password-input">Password</label>
                        <input id="user-password-input" type="text" name="password" value="{{ $schedule->password }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-role-input">Role</label>
                        <select name="role" id="user-role-input">
                            <option value=""></option>
                            @foreach($teachers as $teacher)
                                @if ($teacher->id === $schedule->teacher_id)
                                    <option value="{{ $teacher->id }}" selected="selected">{{ $teacher->name }}</option>
                                @else
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user-role-input">Role</label>
                        <select name="role" id="user-role-input">
                            <option value=""></option>
                            @foreach($classes as $class)
                                @if ($class->id === $schedule->class_id)
                                    <option value="{{ $class->id }}" selected="selected">{{ $class->name }}</option>
                                @else
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
