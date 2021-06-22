<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_siswa','nis','nisn','nama','tmptlhr','tgllhr','foto'
    ];

}
