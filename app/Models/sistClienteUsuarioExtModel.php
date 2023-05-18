<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteUsuarioExtModel extends Model{
    protected $table = 'sist_usuario_externo_cliente';
    protected $primaryKey = 'id_usuario_externo_cliente';
    protected $allowedFields = ['id_usuario_externo_cliente', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_usuario',
                                'id_cliente'
                            ];

    protected $returnType = 'object';

    public function getDatosUsuarioClienteExt($id_estadologico = -1, $id_clienteb = -1, $id_usuariob = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_usuario_externo_cliente.id_usuario) as row, sist_usuario_externo_cliente.*, 
        el.desc_larga as estado_logico, 
        u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, 
        u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza,
        u2.nombre as n_usuario, u2.primer_apellido as pa_usuario, u2.segundo_apellido as sa_usuario, c.razon_social');
        $datos = $this->join('usuario u2', 'sist_usuario_externo_cliente.id_usuario = u2.id_usuario', 'INNER');
        $datos = $this->join('sist_cliente c', 'sist_usuario_externo_cliente.id_cliente = c.id_cliente', 'INNER');
        $datos = $this->join('usuario u', 'sist_usuario_externo_cliente.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'sist_usuario_externo_cliente.id_actualiza = u1.id_usuario', 'LEFT');    
        $datos = $this->join('estado_logico el', 'sist_usuario_externo_cliente.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('sist_usuario_externo_cliente.id_estado_logico', $id_estadologico):''; 
        $datos = ($id_clienteb != -1) ? $this->where('sist_usuario_externo_cliente.id_cliente', $id_clienteb):'';
        $datos = ($id_usuariob != -1) ? $this->where('sist_usuario_externo_cliente.id_usuario', $id_usuariob):'';
        $datos = $this->orderBy('sist_usuario_externo_cliente.id_usuario', 'asc')
                      ->findAll();

        return $datos;
    }
}