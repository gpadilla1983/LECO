<?php

namespace App\Models;

use CodeIgniter\Model;

class tipoClienteModel extends Model{
    protected $table = 'cat_tipo_cliente';
    protected $primaryKey = 'id_tipo_cliente';
    protected $allowedFields = ['id_tipo_cliente', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                            ];

    protected $returnType = 'object';

    public function getDatosTipoCliente($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_tipo_cliente.id_tipo_cliente) as row, cat_tipo_cliente.*, el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_tipo_cliente.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_tipo_cliente.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = $this->join('estado_logico el', 'cat_tipo_cliente.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_tipo_cliente.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_tipo_cliente.desc_corta', 'asc')
                      ->findAll();

        return $datos;
    }
}