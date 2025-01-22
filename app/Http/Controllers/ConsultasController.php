<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    //

        //funcion para obtener los pedidos con determinado id de usuario;

        public function pedidosUsuario($id_usuario){

            $pedidos = Pedido::where('id_usuario', $id_usuario)->get();

            if($pedidos->isEmpty()){
                return response()->json(['mensaje' => 'No se encontraron pedidos para el usuario con id '.$id_usuario], 404);
            }
                return response()->json($pedidos);
        }

        //consulta para obtener los pedidos detallados con el nombre y correo del usuario
        public function PedidosDetallados(){
            
            $pedidos = Pedido::with(['usuario:usuarios_id,nombre,correo']) ->get()
            -> map(function ($pedido){
                return[
                    'producto' => $pedido->producto,
                    'cantidad' => $pedido->cantidad,
                    'total' => $pedido->total,
                    'nombre_usuario' => $pedido->usuario->nombre,
                    'correo_usuario' => $pedido->usuario->correo

                ];
            });

            return response()->json($pedidos);
        }

        //Funcion para obtener los pedidos con un rango total del 100 o 250;

        Public function PedidosRangos(){

            $pedidos = DB::table('Pedidos')->whereBetween('total',[100,250])->get();

            return response()->json($pedidos);

        }

        //Funcion para obtener todos los nombres que empicen con la letra R;

        Public function UsuarioR(){

            $usuarios = DB::table('Usuarios')->where('nombre','like','R%')->get();

            return response()->json($usuarios);
        }


        //Funcion para calcular el total de pedidos del usuario con id 5;

        public function TotalPedidos($id_usuario){

            $total = DB::table('Pedidos')->where('id_usuario', $id_usuario)->sum('total');

            return response()->json(['total'=>$total]);
        }

    
        //Funcion para recuperar la informacion de todos los pedidos con la informacion del usuario ordenados de forma 
        //descedentes segun el total de pedidos;

        public function TotalPedidosDecendentes(){

            $pedidos = DB::table('Pedidos') 
            ->join('Usuarios', 'Pedidos.id_usuario', '=', 'Usuarios.usuarios_id')
            ->select(
                'Pedidos.pedido_id as pedido_id',
                'Pedidos.total as total_pedido',
                'Usuarios.usuarios_id as usuario_id',
                'Usuarios.nombre as nombre_usuario',
                'Usuarios.correo as correo_usuario',
                'Usuarios.telefono as telefono_usuario'
            ) 
            ->orderBy('pedidos.total','desc')
            -> get();

                return response()->json($pedidos);

        }

        //Funcion para obtener la suma total de pedidos;

        public function TotalSuma(){

            $suma = DB::table('Pedidos')->sum('total');

            return response()->json(['suma'=>$suma]);
        }

        //Funcion para obtener el pedido mas economico con el nombre del usuario;

        public function PedidoEconomico(){

            $pedido = DB::table('Pedidos')
            ->join('Usuarios', 'Pedidos.id_usuario', '=', 'Usuarios.usuarios_id')
            ->select(
                'Pedidos.pedido_id as pedido_id',
                'Pedidos.total as total_pedido',
                'Usuarios.usuarios_id as usuario_id',
                'Usuarios.nombre as nombre_usuario',
            )
            ->where('Pedidos.total', function($query){
                $query->selectRaw(('MIN(total)'))
                ->from('Pedidos');
            })
            ->first();

            return response()->json($pedido);
        }

        //funcion para obtner obtner el producto y ordenarlos agrupados por el nombre del usuario;

        public function ProductoOrdenado(){

            $pedidos = DB::table('Pedidos')
            ->join('Usuarios', 'Pedidos.id_usuario', '=', 'Usuarios.usuarios_id')
            ->select(
                'Pedidos.pedido_id as pedido_id',
                'Pedidos.producto as producto',
                'Usuarios.usuarios_id as usuario_id',
                'Usuarios.nombre as nombre_usuario',
            )
            ->orderBy('Usuarios.nombre')
            ->orderByDesc('Pedidos.total')
            ->get();

            return response()->json($pedidos);

        }



}
