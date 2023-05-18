<?php

namespace App\Models;

use CodeIgniter\Model;

class sistVClienteRegimenFiscalModel extends Model{
    protected $table = 'vw_cliente_regimen_fiscal';
    protected $primaryKey = 'id_cliente_regimen_fiscal';
    protected $allowedFields = ['id_cliente_regimen_fiscal', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_cliente',
                                'id_regimen_fiscal',
                                'estado_logico',
                                'captura',
                                'actualiza',
                                'datos_regimen_fiscal',
                                'datos_cliente',
                                'id_tipo_cliente',
                                'tipo_cliente'
                            ];

    protected $returnType = 'object';

    public function getDatosClienteRegimenFiscal($id_estadologico = -1, $id_tipo_cliente = -1, $id_regimen_fiscal = -1)
    {  
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY vw_cliente_regimen_fiscal.id_cliente, vw_cliente_regimen_fiscal.id_regimen_fiscal) as row, vw_cliente_regimen_fiscal.*');   
        $datos = ($id_estadologico != -1) ? $this->where('vw_cliente_regimen_fiscal.id_estado_logico', $id_estadologico):''; 
        $datos = ($id_tipo_cliente != -1) ? $this->where('vw_cliente_regimen_fiscal.id_tipo_cliente', $id_tipo_cliente):''; 
        $datos = ($id_regimen_fiscal != -1) ? $this->where('vw_cliente_regimen_fiscal.id_regimen_fiscal', $id_regimen_fiscal):''; 
        $datos = $this->orderBy('vw_cliente_regimen_fiscal.id_cliente, vw_cliente_regimen_fiscal.id_regimen_fiscal', 'asc')
                ->findAll();

        return $datos;
    }

}