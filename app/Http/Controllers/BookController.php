<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ValidationHelper;
use App\Book;

class BookController extends Controller
{
    public function addBook (Request $req) {
        ValidationHelper::validate($req->all(), [
            'name' => 'required|string|unique:books',
            'author_id' => 'required|integer'
        ]);
        $book = new Book();
        $book->name = $req->name;
        $book->author_id = $req->author_id;
        $book->save();
        $book->author;
        return $book;
    }

    public function showAllBooks () {
        $books = Book::all();
        foreach ($books as $book) {
            $book->author;
        }
        return $books;
    }

    public function showBookById (Request $req, $id) {
        ValidationHelper::validate(['id' => $id], [
            'id' => 'required|integer'
        ]);
        $book = Book::find($id);
        $book->author;
        return $book;
    }

    public function updateBook (Request $req) {
        ValidationHelper::validate($req->all(), [
            'id' => 'required|integer',
            'name' => 'required|string|unique:books'
        ]);
        $book = Book::findOrFail($req->id);
        $book->name = $req->name;
        $book->save();
        return 'OK';
    }

    public function deleteBook($id) {
        ValidationHelper::validate(['id' => $id], [
            'id' => 'required|integer'
        ]);
        Book::destroy($id);
        return 'OK';
    }
}
