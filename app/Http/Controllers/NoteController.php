<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\ImageNote;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index(Request $request, Group $group){
        $userBelongsToGroup = GroupUser::where('group_id',$group->id)->where('user_id',auth()->user()->id)->first();
        if(isset($userBelongsToGroup)){
            $notes = Note::filter($group->id, $request);
            return response()->json([
                'data' => $notes,
                'success' => 1
            ]);
        }
        return response()->json([
            'status' => 0,
            'message' => 'User doesnt belongs to group '.$group->id
        ]);
    }
    public function store(Request $request){
        try {
            DB::beginTransaction();
            $note = Note::create($request->all());
            if($request->hasFile('images')){
                foreach($request->file('images') as $file){
                    $originalName = $file->getClientOriginalName();
                    $path = $file->store('notes');
                    ImageNote::create([
                        'note_id' => $note->id,
                        'name' => $originalName,
                        'url' => $path
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'data' => $note,
                'message' => 'Note created'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()
            ],500);
        }
    }
    public function update(Request $request, Note $note){
        try {
            $note->title = $request->title;
            $note->description = $request->description;
            $note->group_id = $request->group->id;
            $note->save();
            return response()->json([
                'data' => $note,
                'message' => 'Note updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ],500);
        }
    }

    public function delete(Note $note){
        $note->delete();
        try {
            return response()->json([
                'message' => 'Note deleted'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ],500);
        }

    }

}
