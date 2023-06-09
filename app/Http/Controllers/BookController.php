<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        if($books) {
            return ApiFormatter::createApi(200, 'succes', $books);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'book_code' => 'required',
                'name_book' => 'required',
                'penulis' => 'required',
            ]);

            $newName = '';
            if($request->file){
                $extension = $request->file('file')->getClientOriginalExtension();
                $newName = $request->name_book.'-'.now()->timestamp.'.'.$extension;
                $request->file('file')->move(public_path('/storage'), $newName);
            }
    
            $request['image'] = $newName;
            // $book = Book::create($request->all());

            $book = Book::create([
                'book_code' => $request->book_code,
                'name_book' => $request->name_book,
                'penulis' => $request->penulis,
                'image' => $newName,
            ]);

            $getDateSaved = Book::where('id', $book->id)->first();

            if ($getDateSaved) {
                return ApiFormatter::createApi(200, 'succes', $getDateSaved);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $error){
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $bookDetail = Book::where('id', $id)->first();

            if ($bookDetail){
                return ApiFormatter::createApi(200, 'succes', $bookDetail);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch(Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'book_code' => 'required',
                'name_book' => 'required',
                'penulis' => 'required',
                'image' => 'required',
            ]);

            $book = Book::findOrFail($id);

            $newName = '';
            if($request->file){
                $extension = $request->file('file')->getClientOriginalExtension();
                $newName = $request->name_book.'-'.now()->timestamp.'.'.$extension;
                $request->file('file')->move(public_path('/storage'), $newName);
            }   
    
            $request['image'] = $newName;
            // $book = Book::update($request->all());

            $book->update([
                'book_code' => $request->book_code,
                'name_book' => $request->name_book,
                'penulis' => $request->penulis,
                'image' => $newName,
            ]);
            
            // $updatedBook = Book::Where('id', $book->id)->first();
            $updatedBook = Book::where('id', $book->id)->first();
            if ($updatedBook) {
                return ApiFormatter::createApi(200, 'success', $updatedBook);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $book = Book::findOrFail($id);
            $proses = $book->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data');
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
}
