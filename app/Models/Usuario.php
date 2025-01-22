<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public function pedidos(){

        return $this->hasMany(Pedido::class,'id_usuario','usuarios_id');
    }
}
