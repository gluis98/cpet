<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index() {
        return response()->json(User::all(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = User::create($request->all());
        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(User::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = User::findOrFail($id);
        $oficiales->fill([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);
        if(!empty($request->password)){
            $oficiales->password = Hash::make($request->password);
        }
        $oficiales->save();

        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        User::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }

    public function confirm_password_admin(Request $request){
        $users = User::where('role', 'Administrador')->get();
        $valid = false;
        foreach($users as $user){
            if (Hash::check($request->password, $user->password)) {
                $valid = true;
                break;
            }
        }
        if (!$valid) {
            return response()->json(['msj' => "Contrase a incorrecta."], 401);
        }

        return response()->json(['status' => true], 200);
    }
}
