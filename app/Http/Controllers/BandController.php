<?php

namespace App\Http\Controllers;

use App\Models\Bands;
use App\Models\Genre;
use Illuminate\Http\Request;

class BandController extends Controller
{
    public function getAll()
    {
        $bands = $this->getBands();

        $formattedBands = $this->formatResponse($bands);
        
        return response()->json($formattedBands);
    }

    public function getById($id)
    {
        $band = null;

        foreach ($this->getBands() as $_band) {
            if ($_band['id'] == $id) {
                $band = $_band;
            }
        }
        return $band ? response()->json(
            [
                'id' => $band['id'],
                'name' => $band['name'],
                'genre' => $band->genre->name
            ]
        ) : abort(code: 404);
    }

    public function getByGenre($genre)
    {
        $bands = Bands::where('genre_id', $genre)->get();

        $formattedBands = $this->formatResponse($bands);

        return $bands ? response()->json($formattedBands) : abort(code: 404);
    }

    public function store(Request $request)
    {        
        $validate = $request->validate([
            'id' => 'numeric',
            'name' => 'required',
            'genre_id' => 'numeric'
        ]);

        $band = Bands::create($validate);

        return response()->json($band);
    }

    public function deleteBand($id)
    {
        $band = Bands::find($id);
        $band->delete();
        return response()->json("The band whas deleted!");
    }

    public function updateBand($id, Request $request){
        $band = Bands::find($id);
        
        $validate = $request->validate([
            'id' => 'numeric',
            'name' => 'required',
            'genre_id' => 'numeric'
        ]);

        $band->update($validate);

        return response()->json([
            "message" => "The band whas updated!",
            "data" => $validate
        ]);
    }

    public function getBands()
    {
        return Bands::with('genre')->get();
    }

    public function formatResponse($array)
    {
        $formattedBands = $array->map(function ($band) {
            return [
                'id' => $band['id'],
                'name' => $band['name'],
                'genre' => $band->genre->name
            ];
        });
        return $formattedBands;
    }

}
