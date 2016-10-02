@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New User Form -->
        <form action="/user" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- User Name -->
            <div class="form-group">
                <h2>User</h2>
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" name="name" id="user-name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Age:</label>
                    <input type="text" name="age" id="user-age" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="user-email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">UserType:</label>
                    <select class="form-control" name="userType" id="user-userType">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <!-- Add User Button -->
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i> Add User
            </button>
        </form>
    </div>

    <!-- All Users -->
    @if (count($users) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                All Users
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <!-- User Name -->
                                <td class="table-text">
                                    <div>{{ $user->name }}</div>
                                </td>
                                <!-- User Age -->
                                <td class="table-text">
                                    <div>{{ $user->age }}</div>
                                </td>
                                <!-- User Email -->
                                <td class="table-text">
                                    <div>{{ $user->email }}</div>
                                </td>
                                <!-- User UserType -->
                                <td class="table-text">
                                    <div>{{ $user->userType }}</div>
                                </td>
                                <td>
                                    <form action="/user/edit/{{ $user->id }}" method="GET">
                                        <button type="submit" id="edit-user-{{ $user->id }}" class="btn btn-primary">
                                            <i class="fa fa-btn fa-pencil"></i>Edit User
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Delete Button -->
                                    <form action="/user/{{ $user->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-danger">Delete User</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection