<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ValidationHelper;
use App\Author;
use App\Book;

class AuthorController extends Controller
{
    public function addAuthor (Request $req) {
        ValidationHelper::validate($req->all(), [
            'name' => 'required|string|unique:authors'
        ]);
        $author = new Author();
        $author->name = $req->name;
        $author->save();
        $author->books;
        return $author;
    }

    public function showAllAuthors () {
        $authors = Author::all();
        foreach ($authors as $author) {
            $author->books;
        }
        return $authors;
    }

    public function showAuthorById (Request $req, $id) {
        ValidationHelper::validate(['id' => $id], [
            'id' => 'required|integer'
        ]);
        $author = Author::find($id);
        $author->books;
        return $author;
    }

    public function updateAuthor (Request $req) {
        ValidationHelper::validate($req->all(), [
            'id' => 'required|integer',
            'name' => 'required|string|unique:authors'
        ]);
        $author = Author::findOrFail($req->id);
        $author->name = $req->name;
        $author->save();
        return 'OK';
    }

    public function deleteAuthor($id) {
        ValidationHelper::validate(['id' => $id], [
            'id' => 'required|integer'
        ]);
        $books = Book::where('author_id', $id)->get();
        foreach ($books as $book) {
            Book::destroy($book->id);
        }
        Author::destroy($id);
        return 'OK';
    }
}
