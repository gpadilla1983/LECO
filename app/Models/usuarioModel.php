<?php

namespace App\Models;

use CodeIgniter\Model;

class usuarioModel extends Model{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['id_usuario', 
                                'id_estado_logico',
                                'id_captura', 
                                'id_actualiza', 
                                'f_captura',
                                'f_actualiza',
                                'usuario',
                                'contrasena',
                                'nombre',
                                'primer_apellido',
                                'segundo_apellido',
                                'rfc',
                                'curp',
                                'f_nacimiento',
                                'f_ingreso',
                                'celular',
                                'puesto',
                                'e_mail',
                                'id_perfil',
                                'calle',
                                'no_exterior',
                                'no_interior',
                                'colonia',
                                'id_alcaldia_municipio',
                                'id_entidad_federativa',
                                'id_pais',
                                'codigo_postal',
                                'tel_fijo',
                                'perfil',
                                'estado_logico'
                                
                            ];

    protected $returnType = 'object';



    public function getDatosUsuarios($id_perfil = -1, $id_estadologico = -1, $id_pais = -1, $id_entidad_federativa = -1, $id_alcaldia_municipio = -1)
    {
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY usuario.id_usuario) as row, usuario.*, p.desc_larga as perfil, el.desc_larga as estado_logico, a.desc_larga as alcaldia_municipio, e.desc_larga as entidad_federativa, p.desc_larga as pais');   
        $datos = $this->join('perfil p', 'usuario.id_perfil = p.id_perfil', 'INNER');
        $datos = $this->join('cat_alcaldia_municipio a', 'usuario.id_alcaldia_municipio = a.id_alcaldia_municipio', 'INNER');
        $datos = $this->join('cat_entidad_federativa e', 'usuario.id_entidad_federativa = e.id_entidad_federativa', 'INNER');
        $datos = $this->join('cat_pais pa', 'usuario.id_pais = pa.id_pais', 'INNER');
        $datos = $this->join('estado_logico el', 'usuario.id_estado_logico = el.id_estado_logico', 'INNER');
        $datos = ($id_perfil != -1) ? $this->where('usuario.id_perfil', $id_perfil) : $datos; 
        $datos = ($id_pais != -1) ? $this->where('usuario.id_pais', $id_pais) : $datos; 
        $datos = ($id_entidad_federativa != -1) ? $this->where('usuario.id_entidad_federativa', $id_entidad_federativa) : $datos; 
        $datos = ($id_alcaldia_municipio != -1) ? $this->where('usuario.id_alcaldia_municipio', $id_alcaldia_municipio) : $datos; 
        $datos = ($id_estadologico != -1) ? $this->where('usuario.id_estado_logico', $id_estadologico):''; 
        $datos = $this->orderBy('usuario.id_usuario', 'asc')
                      ->findAll();

        return $datos;
    }
}
