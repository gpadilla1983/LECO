<?php

namespace App\Models;

use CodeIgniter\Model;

class catEntidadFederativaModel extends Model{
    protected $table = 'cat_entidad_federativa';
    protected $primaryKey = 'id_entidad_federativa';
    protected $allowedFields = ['id_entidad_federativa', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga',
                                'id_pais'
                            ];

    protected $returnType = 'object';

    public function getDatosEntidadFed($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_entidad_federativa.id_entidad_federativa) as row, cat_entidad_federativa.*, el.desc_larga as estado_logico, p.id_pais, p.desc_larga as pais, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_entidad_federativa.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_entidad_federativa.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = $this->join('estado_logico el', 'cat_entidad_federativa.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_pais p', 'cat_entidad_federativa.id_pais = p.id_pais', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_entidad_federativa.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_entidad_federativa.id_pais, cat_entidad_federativa.id_entidad_federativa', 'asc')
                      ->findAll();

        return $datos;
    }
   
}