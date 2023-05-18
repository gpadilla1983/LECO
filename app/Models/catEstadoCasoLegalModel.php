<?php

namespace App\Models;

use CodeIgniter\Model;

class catEstadoCasoLegalModel extends Model{
    protected $table = 'cat_estado_caso_legal';
    protected $primaryKey = 'id_estado_caso_legal';
    protected $allowedFields = ['id_estado_caso_legal', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                            ];

    protected $returnType = 'object';

    public function getDatosEstadoCasoLegal($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_estado_caso_legal.id_estado_caso_legal) as row, cat_estado_caso_legal.*, el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_estado_caso_legal.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_estado_caso_legal.id_actualiza = u1.id_usuario', 'LEFT');    
        $datos = $this->join('estado_logico el', 'cat_estado_caso_legal.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_estado_caso_legal.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_estado_caso_legal.desc_corta', 'asc')
                      ->findAll();

        return $datos;
    }
}