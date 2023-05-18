<?php

namespace App\Models;

use CodeIgniter\Model;

class sistVClienteTResponsableModel extends Model{
    protected $table = 'vw_cliente_tresponsable';
    protected $primaryKey = 'id_cliente_tresponsable';
    protected $allowedFields = ['id_cliente_tresponsable', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_cliente',
                                'id_responsable',
                                'estado_logico',
                                'captura',
                                'actualiza',
                                'datos_responsable',
                                'datos_cliente'
                            ];

    protected $returnType = 'object';

    public function getDatosClienteTResponsable($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY vw_cliente_tresponsable.id_cliente, vw_cliente_tresponsable.id_responsable) as row, vw_cliente_tresponsable.*');   
        $datos = ($id_estadologico != -1) ? $this->where('vw_cliente_tresponsable.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('vw_cliente_tresponsable.id_cliente, vw_cliente_tresponsable.id_responsable', 'asc')
                ->findAll();

        return $datos;
    }

}