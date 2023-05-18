<?php

namespace App\Models;

use CodeIgniter\Model;

class sistResponsableModel extends Model{
    protected $table = 'sist_responsable';
    protected $primaryKey = 'id_responsable';
    protected $allowedFields = ['id_responsable', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'nombre',
                                'primer_apellido',
                                'segundo_apellido',
                                'rfc',
                                'curp',
                                'e_mail',
                            ];

    protected $returnType = 'object';

    public function getDatosResponsable($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_responsable.id_responsable) as row, sist_responsable.*, el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'sist_responsable.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'sist_responsable.id_actualiza = u1.id_usuario', 'LEFT');         
        $datos = $this->join('estado_logico el', 'sist_responsable.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('sist_responsable.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('sist_responsable.rfc', 'asc')
                      ->findAll();

        return $datos;
    }

    public function ObtenerResponsablebyRFC($RFC)
    {
      
        $datos = $this->select('sist_responsable.*, el.desc_larga as estado_logico, CR.id_tipo_responsable');   
        $datos = $this->join('estado_logico el', 'sist_responsable.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('sist_cliente_tresponsable CR', 'sist_responsable.id_responsable = CR.id_responsable', 'LEFT'); 
        $datos = $this->where('sist_responsable.rfc', $RFC); 
        $datos = $this->orderBy('sist_responsable.rfc', 'asc')
                      ->findAll();

        return $datos;
    }

    public function getDatosResponsablebyCliente($idCliente){
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_responsable.id_responsable) as row, sist_responsable.*, CR.id_estado_logico as IdEdoLogicoCR,CR.id_cliente_tresponsable, CR.id_cliente, CR.id_tipo_responsable, TR.desc_larga');   
        $datos = $this->join('estado_logico el', 'sist_responsable.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('sist_cliente_tresponsable CR', 'sist_responsable.id_responsable = CR.id_responsable', 'INNER'); 
        $datos = $this->join('cat_tipo_responsable TR', 'CR.id_tipo_responsable = TR.id_tipo_responsable', 'INNER'); 
        $datos = $this->where('CR.id_cliente', $idCliente); 
        $datos = $this->orderBy('sist_responsable.rfc', 'asc')
                      ->findAll();
        

        return $datos;
    }


    public function getDatosResponsablebyResponsable($IdResponsableCliente)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_responsable.id_responsable) as row, sist_responsable.*, el.desc_larga as estado_logico,CR.id_cliente_tresponsable, CR.id_cliente, CR.id_tipo_responsable, TR.desc_larga');   
        $datos = $this->join('estado_logico el', 'sist_responsable.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('sist_cliente_tresponsable CR', 'sist_responsable.id_responsable = CR.id_responsable', 'INNER'); 
        $datos = $this->join('cat_tipo_responsable TR', 'CR.id_tipo_responsable = TR.id_tipo_responsable', 'INNER'); 
        $datos = $this->where('CR.id_cliente_tresponsable', $IdResponsableCliente); 
        $datos = $this->orderBy('sist_responsable.rfc', 'asc')
                      ->findAll();
        

        return $datos;
    }

}