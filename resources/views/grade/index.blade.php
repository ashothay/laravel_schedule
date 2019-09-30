@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Classes</div>

            <div class="card-body">
                @forelse($grades as $grade)
                    <div class="media">
                        <div class="media-body">
                            {{ $grade->name }}
                            <div class="float-right">
                                <a href="{{ route('grades.show', $grade->id) }}" class="btn btn-outline-success">Show</a>
                                <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-outline-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                @empty
                    Grades list is empty!
                @endforelse
            </div>
        </div>
    </div>
@endsection
