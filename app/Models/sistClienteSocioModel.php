<?php

namespace App\Models;

use CodeIgniter\Model;

class sistClienteSocioModel extends Model{
    protected $table = 'sist_cliente_socio';
    protected $primaryKey = 'id_cliente_socio';
    protected $allowedFields = ['id_cliente_socio', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'id_cliente',
                                'id_socio'
                            ];

    protected $returnType = 'object';
       
}