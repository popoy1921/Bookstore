<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BooksModel;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllBooks()
    {
        return BooksModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBook(Request $oRequest)
    {
        $oBook = BooksModel::create($oRequest->all());
        return response()->json($oBook, 201);
    }

    /**
     * Display the specified resource.
     */
    public function getBook(int $iBookId)
    {
        $oBook = BooksModel::find($iBookId);
        if (isEmpty($oBook) === true) {
            return  response()->json(['message'  => "Book not found."], 501);
        }
        return $oBook;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBook(Request $oRequest, int $iBookId)
    {
        $oBook = BooksModel::find($iBookId);
        if (isEmpty($oBook) === true) {
            return  response()->json(['message'  => "Book not found."], 501);
        }
        $oBook->update($oRequest->all());
        return response()->json($oBook, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyBook(int $iBookId)
    {
        $oBook = BooksModel::find($iBookId);
        if (isEmpty($oBook) === true) {
            return  response()->json(['message'  => "Book not found."], 501);
        }
        $oBook->delete();
        return response()->json(['message'  => "Book has been deleted."], 200);
    }
}
