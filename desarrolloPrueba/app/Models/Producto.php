<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    use HasFactory;
    protected $table = "productos";
    protected $primaryKey = "IDMATERIAL";

    public $incrementing = false;  
    protected $keyType = 'string'; 

    protected $fillable = [
        'IDMATERIAL',
        'DESCRIPCION',
        'UNIDADMEDIDA',
        'PRECIO1',
    ];

    //Relacion 
    //Un producto puede aparecer en muchos renglones
    //Uno a Muchos 
    public function renglones(){
        return $this->hasMany(Documento_Renglon::class,'IDMATERIAL','IDMATERIAL');
    }

}
