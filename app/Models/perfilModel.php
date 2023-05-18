<?php

namespace App\Models;

use CodeIgniter\Model;

class perfilModel extends Model{
    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';
    protected $allowedFields = ['id_perfil', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura', 
                                'f_actualiza',
                                'desc_corta',
                                'desc_larga'
                                
                            ];

    protected $returnType = 'object';

   
}