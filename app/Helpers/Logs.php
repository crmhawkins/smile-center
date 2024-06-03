<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use App\Models\Logs as log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Logs
{

    /**
     * Obtiene el prefijo por defecto de la URL del área de admin
     *
     * @return void
     */
    public static function insert($data, $id = null)
    {
        if ($id != null) {
            $usuario = User::find($id);
        }else{
            $userId = Auth::id();
            $usuario = User::find($userId);
        }
        if (Auth::check()){

        }

        $datos = [
            'admin_user_id' => $usuario->id,
            'action' => $data['action'],
            'descripcion' => $data['descripcion'],
            'status' => $data['status'],
        ];

        $log = log::create($datos);
        if ($log) {
           return 'ok';
        }
        return 'Error';
    }
}
