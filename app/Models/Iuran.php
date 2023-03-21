<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Iuran extends Model
{
    use HasFactory;

    protected $fillable = ['idtrx','id_nik','jenistrx','nominaltrx','statustrx'];

     public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
                        ->translatedFormat('l, d F Y');
    }

    function warga(){
       return $this->belongsTo(Warga::class,'id_nik','nik');
    }
}
