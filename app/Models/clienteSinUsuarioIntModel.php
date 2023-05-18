<?php

namespace App\Models;

use CodeIgniter\Model;

class clienteSinUsuarioIntModel extends Model{
    protected $table = 'vw_cliente_sin_usuario_interno';
    protected $allowedFields = ['id_cliente',
                                'rfc',
                                'curp',
                                'razon_social',
                                'estado_logico',
                                'f_captura',
                            ];

    protected $returnType = 'object';

    public function getDatosUsuarioSinClienteInt()
    {
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY vw_cliente_sin_usuario_interno.id_cliente) as row, vw_cliente_sin_usuario_interno.*');
        $datos = $this->orderBy('vw_cliente_sin_usuario_interno.id_cliente', 'asc')
                      ->findAll();
        return $datos;
    }
}