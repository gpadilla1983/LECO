<?php

namespace App\Models;

use CodeIgniter\Model;

class catNotariaModel extends Model{
    protected $table = 'cat_notaria_publica';
    protected $primaryKey = 'id_notaria_publica';
    protected $allowedFields = ['id_notaria_publica', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'no_notaria',
                                'nombre_notario',
                                'id_pais',
                                'id_entidad_federativa',
                                'id_alcaldia_municipio'
                            ];

    protected $returnType = 'object';

    public function getDatosNotaria($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_notaria_publica.id_notaria_publica) as row, cat_notaria_publica.*, el.desc_larga as estado_logico, p.desc_larga as pais, ef.desc_larga as entidad_federativa, m.desc_larga as alcaldia_municipio, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_notaria_publica.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_notaria_publica.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = $this->join('estado_logico el', 'cat_notaria_publica.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_pais p', 'cat_notaria_publica.id_pais = p.id_pais', 'INNER'); 
        $datos = $this->join('cat_entidad_federativa ef', 'cat_notaria_publica.id_entidad_federativa = ef.id_entidad_federativa', 'INNER'); 
        $datos = $this->join('cat_alcaldia_municipio m', 'cat_notaria_publica.id_alcaldia_municipio = m.id_alcaldia_municipio', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_notaria_publica.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_notaria_publica.no_notaria', 'asc')
                      ->findAll();

        return $datos;
    }
}