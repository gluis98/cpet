<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return response()->json(Cargo::all(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = Cargo::create($request->all());
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(Cargo::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = Cargo::findOrFail($id);
        $oficiales->update($request->all());
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        Cargo::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 204);
    }
}
