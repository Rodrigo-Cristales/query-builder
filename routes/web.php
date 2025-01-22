<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultasController;

//ruta para mostrar el resultado del usuario con id 2, modo de uso: localhost/pedidos/2
Route::get('/pedidos/{id_usuario}', [ConsultasController::class, 'pedidosUsuario']);

//Ruta para mostrar los pedidos detallados modo de uso : localhost/pedidos
Route::get('/pedidos', [ConsultasController::class, 'PedidosDetallados']);

//Ruta para mostrar los pedidos con un rabgo de total de 100 a 250 modo de uso: localhost/rangos
Route::get('/rangos', [ConsultasController::class,'PedidosRangos']);

//Ruta para mostar los usuarios que empiezan con la letra R modo de uso: localhost/usuarios

Route::get('/usuarios', [ConsultasController::class, 'UsuarioR']);

//Ruta para mostrar el total del usuario con id 5, modo de uso: localhost/total/5

Route::get('/total/{id_usuario}', [ConsultasController::class, 'TotalPedidos']);

//Ruta para mostrar los pedidos de forma decentecedente, modo de uso: localhost/pedidos-usuario

Route::get('/pedidos-usuario', [ConsultasController::class, 'TotalPedidosDecendentes']);

//Ruta para mostrar la suma total de todo los pedidos modo de uso: localhost/suma

Route::get('/suma', [ConsultasController::class, 'TotalSuma']);

//Ruta para mostrar el pedido mas economico modo de uso: localhost/economico

Route::get('/economico', [ConsultasController::class, 'PedidoEconomico']);


//Ruta para mostrar agrupados por el nombre del usuario modo de uso: localhost/ordenado

Route::get('/ordenado', [ConsultasController::class, 'ProductoOrdenado']);

Route::get('/', function () {
    return view('welcome');
});

