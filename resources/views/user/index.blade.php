@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Teachers</div>

            <div class="card-body">
                @forelse($users as $user)
                    <div class="media">
                        <div class="media-body">
                            {{ $user->name }}
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary">Edit</a>
                            <button onclick="$('#delete-user-{{ $user->id }}').submit();" class="btn btn-outline-danger">Delete</button>

                            <form id="delete-user-{{ $user->id }}" class="d-none" action="{{ route('users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @empty
                    Users list is empty!
                @endforelse
            </div>
        </div>
    </div>
@endsection
