<?php

namespace App\Models;

use CodeIgniter\Model;

class catAlcaldiaMunicipioModel extends Model{
    protected $table = 'cat_alcaldia_municipio';
    protected $primaryKey = 'id_alcaldia_municipio';
    protected $allowedFields = ['id_alcaldia_municipio', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_entidad_federativa',
                                'desc_corta',
                                'desc_larga'
                            ];

    protected $returnType = 'object';

    public function getDatosAlcadiaMun($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_alcaldia_municipio.id_alcaldia_municipio) as row, cat_alcaldia_municipio.*, el.desc_larga as estado_logico, ef.id_entidad_federativa, ef.desc_larga as entidad_federativa, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_alcaldia_municipio.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_alcaldia_municipio.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = $this->join('estado_logico el', 'cat_alcaldia_municipio.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_entidad_federativa ef', 'cat_alcaldia_municipio.id_entidad_federativa = ef.id_entidad_federativa', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_alcaldia_municipio.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_alcaldia_municipio.id_entidad_federativa, cat_alcaldia_municipio.id_alcaldia_municipio', 'asc')
                      ->findAll();

        return $datos;
    }
}