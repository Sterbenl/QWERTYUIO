<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookUpdateResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;

class BooKController extends Controller
{
    public function store (BookRequest $request)
    {
        $filename = $request->file('image')->store('/', 'public');
        $book = Book::create([
                'user_id' => Auth::user()->id,
                'image' => $filename
            ]+$request->validated());
        $book -> genres()->attach($request->genres);
        return response()->json([
            'data' => [
                'status' => 'true',
                'Book_id' => $book->id
            ]
        ])->setStatusCode(291, 'succeful creation');
    }
    public function update (BookUpdateRequest $request ,$id)
    {
        $book = Book::where('id', $id)->first();
        $filename = '';
        if($book === null)
        {
            return response()-> json([
                'data' => [
                    'message' => 'Book not found'
                ]
            ])->setStatusCode(401, 'Book not found');
        }
        else{
            if($request-> image){
                $filename = $request->file('image')->store('/', 'public');
                Storage::disk('public')-> delete($book -> image);
            }
            if( $request -> genres)
            {
                $book-> Book()->detach();
                $book ->Book()->attach($request->genres);
            }
            if($filename != '')
            {
                $book-> update([
                    'image' -> $filename
                            ] + $request->Validated());
                        }
            else
            {
                $book->update($request->validated());
            }
        }
        return response()->json([
            'data' =>[
                'status' =>'true',
                'post' => new BookUpdateResource($book)
            ]
        ])->setStatusCode(201, 'Succeful update');
    }

    public function destroy($id){

        $book = Book::where('id', $id)->first();
        if($book===null){
            return response()-> json([
                'data' => [
                    'message' => 'Book not found'
                ]
            ])->setStatusCode(401, 'Book not found');
        }
        else{
            $book->Book()->detach();
            $book->delete();
            return response()->json([
                'status'=> 'true'
            ])->setStatusCode(201, 'delete');
        }
    }
    public function index(){
        return response()-> json([
                'data'=>[
                    'items'=>BookUpdateResource::collection(Book::all())
                ]]
        )->setStatusCode(200, 'Lists books');
    }
    public function show($id){
        $book = Book::where('id', $id)->first();
        if($book===null){
            return response()-> json([
                'data' => [
                    'message' => 'book not found'
                ]
            ])->setStatusCode(401, 'book not found');
        }
        else{
            return response()-> json([
                    'data'=>[
                        new BookUpdateResource($book)
                    ]]
            )->setStatusCode(220, 'Wiew posts');
        }
    }
}
