@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">Teachers</div>

            <div class="card-body">

                <form action="{{ $user->id ? route('users.update', $user->id) : route('users.store') }}" method="post">
                    @csrf
                    @if ($user->id)
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="user-name-input">Name</label>
                        <input id="user-name-input" type="text" name="name" value="{{ $user->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-email-input">E-mail</label>
                        <input id="user-email-input" type="text" name="email" value="{{ $user->email }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-password-input">Password</label>
                        <input id="user-password-input" type="text" name="password" value="{{ $user->password }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-role-input">Role</label>
                        <select name="role" id="user-role-input">
                            <option value=""></option>
                            @foreach(\App\Role\UserRole::getRoleList() as $role => $roleName)
                                @if (in_array($role, $user->roles) && !isset($userRole))
                                    <option value="{{ $role }}" selected="selected">{{ $roleName }}</option>
                                    @php
                                        $userRole = $role
                                    @endphp
                                @else
                                    <option value="{{ $role }}">{{ $roleName }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
