<?php

namespace App\Models;

use CodeIgniter\Model;

class sistSocioModel extends Model{
    protected $table = 'sist_socio';
    protected $primaryKey = 'id_socio';
    protected $allowedFields = ['id_socio', 
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
                                'e_mail'
                            ];

    protected $returnType = 'object';

    public function getDatosSocio($id_estadologico = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_socio.id_socio) as row, sist_socio.*, el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('usuario u', 'sist_socio.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'sist_socio.id_actualiza = u1.id_usuario', 'LEFT');         
        $datos = $this->join('estado_logico el', 'sist_socio.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = ($id_estadologico != -1) ? $this->where('sist_socio.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('sist_socio.rfc', 'asc')
                      ->findAll();

        return $datos;
    }


    public function getDatosSociobyCliente($IdCliente)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_socio.id_socio) as row, sist_socio.*, cs.id_estado_logico as edologicocs ,el.desc_larga as estado_logico, cs.id_cliente, cs.id_cliente_socio');   
        $datos = $this->join('estado_logico el', 'sist_socio.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('sist_cliente_socio cs', 'sist_socio.id_socio = cs.id_socio', 'INNER'); 
        $datos = $this->join('sist_cliente c', 'c.id_cliente = cs.id_cliente', 'INNER'); 
        $datos = $this->where('cs.id_cliente', $IdCliente); 
        $datos = $this->orderBy('sist_socio.rfc', 'asc')->findAll();

        return $datos;
    }

    public function getDatosSociobySocio($IdSocioCliente)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_socio.id_socio) as row, sist_socio.*, el.desc_larga as estado_logico, cs.id_cliente, cs.id_estado_logico, cs.id_cliente_socio');   
        $datos = $this->join('estado_logico el', 'sist_socio.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('sist_cliente_socio cs', 'sist_socio.id_socio = cs.id_socio', 'INNER'); 
        $datos = ($IdSocioCliente != -1) ? $this->where('cs.id_cliente_socio', $IdSocioCliente):''; 
        $datos = $this->orderBy('sist_socio.rfc', 'asc')
                      ->findAll();

        return $datos;
    }

   
    
}