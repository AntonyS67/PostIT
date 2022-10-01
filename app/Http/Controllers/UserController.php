<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
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
            "message" => "Registro exitoso",
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                //creamos el token
                $token = $user->createToken("auth_token")->accessToken;
                return response([
                    "message" => "Success Login",
                    "user" => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ],
                    "access_token" => $token
                ]);
            } else {
                return response()->json([
                    "message" => "Password Incorrect",
                ]);
            }
        } else {
            return response()->json([
                "error" => "Usuario no registrado",
            ], 404);
        }
    }

    public function joinToGroup(Group $group){
        $userBelongsToGroup = GroupUser::where('user_id',auth()->user()->id)->where('group_id',$group->id)->first();
        if(!isset($userBelongsToGroup)){
            $groupUser = new GroupUser();
            $groupUser->user_id = auth()->user()->id;
            $groupUser->group_id = $group->id;
            $groupUser->save();
            return response()->json([
                'message' => 'User join to group '.$group->id
            ]);
        }
        return response()->json([
            'message' => 'User belongs to group '.$group->id
        ]);
    }
}
