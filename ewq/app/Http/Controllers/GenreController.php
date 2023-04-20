<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Http\Requests\GenreUpdateRequest;
use App\Http\Resources\GenreUpdateResorce;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function store(GenreRequest $request)
    {
        $genre = Genre::create($request->validated());

        return response() -> json([
            'data'=> [
                'status'=> 'true',
                'id'=> $genre->id
            ]
        ])->setStatusCode(200, 'Succeful Genre')->header('Content-Type','application/json');
    }
    public function update(GenreUpdateRequest $request, $id){
        $genre = Genre::where('id', $id)->first();
        if($genre === null)
        {
            return response()-> json([
                'data' => [
                    'message' => 'Genre not found'
                ]
            ])->setStatusCode(401, 'Genre not found');
        }

        return response()->json([
            'data' =>[
                'status' =>'true',
                'Genre' => new GenreUpdateResorce($genre)
            ]
        ])->setStatusCode(201, 'Succeful update');
    }

    public function destroy($id){

        $genre = Genre::where('id', $id)->first();
        if($genre===null){
            return response()-> json([
                'data' => [
                    'message' => 'Genre not found'
                ]
            ])->setStatusCode(401, 'Genre not found');
        }
        else{
            $genre->books()->detach();
            $genre->delete();
            return response()->json([
                'status'=> 'true'
            ])->setStatusCode(201, 'delete');
        };
    }
    public function index(){
        return response()-> json([
                'data'=>[
                    'items'=>GenreUpdateResorce::collection(genre::all())
                ]]
        )->setStatusCode(200, 'Lists posts');
    }
    public function show($id){
        $genre = Genre::where('id', $id)->first();
        if($genre===null){
            return response()-> json([
                'data' => [
                    'message' => 'Genre not found'
                ]
            ])->setStatusCode(401, 'Genre not found');
        }
        else{
            return response()-> json([
                    'data'=>[
                        new GenreUpdateResorce($genre)
                    ]]
            )->setStatusCode(220, 'Wiew posts');
        }
    }
}
