<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
        return Group::all();
    }
    public function store(Request $request){
        try {
            $group = Group::create($request->all());
            return response()->json([
                'data' => $group,
                'message' => 'Group created'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ],500);
        }
    }
    public function update(Request $request, Group $group){
        try {
            $group->name = $request->name;
            $group->description = $request->description;
            $group->save();
            return response()->json([
                'data' => $group,
                'message' => 'Group updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ],500);
        }
    }
    public function delete(Group $group){
        try {
            $group->delete();
        return response()->json([
            'message' => 'Group deleted'
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }

    }
}
