<?php

namespace App\Http\Controllers;

use App\Models\OficialesReconocimiento;
use Illuminate\Http\Request;

class OfficersAwardsController extends Controller
{
  /**
     * Display a listing of the resource.
     */ 
    public function index($id) {
        return response()->json(OficialesReconocimiento::where('id_policia', $id)->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = OficialesReconocimiento::create($request->all());
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(OficialesReconocimiento::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = OficialesReconocimiento::findOrFail($id);
        $oficiales->update($request->all());
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        OficialesReconocimiento::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }
}
