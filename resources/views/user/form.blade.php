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
                        <input id="user-name-input" type="text" name="name" value="{{ old('name') ?? old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user-email-input">E-mail</label>
                        <input id="user-email-input" type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user-password-input">Password</label>
                        <input id="user-password-input" type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user-password-input">Password Confirmation</label>
                        <input id="user-password-input" type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="user-role-input">Roles</label>
                        <select name="roles[]" id="user-role-input" class="form-control" multiple="multiple">
                            @foreach($roles as $role => $roleName)
                                @if ($user->hasRole($role))
                                    <option value="{{ $role }}" selected="selected">{{ $roleName }}</option>
                                @else
                                    <option value="{{ $role }}">{{ $roleName }}</option>
                                @endif
                            @endforeach
                            @error('roles')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </select>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-outline-primary">{{ $user->id ? 'Update' : 'Register' }}</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
