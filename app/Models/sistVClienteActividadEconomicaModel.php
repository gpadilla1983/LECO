<?php

namespace App\Models;

use CodeIgniter\Model;

class sistVClienteActividadEconomicaModel extends Model{
    protected $table = 'vw_cliente_actividad_economica';
    protected $primaryKey = 'id_cliente_actividad_economica';
    protected $allowedFields = ['id_cliente_actividad_economica', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_cliente',
                                'id_actividad_economica',
                                'estado_logico',
                                'captura',
                                'actualiza',
                                'datos_actividad_economica',
                                'datos_cliente',
                                'id_tipo_cliente',
                                'tipo_cliente'
                            ];

    protected $returnType = 'object';

    public function getDatosClienteActividadEconomica($id_estadologico = -1, $id_tipo_cliente = -1, $id_actividad_economica = -1)
    {  
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY vw_cliente_actividad_economica.id_cliente, vw_cliente_actividad_economica.id_actividad_economica) as row, vw_cliente_actividad_economica.*');   
        $datos = ($id_estadologico != -1) ? $this->where('vw_cliente_actividad_economica.id_estado_logico', $id_estadologico):''; 
        $datos = ($id_tipo_cliente != -1) ? $this->where('vw_cliente_actividad_economica.id_tipo_cliente', $id_tipo_cliente):''; 
        $datos = ($id_actividad_economica != -1) ? $this->where('vw_cliente_actividad_economica.id_actividad_economica', $id_actividad_economica):''; 
        $datos = $this->orderBy('vw_cliente_actividad_economica.id_cliente, vw_cliente_actividad_economica.id_actividad_economica', 'asc')
                ->findAll();

        return $datos;
    }

}