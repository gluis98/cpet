<?php

namespace App\Http\Controllers;

use App\Models\OficialesVacacione;
use Illuminate\Http\Request;

class OfficersVacationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id) {
        return response()->json(OficialesVacacione::where('id_policia', $id)->orderBy('id', 'desc')->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = OficialesVacacione::create($request->all());
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(OficialesVacacione::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = OficialesVacacione::findOrFail($id);
        $oficiales->update($request->all());

        if($request->is_disfrutadas) {
            $oficiales->update(['is_disfrutadas' => 1]);
        }else{
            $oficiales->update(['is_disfrutadas' => 0]);
        }
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        OficialesVacacione::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }
}
