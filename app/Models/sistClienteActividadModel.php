<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteActividadModel extends Model{
    protected $table = 'sist_cliente_actividad_economica';
    protected $primaryKey = 'id_cliente_actividad_economica';
    protected $allowedFields = ['id_cliente_actividad_economica', 
                                'id_actividad_economica',
                                'id_cliente', 
                                'id_estado_logico', 
                                'id_captura', 
                                'id_actualiza',
                                'f_captura',
                                'f_actualiza'
                               
                            ];

    protected $returnType = 'object';

   
    public function getDatosActividadbyCliente($IdCliente)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente_actividad_economica.id_cliente_actividad_economica) as row, sist_cliente_actividad_economica.id_estado_logico, sist_cliente_actividad_economica.id_actividad_economica,cae.desc_larga, el.desc_larga as estado_logico');  
        $datos = $this->join('estado_logico el', 'sist_cliente_actividad_economica.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_actividad_economica cae', 'sist_cliente_actividad_economica.id_actividad_economica = cae.id_actividad_economica', 'INNER'); 
        $datos = $this->join('sist_cliente c', 'c.id_cliente = sist_cliente_actividad_economica.id_cliente', 'INNER'); 
        $datos = $this->where('sist_cliente_actividad_economica.id_cliente', $IdCliente); 
        $datos = $this->orderBy('sist_cliente_actividad_economica.id_cliente_actividad_economica', 'asc')->findAll();

        return $datos;
    }

}