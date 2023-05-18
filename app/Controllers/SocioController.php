<?php

namespace App\Controllers;
use App\Models\{sistSocioModel,estadoLogicoModel};

class SocioController extends BaseController
{

    private $miSocioModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miSocioModel = new sistSocioModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catSocio/catSocio', $datos);
        }
        
    }

    public function ObtenerSocio()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $socio = $this->miSocioModel->getDatosSocio($ddl_estatus);

            $i = 0;
            foreach ($socio as $socios) {
                array_push($resultado, (array)$socios);
                //$resultado[$i]['row'] = $socios->row;
                $resultado[$i]['id_socio'] = $socios->id_socio;
                $resultado[$i]['id_estado_logico'] = $socios->id_estado_logico;
                $resultado[$i]['id_captura'] = $socios->id_captura;
                $resultado[$i]['id_actualiza'] = $socios->id_actualiza;
                $resultado[$i]['f_captura'] = $socios->f_captura; 
                $resultado[$i]['f_actualiza'] = $socios->f_actualiza;
                $resultado[$i]['nombre'] = $socios->nombre; 
                $resultado[$i]['primer_apellido'] = $socios->primer_apellido;
                $resultado[$i]['segundo_apellido'] = $socios->segundo_apellido;
                $resultado[$i]['rfc'] = $socios->rfc;
                $resultado[$i]['curp'] = $socios->curp;
                $resultado[$i]['e_mail'] = $socios->e_mail;
                $resultado[$i]['estado_logico'] = $socios->estado_logico;
                $resultado[$i]['nombre_completo'] = $socios->nombre . ' ' . $socios->primer_apellido . ' ' . $socios->segundo_apellido;
                $resultado[$i]['captura'] = $socios->n_captura . ' ' . $socios->pa_captura . ' ' . $socios->sa_captura;
                $resultado[$i]['actualiza'] = $socios->n_actualiza . ' ' . $socios->pa_actualiza . ' ' . $socios->sa_actualiza;
               
                if (session()->get('id_perfil') == 1){  
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarSocio(' . $socios->id_socio .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Socio" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getSocio($id_socio)
    {
        header('Content-Type: application/json');

        $socio = [];

        if ($id_socio > 0) {
            $socio =  $this->miSocioModel->find($id_socio);
        }
        echo json_encode((array)$socio, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_socio)
    {
        if ($id_socio != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_socio'] = $id_socio;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catSocio/ModalSocio', $datos);
    }

    function AgregarActualizarSocio($id_socio)
    {
            $reglas = [
                'tbx_nombre_socio'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre es obligatorio.'
                    ]
                ],
                'tbx_primer_apellido'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Primer apellido es obligatorio.'
                    ]
                ],
                'tbx_segundo_apellido'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Segundo apellido es obligatorio.'
                    ]
                ],
                'tbx_email_socio'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo correo electrónico es obligatorio.'
                                             
                    ]
                ],
                'tbx_rfc_socio'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo RFC es obligatorio.'
                    ]
                ],
                'tbx_curp_socio'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo CURP es obligatorio.'
                    ]
                ],
            ];  
            

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas)) {
            $errores  = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            echo $errores;
            return;
        }
        

        if ($id_socio == 0) {

            $estatus = $this->request->getVar('ddl_estatus_socio');
            $idUsuario = session()->get('id_usuario');
            
            $rfc = $this->request->getVar('tbx_rfc_socio');
            $curp = $this->request->getVar('tbx_curp_socio');

            $IdSocio = $this->miSocioModel->select('id_socio')->where('rfc', $rfc)->find();
            $IdSocio1 = $this->miSocioModel->select('id_socio')->where('curp', $curp)->find();
            if ($IdSocio != null || $IdSocio1 != null) {
                echo 0;
                return;
            }else{
                $this->miSocioModel->insert([
                    'nombre'            => $this->request->getVar('tbx_nombre_socio'),
                    'primer_apellido'   => $this->request->getVar('tbx_primer_apellido'),
                    'segundo_apellido'  => $this->request->getVar('tbx_segundo_apellido'),
                    'rfc'               => $this->request->getVar('tbx_rfc_socio'),
                    'curp'              => $this->request->getVar('tbx_curp_socio'),
                    'e_mail'            => $this->request->getVar('tbx_email_socio'),
                    'id_estado_logico'  => $estatus,
                    'id_captura'        => $idUsuario,
                    "id_actualiza"      => null,
                    "f_captura"         => date('Y-m-d H:i:s'),
                    "f_actualiza"       => null
                ]);
                echo 1;
            }
        } else{
            if($id_socio != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_socio');

                $this->miSocioModel->update(
                        $id_socio,
                        [
                            'nombre'            => $this->request->getVar('tbx_nombre_socio'),
                            'primer_apellido'   => $this->request->getVar('tbx_primer_apellido'),
                            'segundo_apellido'  => $this->request->getVar('tbx_segundo_apellido'),
                            'rfc'               => $this->request->getVar('tbx_rfc_socio'),
                            'curp'              => $this->request->getVar('tbx_curp_socio'),
                            'e_mail'            => $this->request->getVar('tbx_email_socio'),
                            'id_estado_logico'  => $estatus,
                            "id_actualiza"      => $idUsuario,
                            "f_actualiza"       => date('Y-m-d H:i:s')
                        ]
                    );
    
                    echo 1;
                
            }else{
                echo 0;
            }
        }

       
    }

}