<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class BookController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index () {
        $books = Book::all();
        return $this->successResponse($books, 200);
    }
    public function store (Request $request) {
        $rules = [
            'name'=>'required|max:255',
            'gender'=>'required|max:255|in:male,famale',
            'country'=>'required|max:255',
        ];

        $this->validate($request, $rules);
        $book = Book::create($request->all());
        return $this->successResponse($book, Response::HTTP_CREATED);
    }
    public function show ($book) {
        $data = Book::find($book);
        return $this->successResponse($data);
    }

    public function update (Request $request, $book) {
        $rules = [
            'name'=>'required|max:255',
            'gender'=>'required|max:255|in:male,famale',
            'country'=>'required|max:255',
        ];

        $this->validate($request, $rules);

        $book = Book::find($book);

        $book->fill($request->all());
        if($book->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();
        return $this->successResponse($book);
    }

    public function destroy ($book) {
        $book = Book::findOrFail($book);
        $book->delete();
        return $this->successResponse($book);
    }
}
