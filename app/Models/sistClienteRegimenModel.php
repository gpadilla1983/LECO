<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteRegimenModel extends Model
{
    protected $table = 'sist_cliente_regimen_fiscal';
    protected $primaryKey = 'id_cliente_regimen_fiscal';
    protected $allowedFields = [
        'id_cliente_regimen_fiscal',
        'id_regimen_fiscal',
        'id_cliente',
        'id_estado_logico',
        'id_captura',
        'id_actualiza',
        'f_captura',
        'f_actualiza'

    ];

    protected $returnType = 'object';


    public function getDatosRegimenbyCliente($IdCliente)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_cliente_regimen_fiscal.id_cliente_regimen_fiscal) as row, sist_cliente_regimen_fiscal.id_estado_logico, sist_cliente_regimen_fiscal.id_regimen_fiscal,crf.desc_larga, el.desc_larga as estado_logico');  
        $datos = $this->join('estado_logico el', 'sist_cliente_regimen_fiscal.id_estado_logico = el.id_estado_logico', 'INNER'); 
        $datos = $this->join('cat_regimen_fiscal crf', 'sist_cliente_regimen_fiscal.id_regimen_fiscal = crf.id_regimen_fiscal', 'INNER'); 
        $datos = $this->join('sist_cliente c', 'c.id_cliente = sist_cliente_regimen_fiscal.id_cliente', 'INNER'); 
        $datos = $this->where('sist_cliente_regimen_fiscal.id_cliente', $IdCliente); 
        $datos = $this->orderBy('sist_cliente_regimen_fiscal.id_cliente_regimen_fiscal', 'asc')->findAll();

        return $datos;
    }
}