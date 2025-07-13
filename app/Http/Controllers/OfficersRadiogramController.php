<?php

namespace App\Http\Controllers;

use App\Models\OficialesRadiograma;
use Illuminate\Http\Request;

class OfficersRadiogramController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index($id) {
        return response()->json(OficialesRadiograma::with('estacione')->where('id_policia', $id)->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = OficialesRadiograma::create($request->all());

        if(!empty($request->is_actual)){
            $oficiales->is_actual = 1;
        }else{
            $oficiales->is_actual = 0;
        }

        $oficiales->save();
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(OficialesRadiograma::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = OficialesRadiograma::findOrFail($id);
        $oficiales->update($request->all());

        if(!empty($request->is_actual)){
            $oficiales->is_actual = 1;
        }else{
            $oficiales->is_actual = 0;
        }

        $oficiales->save();
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        OficialesRadiograma::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }
}
