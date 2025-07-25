<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use App\Models\OficialesSalud;
use App\Models\OficialesSaludReposo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OfficersHealthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id) {
        return response()->json(OficialesSalud::where('id_policia', $id)->orderBy('id', 'desc')->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = OficialesSalud::create($request->all());
        $of = Oficiale::findOrFail($request->id_policia);
        if($request->is_vigente) {
            $oficiales->update(['is_vigente' => 1]);
            $of->update(['estatus' => 'REPOSO']);
        }else{
            $oficiales->update(['is_vigente' => 0]);
            $of->update(['estatus' => 'OPERATIVO']);
        }
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(OficialesSalud::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = OficialesSalud::findOrFail($id);
        $oficiales->update($request->all());

        $of = Oficiale::findOrFail($request->id_policia);
        if($request->is_vigente) {
            $oficiales->update(['is_vigente' => 1]);
            $of->update(['estatus' => 'REPOSO']);
        }else{
            $oficiales->update(['is_vigente' => 0]);
            $of->update(['estatus' => 'OPERATIVO']);
        }
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        OficialesSalud::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }   
}
