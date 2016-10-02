<?php

namespace App\Repositories;

use App\User;
use App\Book;
use App\BookTransaction;
use Auth;
use DateTime;

class BookRepository
{
    /**
     * Get all of the books for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Book::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    /**
     * Get all of the books for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function search($keyword)
    {
        $book =  Book::where('title' , 'like' ,'%'.$keyword.'%')
                    ->orWhere('author', 'like' ,'%'.$keyword.'%')
                    ->orderBy('created_at', 'asc')
                    ->get();

        foreach($book as $k => $value){
           $book[$k][ 'borrowed_count' ] = BookTransaction::where('bookId' , $book[$k]['id'])->whereNull('dateReturned')->count();
            if(   $book[$k][ 'quantity' ]   > $book[$k][ 'borrowed_count' ] ){
             $book[$k][ 'allow_to_borrow' ]  = true;
            } else {
             $book[$k][ 'allow_to_borrow' ]  = false;
            }
        }

        return $book;

    }

    /**
     * Get allowed number of books based on age 
     * Junior Member (age <= 12 years) can loan a maximum of 3 books ; Regular is 6 boks
     * @return  boolean $result
     */
    public function allowedBooksToLoan()
    {
        $booksToLoan = 6;

        if(Auth::user()->age <=12){
            $booksToLoan = 3;
        }

        return $booksToLoan;

    }

    /**
     * Get current count of borrowed books
     *
     * @return  boolean $result
     */
    public function borrowedBooks()
    {
        return BookTransaction::where('userId', Auth::user()->id)
                              ->whereNull('dateReturned')
                              ->count();

    }

    /**
     * Validate senior member borrow limit
     *
     * @return  int $balance
     */
    public function canBorrow(Book $book)
    {
        $allowedBooksToLoan = $this->allowedBooksToLoan();
        $borrowedBooks      = $this->borrowedBooks();

        //check if book is available 

        $isAvailable = Book::where('id' , $book->id)
                        ->count();

        //+1 is you can only borrow one book at a time
        $balance = $allowedBooksToLoan - ($borrowedBooks + 1);

        if($balance >= 0 && $isAvailable > 0){
            return true;
        }else{
            return false;
        }        

    }


    /**
     * Borrow a book by user
     *
     * @param  User $user
     * @param  Book $book
     */
    public function borrow(User $user, Book $book)
    {
        //insert into book transaction table
        BookTransaction::insert([
            'userId'        => $user->id,
            'bookId'        => $book->id,
            'dateBorrowed'  => date('Y-m-d H:i:s')
        ]);

    }

    /**
     * Compute for the penalty per book
     *
     * @param  Date $dateBorrowed   Date $dateReturned
     * @return Collection
     */
    public function computePenalty($dateBorrowed){

        $penaltyAmount = 2;

        $dteStart = new DateTime($dateBorrowed); 
        $dteEnd   = new DateTime();

        $dteStart->format('Y-m-d');
        $dteEnd->format('Y-m-d');

        $diff = $dteEnd->diff($dteStart)->format("%a");

        
        //difference is greater than 2 weeks
        if($diff > 14){
            $penalty = ($diff - 14) * 2;
        }else{
            $penalty = 0;
        }

        return $penalty;
    }

    /**
     * Get all of the books borrowed for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function returnList(User $user)
    {
        $borrowedBooks =  User::leftJoin('book_transactions', 'book_transactions.userId' ,'=', 'users.id')
                    ->leftJoin('books', 'book_transactions.bookId','=','books.id')
                    ->where('users.id', Auth::user()->id)
                    ->whereNull('book_transactions.dateReturned')
                    ->get();

        foreach ($borrowedBooks as $key => $value) {
            $penalty = $this->computePenalty($borrowedBooks[$key]['dateBorrowed']);
            $borrowedBooks[$key]['penalty'] = $penalty;
            $borrowedBooks[$key]['bookTransactionId'] = $borrowedBooks[$key]['transId'];

        }

        return $borrowedBooks;
    }

    /**
     * Return a book by user
     *
     * @param  User $user
     * @param  Book $book
     */
    public function returnBook($bookTransactionId)
    {

        $bookTransaction = BookTransaction::where('transId', $bookTransactionId)
                                            ->first();
        
        $penalty = $this->computePenalty($bookTransaction->dateBorrowed);

        //update transaction table
        
        BookTransaction::where('transId', $bookTransactionId)
                        ->update([
                            'penalty' => $penalty,
                            'dateReturned' => new DateTime()
                        ]);
        
    }

    public function numberOfTimesBorrowed($bookId){
        return BookTransaction::where('bookId' , $bookId)
                        ->count();

    }

    public function currBorrowedQty($bookId){
        return BookTransaction::where('bookId' , $bookId)
                            ->whereNull('dateReturned')
                            ->count();

    }

    public function totalBookPenalties($bookId){
        return BookTransaction::where('bookId' , $bookId)
                                  ->sum('penalty');
    }

    /**
     * Return reports
     *
     * 
     */
    public function report()
    {

        $bookTransactionIds = BookTransaction::groupby('bookId')
                                            ->distinct()
                                            ->get();  

        $bookTransactionResult = array();

        foreach ($bookTransactionIds as $key => $value) {
            //get from book table
            $book = Book::where('id', $bookTransactionIds[$key]['bookId'])
                        ->first();

            //result array
            $bookTransactionResult[$key]['title']                   = $book->title;
            $bookTransactionResult[$key]['author']                  = $book->title;
            $bookTransactionResult[$key]['isbn']                    = $book->title;
            $bookTransactionResult[$key]['bookCopies']              = $book->quantity;
            $bookTransactionResult[$key]['numberOfTimesBorrowed']   = $this->numberOfTimesBorrowed($bookTransactionIds[$key]['bookId']);
            $bookTransactionResult[$key]['currBorrowedQty']         = $this->currBorrowedQty($bookTransactionIds[$key]['bookId']);
            $bookTransactionResult[$key]['currAvailQty']            = $book->quantity - $bookTransactionResult[$key]['currBorrowedQty'];
            $bookTransactionResult[$key]['totalBookPenalties']      = $this->totalBookPenalties($bookTransactionIds[$key]['bookId']);
        } 

        //var_dump($bookTransactionResult);

        return $bookTransactionResult;
       
        
    }


}