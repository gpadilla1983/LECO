<?php

namespace App\Controllers;
use App\Models\{catEstadoCasoLegalModel,estadoLogicoModel};

class EstadoCasoLegalController extends BaseController
{

    private $miEstadoCasoLegalModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miEstadoCasoLegalModel = new catEstadoCasoLegalModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catEstadoCasoLegal/catEstadoCasoLegal', $datos);
        }
        
    }

    public function ObtenerEstadoCasoLegal()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $estadoCasoLegal = $this->miEstadoCasoLegalModel->getDatosEstadoCasoLegal($ddl_estatus);

            $i = 0;
            foreach ($estadoCasoLegal as $ECasoLegal) {
                array_push($resultado, (array)$ECasoLegal);
                //$resultado[$i]['row'] = $ECasoLegal->row;
                $resultado[$i]['id_estado_caso_legal'] = $ECasoLegal->id_estado_caso_legal;
                $resultado[$i]['id_estado_logico'] = $ECasoLegal->id_estado_logico;
                $resultado[$i]['id_captura'] = $ECasoLegal->id_captura;
                $resultado[$i]['id_actualiza'] = $ECasoLegal->id_actualiza;
                $resultado[$i]['f_captura'] = $ECasoLegal->f_captura; 
                $resultado[$i]['f_actualiza'] = $ECasoLegal->f_actualiza;
                $resultado[$i]['desc_corta'] = $ECasoLegal->desc_corta;
                $resultado[$i]['desc_larga'] = $ECasoLegal->desc_larga; 
                $resultado[$i]['estado_logico'] = $ECasoLegal->estado_logico;
                $resultado[$i]['captura'] = $ECasoLegal->n_captura . ' ' . $ECasoLegal->pa_captura . ' ' . $ECasoLegal->sa_captura;
                $resultado[$i]['actualiza'] = $ECasoLegal->n_actualiza . ' ' . $ECasoLegal->pa_actualiza . ' ' . $ECasoLegal->sa_actualiza;
                
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarEstadoCasoLegal(' . $ECasoLegal->id_estado_caso_legal .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Estado Caso Legal" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getEstadoCasoLegal($id_estado_caso_legal)
    {
        header('Content-Type: application/json');

        $estadoCasoLegal = [];

        if ($id_estado_caso_legal > 0) {
            $estadoCasoLegal =  $this->miEstadoCasoLegalModel->find($id_estado_caso_legal);
        }
        echo json_encode((array)$estadoCasoLegal, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_estado_caso_legal)
    {
        if ($id_estado_caso_legal != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_estado_caso_legal'] = $id_estado_caso_legal;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catEstadoCasoLegal/ModalEstadoCasoLegal', $datos);
    }

    function AgregarActualizarEstadoCasoLegal($id_estado_caso_legal)
    {
            $reglas = [
                'tbx_desc_corta'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Descripción Corta es obligatorio.'
                    ]
                ],
                'tbx_desc_larga'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Descripción Larga es obligatorio.'
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
        

       

        if ($id_estado_caso_legal == 0) {

            $estatus = $this->request->getVar('ddl_estatus_estado_caso_legal');
            $idUsuario = session()->get('id_usuario');

            $this->miEstadoCasoLegalModel->insert([
                'desc_corta'        => $this->request->getVar('tbx_desc_corta'),
                'desc_larga'        => $this->request->getVar('tbx_desc_larga'),
                'id_estado_logico'  => $estatus,
                'id_captura'        => $idUsuario,
                "id_actualiza"      => null,
                "f_captura"         => date('Y-m-d H:i:s'),
                "f_actualiza"       => null
            ]);

            echo 1;

        } else{
            if($id_estado_caso_legal != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_estado_caso_legal');

                $this->miEstadoCasoLegalModel->update(
                    $id_estado_caso_legal,
                    [
                        'desc_corta'        => $this->request->getVar('tbx_desc_corta'),
                        'desc_larga'        => $this->request->getVar('tbx_desc_larga'),
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