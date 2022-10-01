<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "msg" => "Registro exitoso",
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where("email", "=", $request->email)->first();
        if (isset($user)) {
            if (Hash::check($request->password, $user->password)) {
                //creamos el token
                $token = $user->createToken("auth_token")->plainTextToken;
                return response([
                    "status" => 1,
                    "msg" => "Usuario registrado exitosamente",
                    "user" => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ],
                    "access_token" => $token
                ]);
            } else {
                return response()->json([
                    "msg" => "la password es incorrecta",
                ]);
            }
        } else {
            return response()->json([
                "msg" => "Usuario no registrado",
            ], 404);
        }
    }
}
