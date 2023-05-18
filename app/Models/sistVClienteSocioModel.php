<?php

namespace App\Models;

use CodeIgniter\Model;

class sistVClienteSocioModel extends Model{
    protected $table = 'vw_cliente_socio';
    protected $primaryKey = 'id_cliente_socio';
    protected $allowedFields = ['id_cliente_socio', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_cliente',
                                'id_socio',
                                'estado_logico',
                                'captura',
                                'actualiza',
                                'datos_socio',
                                'datos_cliente'
                            ];

    protected $returnType = 'object';

    public function getDatosClienteSocio($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY vw_cliente_socio.id_cliente, vw_cliente_socio.id_socio) as row, vw_cliente_socio.*');   
        $datos = ($id_estadologico != -1) ? $this->where('vw_cliente_socio.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('vw_cliente_socio.id_cliente, vw_cliente_socio.id_socio', 'asc')
                ->findAll();

        return $datos;
    }

}