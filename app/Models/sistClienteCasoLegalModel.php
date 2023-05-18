<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteCasoLegalModel extends Model{
    protected $table = 'sist_cliente_caso_legal';
    protected $primaryKey = 'id_cliente_caso_legal';
    protected $allowedFields = ['id_cliente_caso_legal', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'no_expediente',
                                'desc_larga',
                                'id_cliente',
                                'id_tipo_caso_legal',
                                'f_inicio',
                                'f_termino',
                                'id_pais',
                                'id_entidad_federativa',
                                'id_alcaldia_municipio',
                                'id_juzgado',
                                'contraparte'
                            ];

    protected $returnType = 'object';

    public function getDatosClienteCasoLegal($ddl_tipoCasoLegalB = -1, $ddl_paisB = -1, $ddl_entidad_federativaB = -1, $ddl_alcaldia_municipioB = -1, $ddl_juzgadoB = -1, $ddl_estatus_cliente_caso_legalB = -1, $no_expedienteB = null, $usuario = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente_caso_legal.no_expediente) as row, sist_cliente_caso_legal.*, 
        el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, 
        u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza, 
        j.desc_larga as juzgado,ef.desc_larga as entidad_federativa, pa.desc_larga as pais, m.desc_larga as alcaldia_municipio, c.razon_social, tc.desc_larga as tipo_caso_legal');

        $datos = $this->join('usuario u', 'sist_cliente_caso_legal.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'sist_cliente_caso_legal.id_actualiza = u1.id_usuario', 'LEFT');   
        $datos = $this->join('estado_logico el', 'sist_cliente_caso_legal.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_juzgado j', 'sist_cliente_caso_legal.id_juzgado = j.id_juzgado', 'INNER');
        $datos = $this->join('cat_pais pa', 'sist_cliente_caso_legal.id_pais = pa.id_pais', 'INNER');
        $datos = $this->join('cat_entidad_federativa ef', 'sist_cliente_caso_legal.id_entidad_federativa = ef.id_entidad_federativa', 'INNER');
        $datos = $this->join('cat_alcaldia_municipio m', 'sist_cliente_caso_legal.id_alcaldia_municipio = m.id_alcaldia_municipio', 'INNER');
        $datos = $this->join('cat_tipo_caso_legal tc', 'sist_cliente_caso_legal.id_tipo_caso_legal = tc.id_tipo_caso_legal', 'INNER');
        $datos = $this->join('sist_cliente c', 'sist_cliente_caso_legal.id_cliente = c.id_cliente', 'INNER');
         
        $datos = ($ddl_tipoCasoLegalB != -1) ? $this->where('sist_cliente_caso_legal.id_tipo_caso_legal', $ddl_tipoCasoLegalB):''; 
        $datos = ($ddl_paisB != -1) ? $this->where('sist_cliente_caso_legal.id_pais', $ddl_paisB):''; 
        $datos = ($ddl_entidad_federativaB != -1) ? $this->where('sist_cliente_caso_legal.id_entidad_federativa', $ddl_entidad_federativaB):''; 
        $datos = ($ddl_alcaldia_municipioB != -1) ? $this->where('sist_cliente_caso_legal.id_alcaldia_municipio', $ddl_alcaldia_municipioB):''; 
        $datos = ($ddl_juzgadoB != -1) ? $this->where('sist_cliente_caso_legal.id_juzgado', $ddl_juzgadoB):''; 
        $datos = ($ddl_estatus_cliente_caso_legalB != -1) ? $this->where('sist_cliente_caso_legal.id_estado_logico', $ddl_estatus_cliente_caso_legalB):''; 
        $datos = ($no_expedienteB != null) ? $this->like('sist_cliente_caso_legal.no_expediente', $no_expedienteB, 'both'): $datos;  

        $datos = ($usuario != -1) ? $this->join('sist_usuario_cliente uec', 'sist_cliente_caso_legal.id_cliente = uec.id_cliente', 'INNER'):'';
        $datos = ($usuario != -1) ? $this->where('sist_cliente_caso_legal.id_estado_logico', 1):''; 
        $datos = ($usuario != -1) ? $this->where('uec.id_usuario', $usuario):'';    
        $datos = ($usuario != -1) ? $this->where('uec.id_estado_logico', 1):'';    
   
      
        $datos = $this->orderBy('sist_cliente_caso_legal.id_cliente_caso_legal', 'asc')
                      ->findAll();

        return $datos;
    }

    public function getDatosExpediente($usuario = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente_caso_legal.no_expediente) as row, sist_cliente_caso_legal.*, 
        el.desc_larga as estado_logico, u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, 
        u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza, 
        j.desc_larga as juzgado,ef.desc_larga as entidad_federativa, pa.desc_larga as pais, m.desc_larga as alcaldia_municipio, c.razon_social, tc.desc_larga as tipo_caso_legal');

        $datos = $this->join('usuario u', 'sist_cliente_caso_legal.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'sist_cliente_caso_legal.id_actualiza = u1.id_usuario', 'LEFT');   
        $datos = $this->join('estado_logico el', 'sist_cliente_caso_legal.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_juzgado j', 'sist_cliente_caso_legal.id_juzgado = j.id_juzgado', 'INNER');
        $datos = $this->join('cat_pais pa', 'sist_cliente_caso_legal.id_pais = pa.id_pais', 'INNER');
        $datos = $this->join('cat_entidad_federativa ef', 'sist_cliente_caso_legal.id_entidad_federativa = ef.id_entidad_federativa', 'INNER');
        $datos = $this->join('cat_alcaldia_municipio m', 'sist_cliente_caso_legal.id_alcaldia_municipio = m.id_alcaldia_municipio', 'INNER');
        $datos = $this->join('cat_tipo_caso_legal tc', 'sist_cliente_caso_legal.id_tipo_caso_legal = tc.id_tipo_caso_legal', 'INNER');
        $datos = $this->join('sist_cliente c', 'sist_cliente_caso_legal.id_cliente = c.id_cliente', 'INNER');
        $datos = ($usuario != -1) ? $this->join('sist_usuario_externo_cliente uec', 'sist_cliente_caso_legal.id_cliente = uec.id_cliente', 'INNER'):'';
        $datos = ($usuario != -1) ? $this->where('sist_cliente_caso_legal.id_estado_logico', 1):''; 
        $datos = ($usuario != -1) ? $this->where('uec.id_usuario', $usuario):'';    
        $datos = ($usuario != -1) ? $this->where('uec.id_estado_logico', 1):'';     
        $datos = $this->orderBy('sist_cliente_caso_legal.id_cliente_caso_legal', 'asc')
                      ->findAll();

        return $datos;
    }
}
