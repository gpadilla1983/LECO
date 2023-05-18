<?php

namespace App\Models;

use CodeIgniter\Model;

class menuDinamicoModel extends Model{
    protected $table = 'vw_usuario_menu';
    protected $allowedFields = ['id_usuario',
                                'id_menu',
                                'desc_larga',
                                'tipo_menu', 
                                'orden_n1', 
                                'orden_n2',
                                'ruta',
                                'icono'
                            ];
    protected $returnType = 'object';

    public function getDatosMenuDinamico($id_usuario)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER vw_usuario_menu.id_usuario) as row, vw_usuario_menu.*');   
        $datos = $this->where('vw_usuario_menu.id_usuario', $id_usuario); 

        return $datos;
    }
}
