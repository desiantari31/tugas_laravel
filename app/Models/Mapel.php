<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_mapel','mapel','hari','jamawal','jamakhir','pengajar','kelas'
    ];
}
