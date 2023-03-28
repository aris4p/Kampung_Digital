<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Iuran extends Model
{
    use HasFactory;

    protected $fillable = ['idtrx','id_nik','jenistrx_id','nominaltrx','statustrx','snap_token'];

    protected $primaryKey = 'idtrx';
    public $incrementing = false;

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
        ->translatedFormat('l, d F Y');
    }

    function warga(){
        return $this->belongsTo(Warga::class,'id_nik','nik');
    }

    function dana(){
        return $this->belongsTo(Dana::class, 'jenistrx_id', 'id');
    }
}
