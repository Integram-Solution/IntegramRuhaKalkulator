<?php

namespace App\Http\Controllers;

use App\Http\Resources\IntegramResource;
use App\Models\Integram;
use Illuminate\Http\Request;

class IntegramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Integram::all();
        return IntegramResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cegnev' => 'required|string|max:255',
            'cim' => 'required|string|max:255',
            'adoszam' => 'required|string|max:20',
            'nev' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'pdf' => 'required'
        ]);

        $integram = Integram::create($validatedData);

        return response()->json([
            'message' => 'Bejegyzés sikeresen létrehozva!',
            'data' => new IntegramResource($integram)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $integram = Integram::findOrFail($id);
        return new IntegramResource($integram);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'cegnev' => 'sometimes|required|string|max:255',
            'cim' => 'sometimes|required|string|max:255',
            'adoszam' => 'sometimes|required|string|max:20',
            'nev' => 'sometimes|required|string|max:255',
            'tel' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|email|max:255',
            'pdf' => 'sometimes|required'
        ]);

        $integram = Integram::findOrFail($id);
        $integram->update($validatedData);

        return response()->json([
            'message' => 'Bejegyzés sikeresen frissítve!',
            'data' => new IntegramResource($integram)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $integram = Integram::findOrFail($id);
        $integram->delete();

        return response()->json([
            'message' => 'Bejegyzés sikeresen törölve!'
        ]);
    }
}