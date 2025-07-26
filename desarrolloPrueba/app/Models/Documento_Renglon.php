<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento_Renglon extends Model
{
    //
    protected $table = "documentos_renglons";

    protected $primaryKey = "IDDOCUMENTO";

    protected $fillable = [
        'UNIDAD_MEDIDA',
        'CANTIDAD',
        'PRECIO1'
    ];


    //Relacion
    //Documento
    //Un documento renglon tiene un documento
    //Productos
    //Un documento renglon tiene un producto
    public function documento(){
        return $this->belongsTo(Documento::class,'IDCODIGO','IDCODIGO');
    }

    public function poducto(){
        return $this->belongsTo(Producto::class,'IDMATERIAL','IDMATERIAL');
        
    }


}
