<?php

namespace App\Models;

use CodeIgniter\Model;

class catAnioDeclaracionModel extends Model{
    protected $table = 'cat_anio_declaracion';
    protected $primaryKey = 'id_anio_declaracion';
    protected $allowedFields = ['id_anio_declaracion', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga',
                                'anios'
                            ];

    protected $returnType = 'object';

    public function getDatosAnioDeclaracion($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_anio_declaracion.id_anio_declaracion) as row, cat_anio_declaracion.*, el.desc_larga as estado_logico');   
        $datos = $this->join('estado_logico el', 'cat_anio_declaracion.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_anio_declaracion.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_anio_declaracion.desc_corta', 'asc')
                      ->findAll();

        return $datos;
    }
}