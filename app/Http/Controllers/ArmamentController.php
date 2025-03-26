<?php

namespace App\Http\Controllers;

use App\Models\Armamento;
use Illuminate\Http\Request;

class ArmamentController extends Controller
{
  /**
     * Display a listing of the resource.
     */ 
    public function index() {
        return response()->json(Armamento::all(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = Armamento::create($request->all());
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(Armamento::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = Armamento::findOrFail($id);
        $oficiales->update($request->all());
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        Armamento::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }
}
