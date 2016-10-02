@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Book Form -->
        <form action="{{ url('/user/update/' . $user->id) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Book Name -->
            <div class="form-group">
                <h2>Edit User</h2>
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" name="name" id="user-name" class="form-control" value="{{ old('name',  isset($user->name) ? $user->name : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">Age:</label>
                    <input type="text" name="age" id="user-age" class="form-control" value="{{ old('age',  isset($user->age) ? $user->age : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="user-email" class="form-control" value="{{ old('email',  isset($user->email) ? $user->email : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">UserType:</label>
                    <select class="form-control" name="userType" id="user-userType">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <!-- Add Book Button -->
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i> Save changes
            </button>
        </form>
        </div>
    </div>
@endsection
