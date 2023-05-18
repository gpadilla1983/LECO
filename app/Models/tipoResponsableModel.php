<?php

namespace App\Models;

use CodeIgniter\Model;

class tipoResponsableModel extends Model{
    protected $table = 'cat_tipo_responsable';
    protected $primaryKey = 'id_tipo_responsable';
    protected $allowedFields = ['id_tipo_responsable', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                            ];

    protected $returnType = 'object';

    public function getDatosTipoResponsable($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY cat_tipo_responsable.id_tipo_responsable) as row, cat_tipo_responsable.*, el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'cat_tipo_responsable.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'cat_tipo_responsable.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = $this->join('estado_logico el', 'cat_tipo_responsable.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('cat_tipo_responsable.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('cat_tipo_responsable.desc_corta', 'asc')
                      ->findAll();

        return $datos;
    }
}