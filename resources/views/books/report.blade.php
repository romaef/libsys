@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Bootstrap Boilerplate... -->
    
</div>
<!-- All Books -->
    @if (count($bookTransactionResult) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Reports
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Book copies</th>
                        <th>Number of times borrowed</th>
                        <th>Currently Borrowed qty</th>
                        <th>Currently Available qty</th>
                        <th>Total Amount of Book Penalties</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($bookTransactionResult as $bookTransaction)
                            <tr>
                                <!-- Book title -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['title'] }}</div>
                                </td>
                                <!-- Book author -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['author'] }}</div>
                                </td>
                                <!-- Book isbn -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['isbn'] }}</div>
                                </td>
                                <!-- Book copies -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['bookCopies'] }}</div>
                                </td>
                                <!-- Book number of times borrowed -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['numberOfTimesBorrowed'] }}</div>
                                </td>
                                <!-- Current number of borrowed books -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['currBorrowedQty'] }}</div>
                                </td>
                                <!-- Current available number of books -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['currAvailQty'] }}</div>
                                </td>
                                <!-- Accumulated penalties of book -->
                                <td class="table-text">
                                    <div>{{ $bookTransaction['totalBookPenalties'] }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection