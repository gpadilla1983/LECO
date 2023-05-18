<?php

namespace App\Models;

use CodeIgniter\Model;

class catPaisModel extends Model{
    protected $table = 'cat_pais';
    protected $primaryKey = 'id_pais';
    protected $allowedFields = ['id_pais', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                            ];

    protected $returnType = 'object';

    public function getDatosPais($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_pais.id_pais) as row, cat_pais.*, el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_pais.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_pais.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = $this->join('estado_logico el', 'cat_pais.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_pais.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_pais.desc_corta', 'asc')
                      ->findAll();

        return $datos;
    }
}