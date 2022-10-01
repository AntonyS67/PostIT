<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'group_id'
    ];
    public function images(){
        return $this->hasMany(ImageNote::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public static function filter($group_id, $request)
    {
        $notes = Note::with(['images'])->where('group_id',$group_id);
        if(isset($request->filter)){
            if(isset($request->filter['date_start']) and isset($request->filter['date_end'])){
                $notes = $notes->where(function($query) use($request){
                    $query->whereDate('created_at','>=',$request->filter['date_start'])
                    ->whereDate('created_at','<=',$request->filter['date_end']);
                });
            }
            if(isset($request->filter['image']) and $request->filter['image']){
                $notes = $notes->whereHas('images');
            }
        }
        $notes = $notes->get();
        return $notes;
    }
}
