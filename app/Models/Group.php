<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function users(){
        return $this->belongsToMany(User::class,'group_users');
    }
}
