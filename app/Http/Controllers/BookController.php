<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BookRepository;

class BookController extends Controller
{

	/**
     * The task repository instance.
     *
     * @var BookRepository
     */
    protected $books;


   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookRepository $books)
    {
        $this->middleware('auth');

        $this->books = $books;
    }

    /**
	 * Display a list of all of the user's books.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
	    return view('books.index', [
            'books' => $this->books->forUser($request->user())
        ]);
	}

	/**
	 * Create a new book.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $this->validate($request, [
	        'title' 		=> 'required|unique:books|max:255',
	        'author' 		=> 'required|max:255',
	        'isbn' 			=> 'required|unique:books|max:255',
	        'quantity' 		=> 'required|integer',
	        'shelfLocation' => 'required|max:255',
	    ]);

	    // Add book...
	     $request->user()->books()->create([
	        'title' 		=> $request->title,
	        'author' 		=> $request->author,
	        'isbn' 			=> $request->isbn,
	        'quantity' 		=> $request->quantity,
	        'shelfLocation' => $request->shelfLocation,
	    ]);
	    return redirect('/books');
	}

	/**
	 * Destroy the given book.
	 *
	 * @param  Request  $request
	 * @param  Book  $book
	 * @return Response
	 */
	public function destroy(Request $request, Book $book)
	{
		$this->authorize('destroy', $book);

    	// Delete The Book...
    	$book->delete();

    	return redirect('/books');
	}

	/**
     * Edit the given book     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit')->with('book', $book);
    }

    /**
	 * Update book info.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function updateBook(Request $request, Book $book)
	{
	    $this->validate($request, [
	        'title' 		=> 'required|max:255',
	        'author' 		=> 'required|max:255',
	        'isbn' 			=> 'required|max:255',
	        'quantity' 		=> 'required|integer',
	        'shelfLocation' => 'required|max:255',
	    ]);

	    // Update book...

		$book->update([
            'title' 		=> $request->title,
	        'author' 		=> $request->author,
	        'isbn' 			=> $request->isbn,
	        'quantity' 		=> $request->quantity,
	        'shelfLocation' => $request->shelfLocation,
        ]);

	    return redirect('/books');
	}

	/**
	 * Search Book
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function search(Request $request)
	{
	    $books = $this->books->search($request->keyword);

        return view('books.search', [ 'books' => $books ]);
	}

	/**
	 * Borrow Book
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function borrowBook(Request $request, Book $book)
	{

		if($this->books->canBorrow($book)) { 
			$this->books->borrow($request->user(), $book);
			return redirect('/books/search');
		}
		else{
			//return redirect('/books/search');
			$books = $this->books->search('');
			//display validation errors here
			return view("books.search", ["errorMsg"=> 'Maximum limit of books to borrow reached', 'books' => $books]);
		}

	}

	/**
	 * List all borrowed books to return
	 *
	 * @param  Request  $request
	 * @return Response
	 */

	public function bookReturnList(Request $request)
	{
	    $bookTransactions = $this->books->returnList($request->user());

        return view('books.return', [ 'bookTransactions' => $bookTransactions ]);
	}

	/**
	 * List all borrowed books to return
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	
	public function returnBook(Request $request)
	{
	    
	    $this->books->returnBook($request->bookTransaction);

        return redirect('/books/bookReturn');
	}

	/**
	 * Book reports
	 *
	 */
	
	public function reports()
	{
	    
	    $bookTransactionResult = $this->books->report();

        return view('books.report', [ 'bookTransactionResult' => $bookTransactionResult ]);
	}


}
