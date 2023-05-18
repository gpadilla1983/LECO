<?php

namespace App\Models;

use CodeIgniter\Model;

class catEstadoDeclaracionModel extends Model{
    protected $table = 'cat_estado_declaracion';
    protected $primaryKey = 'id_estado_declaracion';
    protected $allowedFields = ['id_estado_declaracion', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                            ];

    protected $returnType = 'object';

    public function getDatosEstadoDeclaracion($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_estado_declaracion.id_anio_declaracion) as row, cat_estado_declaracion.*, el.desc_larga as estado_logico');   
        $datos = $this->join('estado_logico el', 'cat_estado_declaracion.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_estado_declaracion.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_estado_declaracion.desc_corta', 'asc')
                      ->findAll();

        return $datos;
    }
}