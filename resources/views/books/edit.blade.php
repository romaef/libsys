@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Book Form -->
        <form action="{{ url('/book/update/' . $book->id) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Book Name -->
            <div class="form-group">
                <h2>Edit Book</h2>
                <div class="form-group">
                    <label for="email">Title:</label>
                    <input type="text" name="title" id="book-title" class="form-control" value="{{ old('title',  isset($book->title) ? $book->title : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">Author:</label>
                    <input type="text" name="author" id="book-author" class="form-control" value="{{ old('author',  isset($book->author) ? $book->author : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">ISBN:</label>
                    <input type="text" name="isbn" id="book-isbn" class="form-control" value="{{ old('isbn',  isset($book->isbn) ? $book->isbn : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">Quantity:</label>
                    <input type="text" name="quantity" id="book-quantity" class="form-control" value="{{ old('quantity',  isset($book->quantity) ? $book->quantity : null) }}">
                </div>
                <div class="form-group">
                    <label for="email">Shelf Location:</label>
                    <input type="text" name="shelfLocation" id="book-shelfLocation" class="form-control" value="{{ old('shelfLocation',  isset($book->shelfLocation) ? $book->shelfLocation : null) }}">
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
