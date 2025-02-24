<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return response()->json(Policia::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title="Registrar nuevo oficial";
        return view('admin.officers.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'nombre_completo' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'tipo_sangre' => 'required|string|max:3',
            'talla_ropa' => 'required|string|max:10',
            'puesto' => 'required|string|max:100'
        ]);

        $policia = Policia::create($request->all());
        return response()->json($policia, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(Policia::findOrFail($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $request->validate([
            'nombre_completo' => 'sometimes|string',
            'fecha_nacimiento' => 'sometimes|date',
            'tipo_sangre' => 'sometimes|string|max:3',
            'talla_ropa' => 'sometimes|string|max:10',
            'puesto' => 'sometimes|string|max:100'
        ]);
        $policia = Policia::findOrFail($id);
        $policia->update($request->all());
        return response()->json($policia, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        Policia::destroy($id);
        return response()->json(null, 204);
    }
}
