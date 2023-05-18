<?php

namespace App\Controllers;
use App\Models\{FilesClienteModel};

class FilesClienteController extends BaseController
{

    private $miFileCliente;

    function __construct()
    {
        $this->miFileCliente = new FilesClienteModel(); 
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            // $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('FilesCliente/FilesCliente');
        } 
    }

    public function GuardarExpediente()
    {
        header('Content-Type: application/json');
        $id_estado_logico = $_POST["id_estado_logico"];
        $id_file_cliente = $_POST["id_file_cliente"];
        $id_estado_caso_legal = $_POST["id_estado_caso_legal"];
        $id_tipo_documento = $_POST["id_tipo_documento"];
        $f_docto = $_POST["f_docto"];
        $f_seguimiento = $_POST["f_seguimiento"];
        $id_cliente_caso_legal = $_POST["id_cliente_caso_legal"];
        $id_cliente = $_POST["id_cliente"];
        $Asunto = $_POST["Asunto"];
        $Archivo = $_POST["Archivo"];

        if ($id_file_cliente == ""){
            $id_file_cliente = intval(0);
        }else{
            $id_file_cliente = intval($id_file_cliente);
        }

        $reglas = [
            'f_seguimiento' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Fecha de Seguimiento es obligatorio.'
                ]
            ],
            'f_docto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Fecha del Documento es obligatorio.'
                ]
            ],
            'Asunto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Asunto del Documento es obligatorio.'
                ]
            ],
            'Archivo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Archivo es obligatorio.'
                ]
            ],
        
        ];

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $id_estado_logico == 0 || $id_estado_caso_legal == 0 || $id_tipo_documento == 0) {
            $errores = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            if ($id_estado_logico == 0) {
                $errores = $errores . ' ' . 'El campo Estatus es obligatorio.' . "\n";
            }
            if ($id_estado_caso_legal == 0) {
                $errores = $errores . ' ' . 'El campo Seguimiento es obligatorio.' . "\n";
            }
            if ($id_tipo_documento == 0) {
                $errores = $errores . ' ' . 'El campo Tipo de Documento es obligatorio.' . "\n";
            }
            echo $errores;
            return;
        }
       
        if ($id_file_cliente == 0){

            $id_file_cliente = $this->miFileCliente->insert([
                'id_cliente'            => $id_cliente,
                'file_asunto'           => $Asunto,
                'file_content'          => $Archivo,
                'id_estado_logico'      => $id_estado_logico,   
                'id_captura'            => session()->get('id_usuario'),
                'f_captura'             => date('Y-m-d H:i:s'),
                'id_cliente_caso_legal' => $id_cliente_caso_legal,
                'id_estado_caso_legal'  => $id_estado_caso_legal,
                'id_tipo_documento'     => $id_tipo_documento,
                'f_docto'               => $f_docto,
                'f_seguimiento'         => $f_seguimiento
            
            ]);

            if ($id_file_cliente >= 1) {
                echo 1;
            } else {
                echo 0;
            }
        }else{
            
            $id_file_cliente = $this->miFileCliente->update(
                $id_file_cliente,
                [
                    'id_cliente'            => $id_cliente, 
                    'file_asunto'           => $Asunto,
                    'file_content'          => $Archivo,
                    'id_estado_logico'      => $id_estado_logico,
                    'id_actualiza'            => session()->get('id_usuario'),
                    'f_actualiza'             => date('Y-m-d H:i:s'),
                    'id_cliente_caso_legal' => $id_cliente_caso_legal,
                    'id_estado_caso_legal'  => $id_estado_caso_legal,
                    'id_tipo_documento'     => $id_tipo_documento,
                    'f_docto'               => $f_docto,
                    'f_seguimiento'         => $f_seguimiento
            
                ]
            );

            if ($id_file_cliente >= 1) {
                echo 1;
            } else {
                echo 0;
            }
        }   
    }

    public function ActualizarExpedienteSinArchivo()
    {
        header('Content-Type: application/json');
        $id_estado_logico = $_POST["id_estado_logico"];
        $id_file_cliente = $_POST["id_file_cliente"];
        $id_estado_caso_legal = $_POST["id_estado_caso_legal"];
        $id_tipo_documento = $_POST["id_tipo_documento"];
        $f_docto = $_POST["f_docto"];
        $f_seguimiento = $_POST["f_seguimiento"];
        $id_cliente_caso_legal = $_POST["id_cliente_caso_legal"];
        $id_cliente = $_POST["id_cliente"];
        $Asunto = $_POST["Asunto"];

        if ($id_file_cliente == ""){
            $id_file_cliente = intval(0);
        }else{
            $id_file_cliente = intval($id_file_cliente);
        }

        if ($f_docto == ""){
            $f_docto = null;
        }
       
        $reglas = [
            'f_seguimiento' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Fecha de Seguimiento es obligatorio.'
                ]
            ],
            
            'Asunto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Asunto del Documento es obligatorio.'
                ]
            ],
        
        ];

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $id_estado_logico == 0 || $id_estado_caso_legal == 0 || $id_tipo_documento == 0) {
            $errores = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            if ($id_estado_logico == 0) {
                $errores = $errores . ' ' . 'El campo Estatus es obligatorio.' . "\n";
            }
            if ($id_estado_caso_legal == 0) {
                $errores = $errores . ' ' . 'El campo Seguimiento es obligatorio.' . "\n";
            }
            if ($id_tipo_documento == 0) {
                $errores = $errores . ' ' . 'El campo Tipo de Documento es obligatorio.' . "\n";
            }
            echo $errores;
            return;
        }
        
        if($id_file_cliente == 0){
                
            $id_file_cliente = $this->miFileCliente->insert([
                'id_cliente'            => $id_cliente,
                'file_asunto'           => $Asunto,
                'id_estado_logico'      => $id_estado_logico,
                'id_captura'            => session()->get('id_usuario'),
                'f_captura'             => date('Y-m-d H:i:s'),
                'id_cliente_caso_legal' => $id_cliente_caso_legal,
                'id_estado_caso_legal'  => $id_estado_caso_legal,
                'id_tipo_documento'     => $id_tipo_documento,
                'f_docto'               => $f_docto,
                'f_seguimiento'         => $f_seguimiento
            
            ]);

        }else {
            $id_file_cliente = $this->miFileCliente->update(
                $id_file_cliente,
                [
                    'id_cliente'            => $id_cliente,
                    'file_asunto'           => $Asunto,
                    'id_estado_logico'      => $id_estado_logico,
                    'id_actualiza'           => session()->get('id_usuario'),
                    'f_actualiza'            => date('Y-m-d H:i:s'),
                    'id_cliente_caso_legal' => $id_cliente_caso_legal,
                    'id_estado_caso_legal'  => $id_estado_caso_legal,
                    'id_tipo_documento'     => $id_tipo_documento,
                    'f_docto'               => $f_docto,
                    'f_seguimiento'         => $f_seguimiento
            
                ]
            );
        }
        if ($id_file_cliente >= 1) {
            echo 1;
        } else {
            echo 0;
        }  
    }

    public function ObtenerExpedientes(){
        header('Content-Type: application/json');

        $resultado = [];

        $id_cliente_caso_legal = $_POST["id_cliente_caso_legal"];
        $Asunto = $_POST["Asunto"];

        if (!$this->request->getMethod() == 'POST') {
            $errores = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            echo $errores;
            return;
        }

        if ($this->request->getMethod() == 'post') {

            $Files = $this->miFileCliente->getDatosFiles($id_cliente_caso_legal, $Asunto);

            $i = 0;
            foreach ($Files as $file) {
                array_push($resultado, (array)$file);
                $resultado[$i]['row']                   = $file->row;
                $resultado[$i]['file_asunto']           = $file->file_asunto;
                $resultado[$i]['id_cliente']            = $file->id_cliente;
                $resultado[$i]['id_cliente_caso_legal'] = $file->id_cliente_caso_legal;          
                $resultado[$i]['id_estado_caso_legal']  = $file->id_estado_caso_legal; 
                if ($file->id_tipo_documento == 1){
                    $resultado[$i]['id_tipo_documento']  = 'Interno';
                }else if($file->id_tipo_documento == 2){
                    $resultado[$i]['id_tipo_documento']  = 'Interno y Externo';
                }else{
                    $resultado[$i]['id_tipo_documento']  = '';
                }
                $resultado[$i]['f_docto']               = $file->f_docto;
                $resultado[$i]['f_seguimiento']         = $file->f_seguimiento;
                $resultado[$i]['estado_caso_legal']     = $file->estado_caso_legal;
                $resultado[$i]['Estatus']               = $file->estado_logico;
                
                if($file->file_content == null || $file->file_content == ""){
                    $resultado[$i]['acciones'] = '<label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times"></i></label>&nbsp;&nbsp;&nbsp;
                                                  <button class="btn btn-primary btn-sm" onclick="EditarDocumento(' . $file->id_file_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar archivo" ><i class="fa fa-pencil"></i></button>';
                }else{
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="Verdocumento(' . $file->id_file_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar archivo" ><i class="fa fa-file-pdf"></i></button>
                                                  <button class="btn btn-primary btn-sm" onclick="EditarDocumento(' . $file->id_file_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar archivo" ><i class="fa fa-pencil"></i></button>';
                }      
                $i++;
            }

        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }


    public function ObtenerExpedientesExternos(){
        header('Content-Type: application/json');

        $resultado = [];

        $id_cliente_caso_legal = $_POST["id_cliente_caso_legal"];
        $Asunto = $_POST["Asunto"];

        if (!$this->request->getMethod() == 'POST') {
            $errores = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            echo $errores;
            return;
        }

        $usuario = session()->get('id_usuario');

        if(session()->get('id_perfil') == 1){
            $usuario = "-1";
        }

        if ($this->request->getMethod() == 'post') {

            $Files = $this->miFileCliente->getDatosFilesExternos($id_cliente_caso_legal, $Asunto, $usuario);

            $i = 0;
            foreach ($Files as $file) {
                array_push($resultado, (array)$file);
                $resultado[$i]['row']                   = $file->row;
                $resultado[$i]['file_asunto']           = $file->file_asunto;
                $resultado[$i]['id_cliente']            = $file->id_cliente;
                $resultado[$i]['id_cliente_caso_legal'] = $file->id_cliente_caso_legal;          
                $resultado[$i]['id_estado_caso_legal']  = $file->id_estado_caso_legal; 
                if ($file->id_tipo_documento == 1){
                    $resultado[$i]['id_tipo_documento']  = 'Interno';
                }else if($file->id_tipo_documento == 2){
                    $resultado[$i]['id_tipo_documento']  = 'Interno y Externo';
                }else{
                    $resultado[$i]['id_tipo_documento']  = '';
                }
                $resultado[$i]['f_docto']               = $file->f_docto;
                $resultado[$i]['f_seguimiento']         = $file->f_seguimiento;
                $resultado[$i]['estado_caso_legal']     = $file->estado_caso_legal;
                $resultado[$i]['Estatus']               = $file->estado_logico;
                
                if($file->file_content == null || $file->file_content == ""){
                    $resultado[$i]['acciones'] = '<label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-times"></i></label>&nbsp;&nbsp;&nbsp;';
                }else{
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="Verdocumento(' . $file->id_file_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar archivo" ><i class="fa fa-file-pdf"></i></button>';
                }      
                $i++;
            }

        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }



    public function ObtenerFileContent($id_file_cliente)
    {
        header('Content-Type: application/json');

        if ($id_file_cliente > 0) {
            $file =  $this->miFileCliente->find($id_file_cliente);
        }

        echo json_encode((array)$file, JSON_UNESCAPED_UNICODE); 
    }

    function ObtenerDocumento($id_file_cliente)
    {
        header('Content-Type: application/json');

        $documento = [];

        if ($id_file_cliente > 0) {
            $documento =  $this->miFileCliente->find($id_file_cliente);
        }
        echo json_encode((array)$documento, JSON_UNESCAPED_UNICODE);
    }   
}