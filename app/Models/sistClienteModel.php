<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteModel extends Model{
    protected $table = 'sist_cliente';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = ['id_cliente', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_tipo_cliente',
                                'rfc',
                                'curp',
                                'razon_social',
                                'e_mail',
                                'calle',
                                'no_exterior',
                                'no_interior',
                                'colonia',
                                'entre_calle',
                                'y_calle',
                                'id_alcaldia_municipio',
                                'id_entidad_federativa',
                                'id_pais',
                                'codigo_postal',
                                'telefono',
                                'id_notaria_publica',
                                'no_escritura',
                                'f_escritura',
                                'folio_mercantil',
                                'f_registro'
                            ];

    protected $returnType = 'object';


    public function getClientebyRFC($RFC="-1", $Nombre="-1")
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente.razon_social) as row, sist_cliente.*, ctc.desc_larga');  
        $datos = $this->join('estado_logico el', 'sist_cliente.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_tipo_cliente ctc', 'sist_cliente.id_tipo_cliente = ctc.id_tipo_cliente', 'INNER');
        $datos = ($RFC != "") ? $this->where('sist_cliente.rfc', $RFC) : $datos; 
        $datos = ($Nombre != "") ? $this->like('sist_cliente.razon_social', $Nombre, 'both') : $datos;
        $datos = $this->orderBy('sist_cliente.id_cliente', 'asc')->findAll();

        return $datos;
    }

    public function getClientebyIdCliente($IdCliente)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente.razon_social) as row, sist_cliente.*, ctc.desc_larga');  
        $datos = $this->join('estado_logico el', 'sist_cliente.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_tipo_cliente ctc', 'sist_cliente.id_tipo_cliente = ctc.id_tipo_cliente', 'INNER'); 
        $datos = $this->where('sist_cliente.id_cliente', $IdCliente); 
        $datos = $this->orderBy('sist_cliente.id_cliente', 'asc')->findAll();

        return $datos;
    }

    public function getCliente($id_estadologico = -1)
    {
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente.razon_social) as row, sist_cliente.*, 
         ctc.desc_larga as tipo_cliente, el.desc_larga as estado_logico, 
         u.nombre as n_captura, u.primer_apellido as pa_captura, u.segundo_apellido as sa_captura, 
         u1.nombre as n_actualiza, u1.primer_apellido as pa_actualiza, u1.segundo_apellido as sa_actualiza');
        $datos = $this->join('estado_logico el', 'sist_cliente.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_tipo_cliente ctc', 'sist_cliente.id_tipo_cliente = ctc.id_tipo_cliente', 'INNER'); 
        $datos = $this->join('usuario u', 'sist_cliente.id_captura = u.id_usuario', 'INNER');
        $datos = $this->join('usuario u1', 'sist_cliente.id_actualiza = u1.id_usuario', 'LEFT');       
        $datos = ($id_estadologico != -1) ? $this->where('sist_cliente.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('sist_cliente.id_cliente', 'asc')->findAll();

        return $datos;
    }
}