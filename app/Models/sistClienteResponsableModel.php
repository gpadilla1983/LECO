<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteResponsableModel extends Model{
    protected $table = 'sist_cliente_tresponsable';
    protected $primaryKey = 'id_cliente_tresponsable';
    protected $allowedFields = ['id_cliente_tresponsable', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_cliente',
                                'id_responsable',
                                'id_tipo_responsable',

                            ];

    protected $returnType = 'object';

   
}