<?php

namespace App\Controllers;
use App\Models\{sistResponsableModel,estadoLogicoModel};

class ResponsableController extends BaseController
{

    private $miResponsableModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miResponsableModel = new sistResponsableModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catResponsable/catResponsable', $datos);
        }
        
    }

    public function ObtenerResponsable()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $responsable = $this->miResponsableModel->getDatosResponsable($ddl_estatus);

            $i = 0;
            foreach ($responsable as $resp) {
                array_push($resultado, (array)$resp);
                //$resultado[$i]['row'] = $resp->row;
                $resultado[$i]['id_responsable'] = $resp->id_responsable;
                $resultado[$i]['id_estado_logico'] = $resp->id_estado_logico;
                $resultado[$i]['id_captura'] = $resp->id_captura;
                $resultado[$i]['id_actualiza'] = $resp->id_actualiza;
                $resultado[$i]['f_captura'] = $resp->f_captura; 
                $resultado[$i]['f_actualiza'] = $resp->f_actualiza;
                $resultado[$i]['nombre'] = $resp->nombre; 
                $resultado[$i]['primer_apellido'] = $resp->primer_apellido;
                $resultado[$i]['segundo_apellido'] = $resp->segundo_apellido;
                $resultado[$i]['rfc'] = $resp->rfc;
                $resultado[$i]['curp'] = $resp->curp;
                $resultado[$i]['e_mail'] = $resp->e_mail;
                $resultado[$i]['estado_logico'] = $resp->estado_logico;
                $resultado[$i]['nombre_completo'] = $resp->nombre . ' ' . $resp->primer_apellido . ' ' . $resp->segundo_apellido;
                $resultado[$i]['captura'] = $resp->n_captura . ' ' . $resp->pa_captura . ' ' . $resp->sa_captura;
                $resultado[$i]['actualiza'] = $resp->n_actualiza . ' ' . $resp->pa_actualiza . ' ' . $resp->sa_actualiza;
               
                if (session()->get('id_perfil') == 1){  
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarResponsable(' . $resp->id_responsable .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Responsable" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getResponsable($id_responsable)
    {
        header('Content-Type: application/json');

        $responsable = [];

        if ($id_responsable > 0) {
            $responsable =  $this->miResponsableModel->find($id_responsable);
        }
        echo json_encode((array)$responsable, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_responsable)
    {
        if ($id_responsable != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_responsable'] = $id_responsable;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catResponsable/ModalResponsable', $datos);
    }

    function AgregarActualizarResponsable($id_responsable)
    {
        
        $reglas = [
                'tbx_nombre_responsable'  => [
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
                'tbx_email_responsable'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo correo electrónico es obligatorio.'
                    ]
                ],
                'tbx_rfc_responsable'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo RFC es obligatorio.'
                    ]
                ],
                'tbx_curp_responsable'  => [
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
        
        if ($id_responsable == 0) {

            $estatus = $this->request->getVar('ddl_estatus_responsable');
            $idUsuario = session()->get('id_usuario');

            $rfc = $this->request->getVar('tbx_rfc_responsable');
            $curp = $this->request->getVar('tbx_curp_responsable');

            $IdResponsable = $this->miResponsableModel->select('id_responsable')->where('rfc', $rfc)->find();
            $IdResponsable1 = $this->miResponsableModel->select('id_responsable')->where('curp', $curp)->find();
            if ($IdResponsable != null || $IdResponsable1 != null) {
                echo 0;
                return;
            }else {
                $this->miResponsableModel->insert([
                    'nombre'            => $this->request->getVar('tbx_nombre_responsable'),
                    'primer_apellido'   => $this->request->getVar('tbx_primer_apellido'),
                    'segundo_apellido'  => $this->request->getVar('tbx_segundo_apellido'),
                    'rfc'               => $this->request->getVar('tbx_rfc_responsable'),
                    'curp'              => $this->request->getVar('tbx_curp_responsable'),
                    'e_mail'            => $this->request->getVar('tbx_email_responsable'),
                    'id_estado_logico'  => $estatus,
                    'id_captura'        => $idUsuario,
                    "id_actualiza"      => null,
                    "f_captura"         => date('Y-m-d H:i:s'),
                    "f_actualiza"       => null
                ]);
                echo 1;
            }
        } else{
            if($id_responsable != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_responsable');

                $this->miResponsableModel->update(
                        $id_responsable,
                        [
                            'nombre'            => $this->request->getVar('tbx_nombre_responsable'),
                            'primer_apellido'   => $this->request->getVar('tbx_primer_apellido'),
                            'segundo_apellido'  => $this->request->getVar('tbx_segundo_apellido'),
                            'rfc'               => $this->request->getVar('tbx_rfc_responsable'),
                            'curp'              => $this->request->getVar('tbx_curp_responsable'),
                            'e_mail'            => $this->request->getVar('tbx_email_responsable'),
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