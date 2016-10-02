@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Bootstrap Boilerplate... -->
    
</div>
<!-- All Books -->
    @if (count($bookTransactions) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Borrowed Books
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Shelf Location</th>
                        <th>Penalty</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($bookTransactions as $bookTransaction)
                            <tr>
                                <!-- Book title -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction->title }}</div>
                                </td>
                                <!-- Book author -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction->author }}</div>
                                </td>
                                <!-- Book isbn -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction->isbn }}</div>
                                </td>
                                <!-- Book shelfLocation -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction->shelfLocation }}</div>
                                </td>
                                <!-- Book penalty -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction->penalty }}</div>
                                </td>
                                <td>
                                    <form action="/book/bookReturn/{{ $bookTransaction->bookTransactionId }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" id="return-book-{{ $bookTransaction->bookTransactionId}}" class="btn btn-primary">
                                            <i class="fa fa-btn fa-pencil"></i>Return Book
                                        </button>
                                    </form>
                                </td>                              
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection