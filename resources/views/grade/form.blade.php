@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">{{ $grade->id ? "Editing Class \"{$grade->name}\"" : 'New Class' }}</div>

            <div class="card-body">

                <form action="{{ $grade->id ? route('grades.update', $grade->id) : route('grades.store') }}" method="post">
                    @csrf
                    @if ($grade->id)
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="user-name-input">Name</label>
                        <input id="user-name-input" type="text" name="name" value="{{ old('name') ?? old('name', $grade->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-outline-primary">{{ $grade->id ? 'Update' : 'Register' }}</button>
                        <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
