<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //Definir mi modelo Eloquent 
    use HasFactory;
    //Tabla
    protected $table = "clientes";
    //Primari key
    protected $primaryKey = 'IDCLIENTE';
    //Definir los campos de mi modelo cliente 
    protected $fillable = [
        'RAZON_SOCIAL',
        'RFC'
    ];
    //un cliente puede tener muchos documentos
    //uno a muchos (has many)
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'IDCLIENTE', 'IDCLIENTE'  );   
    }

}
