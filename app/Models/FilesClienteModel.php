<?php

namespace App\Models;

use CodeIgniter\Model;

class FilesClienteModel extends Model{
    protected $table = 'sist_files_cliente';
    protected $primaryKey = 'id_file_cliente';
    protected $allowedFields = ['id_file_cliente', 
                                'id_cliente', 
                                'file_asunto', 
                                'file_content',
                                'id_captura',
                                'f_captura',
                                'id_actualiza',
                                'f_actualiza',
                                'id_estado_logico', 
                                'id_cliente_caso_legal', 
                                'id_estado_caso_legal',
                                'id_tipo_documento',
                                'f_docto',
                                'f_seguimiento'
                                ];
    protected $returnType     = 'object';

    public function getDatosFiles($id_cliente_caso_legal = -1, $Asunto = -1)
    {

        if($Asunto == ""){
            $Asunto = -1;
        }
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_files_cliente.f_seguimiento) as row, sist_files_cliente.*, 
        el.desc_larga as estado_logico, ecl.desc_larga as estado_caso_legal');   
        $datos = $this->join('estado_logico el', 'sist_files_cliente.id_estado_logico = el.id_estado_logico', 'INNER');
        $datos = $this->join('cat_estado_caso_legal ecl', 'sist_files_cliente.id_estado_caso_legal = ecl.id_estado_caso_legal', 'INNER');
        $datos = ($id_cliente_caso_legal != -1) ? $this->where('sist_files_cliente.id_cliente_caso_legal', $id_cliente_caso_legal) : $datos; 
        //$datos = ($Asunto != -1) ? $this->where('sist_files_cliente.file_asunto', $Asunto): $datos; 
        $datos = $this->orderBy('sist_files_cliente.id_file_cliente', 'asc')
                      ->findAll();

        return $datos;
    }

    public function getDatosFilesExternos($id_cliente_caso_legal = -1, $Asunto = -1, $usuario = -1)
    {

        if($Asunto == ""){
            $Asunto = -1;
        }
      
        $datos = $this->select('ROW_NUMBER () OVER (ORDER BY sist_files_cliente.id_file_cliente) as row, sist_files_cliente.*, 
        el.desc_larga as estado_logico, ecl.desc_larga as estado_caso_legal');   
        $datos = $this->join('estado_logico el', 'sist_files_cliente.id_estado_logico = el.id_estado_logico', 'INNER');
        $datos = $this->join('cat_estado_caso_legal ecl', 'sist_files_cliente.id_estado_caso_legal = ecl.id_estado_caso_legal', 'INNER');
        $datos = ($id_cliente_caso_legal != -1) ? $this->where('sist_files_cliente.id_cliente_caso_legal', $id_cliente_caso_legal) : $datos; 
        //$datos = ($Asunto != -1) ? $this->where('sist_files_cliente.file_asunto', $Asunto): $datos; 
        $datos = ($usuario != -1) ? $this->where('sist_files_cliente.id_estado_logico', 1) : $datos; 
        $datos = ($usuario != -1) ? $this->where('sist_files_cliente.id_tipo_documento', 2) : $datos; 
       
        $datos = $this->orderBy('sist_files_cliente.id_file_cliente', 'asc')
                      ->findAll();

        return $datos;
    }



}









