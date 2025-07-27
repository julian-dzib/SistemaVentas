<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    //
    use HasFactory;
    protected $table = "documentos";
    protected $primaryKey = "IDCODIGO";
    protected $fillable = [
        'IDCLIENTE',
        
        'SUBTOTAL',
        'IVA',
        'TOTAL',
    ];


    //Establecemos la relacion que existe entre la tb cliente 
    //Un Documento pertenece a un cliente 
    public function cliente(){
        return $this->belongsTo(Cliente::class,'IDCLIENTE', 'IDCLIENTE');
    }

    //Un documento tiene muchos renglones
    public function renglons(){
        return $this->hasMany(Documento_Renglon::class,'IDCODIGO','IDCODIGO');
    }



}
