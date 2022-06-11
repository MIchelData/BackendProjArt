<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Enseignant;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {

        $field = $request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        $enseignant = Enseignant::where('email', $field['email'])->first();
        if(!$enseignant || !Hash::check($field['password'], $enseignant->password)){
            $eleve = Eleve::where('email', $field['email'])->first();
            if(!$eleve || !Hash::check($field['password'], $eleve->password)){
                return response([
                    'message' => 'erreur(s) dans les identifiants'
                ],401);
            }else{
                $token = $eleve->createToken('myapptoken')->plainTextToken;
                $response = [
                    'eleve' => $eleve,
                    'token' => $token
                ];
                return response($response,201);
            }

        }else{
            $token = $enseignant->createToken('myapptoken')->plainTextToken;
            $response = [
                'enseignant' => $enseignant,
                'token' => $token
            ];
            return response($response,201);
        }

    }
  //  $ensignant = Enseignant::class;
  //  $eleve = Eleve::class;
  //
  //  $response =

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message'=>'Logged out'
        ];

    }
}
