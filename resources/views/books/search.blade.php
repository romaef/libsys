@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Book Form -->
        <form action="/books/search" method="GET">
            {{ csrf_field() }}

            <!-- Book Name -->
            <div class="form-group">
                @if( isset($errorMsg) )
                    <div class="alert alert-danger" role="alert"> <strong>Error!</strong> {{$errorMsg}} </div>
                @endif
                <div></div>
                <h2>Search Book:</h2>
                <div class="form-group">
                    <input type="text" name="keyword" id="book-keyword" class="form-control" placeholder="Search by title/author">
                </div>
            </div>

            <!-- Add Book Button -->
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i> Search Book
            </button>
        </form>
    </div>

    
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
                                @if ($book->allow_to_borrow)
                                <!-- Edit Button -->
                                <td>
                                    <form action="/book/borrow/{{ $book->id }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" id="borrow-book-{{ $book->id }}" class="btn btn-primary">
                                            <i class="fa fa-btn fa-pencil"></i>Borrow Book
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection