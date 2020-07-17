<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/books/add', 'BookController@addBook');
    Route::get('/books/list', 'BookController@showAllBooks');
    Route::get('/books/by-id/{id}', 'BookController@showBookById');
    Route::post('/books/update', 'BookController@updateBook');
    Route::delete('/books/id/{id}', 'BookController@deleteBook');

    Route::post('/authors/add', 'AuthorController@addAuthor');
    Route::get('/authors/list', 'AuthorController@showAllAuthors');
    Route::get('/authors/by-id/{id}', 'AuthorController@showAuthorById');
    Route::post('/authors/update', 'AuthorController@updateAuthor');
    Route::delete('/authors/id/{id}', 'AuthorController@deleteAuthor');
});
