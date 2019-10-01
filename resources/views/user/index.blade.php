@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                Users

                <div class="float-right">
                    @can('create', App\UserListItem::class)
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-success">Add user</a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                @forelse($users as $user)
                    <div class="media mb-2">
                        <div class="media-body">
                            {{ $user->name }}
                            <div class="float-right">
                                @can('update', $user)
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="btn btn-sm btn-outline-primary">Edit</a>
                                @endcan
                                @can('delete', $user)
                                    <button onclick="$('#delete-user-{{ $user->id }}').submit();"
                                            class="btn btn-sm btn-outline-danger">Delete
                                    </button>
                                @endcan

                                <form id="delete-user-{{ $user->id }}" class="d-none"
                                      action="{{ route('users.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    Users list is empty!
                @endforelse
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
