<?php

namespace App\Models;

use CodeIgniter\Model;

class estadoLogicoModel extends Model{
    protected $table = 'estado_logico';
    protected $primaryKey = 'id_estado_logico';
    protected $allowedFields = ['id_estado_logico', 
                                'id_estado_logico_r',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                                
                            ];

    protected $returnType = 'object';

   
}