<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageNote extends Model
{
    use HasFactory;
    protected $table = 'images_note';
    protected $fillable = [
        'name',
        'note_id',
        'url'
    ];
}
