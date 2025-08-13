<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento_Renglon extends Model
{
    //
    protected $table = "documentos_renglons";

    protected $primaryKey = "IDDOCUMENTO";

    protected $fillable = [
        "IDCODIGO",
        'IDMATERIAL',


        'UNIDAD_MEDIDA',
        'CANTIDAD',
        'PRECIO1'
    ];


    //Relacion
    //Documento
    //Un documento renglon tiene un documento
    public function documento(){
        return $this->belongsTo(Documento::class,'IDCODIGO','IDCODIGO');
    }
    //Productos
    //Un documento renglon tiene un producto
    public function poducto(){
        return $this->belongsTo(Producto::class,'IDMATERIAL','IDMATERIAL');
        
    }


}
