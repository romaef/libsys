@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Book Form -->
        <form action="/book" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Book Name -->
            <div class="form-group">
                <h2>Book</h2>
                <div class="form-group">
                    <label for="email">Title:</label>
                    <input type="text" name="title" id="book-title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Author:</label>
                    <input type="text" name="author" id="book-author" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">ISBN:</label>
                    <input type="text" name="isbn" id="book-isbn" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Quantity:</label>
                    <input type="text" name="quantity" id="book-quantity" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Shelf Location:</label>
                    <input type="text" name="shelfLocation" id="book-shelfLocation" class="form-control">
                </div>
            </div>

            <!-- Add Book Button -->
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i> Add Book
            </button>
        </form>
    </div>

    <!-- All Books -->
    @if (count($books) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                All Books
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Quantity</th>
                        <th>Shelf Location</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <!-- Book title -->
                                <td class="table-text">
                                    <div>{{ $book->title }}</div>
                                </td>
                                <!-- Book author -->
                                <td class="table-text">
                                    <div>{{ $book->author }}</div>
                                </td>
                                <!-- Book isbn -->
                                <td class="table-text">
                                    <div>{{ $book->isbn }}</div>
                                </td>
                                <!-- Book quantity -->
                                <td class="table-text">
                                    <div>{{ $book->quantity }}</div>
                                </td>
                                <!-- Book shelfLocation -->
                                <td class="table-text">
                                    <div>{{ $book->shelfLocation }}</div>
                                </td>

                                <!-- Edit Button -->
                                <td>
                                    <form action="/book/edit/{{ $book->id }}" method="GET">
                                        <button type="submit" id="edit-book-{{ $book->id }}" class="btn btn-primary">
                                            <i class="fa fa-btn fa-pencil"></i>Edit Book
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Delete Button -->
                                    <form action="/book/{{ $book->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-danger">Delete Book</button>
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