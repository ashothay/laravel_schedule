@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                Classes

                <div class="float-right">
                    @can('create', App\Grade::class)
                        <a href="{{ route('grades.create') }}" class="btn btn-sm btn-outline-success">Add Class</a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                @forelse($grades as $grade)
                    <div class="media">
                        <div class="media-body mb-2">

                            <a href="{{ route('grades.show', $grade->id) }}">{{ $grade->name }}</a>

                            <div class="float-right">
                                @can('update', $grade)
                                    <a href="{{ route('grades.edit', $grade->id) }}"
                                       class="btn btn-sm btn-outline-primary">Edit</a>
                                @endcan
                                @can('delete', $grade)
                                    <button onclick="$('#delete-class-{{ $grade->id }}').submit()"
                                            class="btn btn-sm btn-outline-danger">Delete
                                    </button>
                                    <form id="delete-class-{{ $grade->id }}" action="{{ route('grades.destroy', $grade->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    Grades list is empty!
                @endforelse
                {{ $grades->links() }}
            </div>
        </div>
    </div>
@endsection
