<?php

namespace App\Controllers;
use App\Models\{catTipoCasoLegalModel,estadoLogicoModel};

class TipoCasoLegalController extends BaseController
{

    private $miTipoCasoLegalModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miTipoCasoLegalModel = new catTipoCasoLegalModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catTipoCasoLegal/catTipoCasoLegal', $datos);
        }
        
    }

    public function ObtenerTipoCasoLegal()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $tipoCasoLegal = $this->miTipoCasoLegalModel->getDatosTipoCasoLegal($ddl_estatus);

            $i = 0;
            foreach ($tipoCasoLegal as $TCasoLegal) {
                array_push($resultado, (array)$TCasoLegal);
                //$resultado[$i]['row'] = $TCasoLegal->row;
                $resultado[$i]['id_tipo_caso_legal'] = $TCasoLegal->id_tipo_caso_legal;
                $resultado[$i]['id_estado_logico'] = $TCasoLegal->id_estado_logico;
                $resultado[$i]['id_captura'] = $TCasoLegal->id_captura;
                $resultado[$i]['id_actualiza'] = $TCasoLegal->id_actualiza;
                $resultado[$i]['f_captura'] = $TCasoLegal->f_captura; 
                $resultado[$i]['f_actualiza'] = $TCasoLegal->f_actualiza;
                $resultado[$i]['desc_corta'] = $TCasoLegal->desc_corta;
                $resultado[$i]['desc_larga'] = $TCasoLegal->desc_larga; 
                $resultado[$i]['estado_logico'] = $TCasoLegal->estado_logico;
                $resultado[$i]['captura'] = $TCasoLegal->n_captura . ' ' . $TCasoLegal->pa_captura . ' ' . $TCasoLegal->sa_captura;
                $resultado[$i]['actualiza'] = $TCasoLegal->n_actualiza . ' ' . $TCasoLegal->pa_actualiza . ' ' . $TCasoLegal->sa_actualiza;
                
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarTipoCasoLegal(' . $TCasoLegal->id_tipo_caso_legal .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Tipo Caso Legal" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getTipoCasoLegal($id_tipo_caso_legal)
    {
        header('Content-Type: application/json');

        $tipoCasoLegal = [];

        if ($id_tipo_caso_legal > 0) {
            $tipoCasoLegal =  $this->miTipoCasoLegalModel->find($id_tipo_caso_legal);
        }
        echo json_encode((array)$tipoCasoLegal, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_tipo_caso_legal)
    {
        if ($id_tipo_caso_legal != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_tipo_caso_legal'] = $id_tipo_caso_legal;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catTipoCasoLegal/ModalTipoCasoLegal', $datos);
    }

    function AgregarActualizarTipoCasoLegal($id_tipo_caso_legal)
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
        

       

        if ($id_tipo_caso_legal == 0) {

            $estatus = $this->request->getVar('ddl_estatus_tipo_caso_legal');
            $idUsuario = session()->get('id_usuario');

            $this->miTipoCasoLegalModel->insert([
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
            if($id_tipo_caso_legal != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_tipo_caso_legal');

                $this->miTipoCasoLegalModel->update(
                    $id_tipo_caso_legal,
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