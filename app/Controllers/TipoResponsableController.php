<?php

namespace App\Controllers;
use App\Models\{tipoResponsableModel,estadoLogicoModel};

class TipoResponsableController extends BaseController
{

    private $miTipoResponsableModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miTipoResponsableModel = new tipoResponsableModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catTipoResponsable/catTipoResponsable', $datos);
        }
        
    }

    public function ObtenerTipoResponsable()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $tipoResponsable = $this->miTipoResponsableModel->getDatosTipoResponsable($ddl_estatus);

            $i = 0;
            foreach ($tipoResponsable as $tipResponsable) {
                array_push($resultado, (array)$tipResponsable);
                //$resultado[$i]['row'] = $tipResponsable->row;
                $resultado[$i]['id_tipo_responsable'] = $tipResponsable->id_tipo_responsable;
                $resultado[$i]['id_estado_logico'] = $tipResponsable->id_estado_logico;
                $resultado[$i]['id_captura'] = $tipResponsable->id_captura;
                $resultado[$i]['id_actualiza'] = $tipResponsable->id_actualiza;
                $resultado[$i]['f_captura'] = $tipResponsable->f_captura; 
                $resultado[$i]['f_actualiza'] = $tipResponsable->f_actualiza;
                $resultado[$i]['desc_corta'] = $tipResponsable->desc_corta;
                $resultado[$i]['desc_larga'] = $tipResponsable->desc_larga; 
                $resultado[$i]['estado_logico'] = $tipResponsable->estado_logico;
                $resultado[$i]['captura'] = $tipResponsable->n_captura . ' ' . $tipResponsable->pa_captura . ' ' . $tipResponsable->sa_captura;
                $resultado[$i]['actualiza'] = $tipResponsable->n_actualiza . ' ' . $tipResponsable->pa_actualiza . ' ' . $tipResponsable->sa_actualiza;
                 
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarTipoResponsable(' . $tipResponsable->id_tipo_responsable .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Tipo Responsable" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getTipoResponsable($id_tipo_responsable)
    {
        header('Content-Type: application/json');

        $tipoResponsable = [];

        if ($id_tipo_responsable > 0) {
            $tipoResponsable =  $this->miTipoResponsableModel->find($id_tipo_responsable);
        }
        echo json_encode((array)$tipoResponsable, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_tipo_responsable)
    {
        if ($id_tipo_responsable != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_tipo_responsable'] = $id_tipo_responsable;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catTipoResponsable/ModalTipoResponsable', $datos);
    }

    function AgregarActualizarTipoResponsable($id_tipo_responsable)
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
        

       

        if ($id_tipo_responsable == 0) {

            $estatus = $this->request->getVar('ddl_estatus_tipo_responsable');
            $idUsuario = session()->get('id_usuario');

            $this->miTipoResponsableModel->insert([
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
            if($id_tipo_responsable != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_tipo_responsable');

                $this->miTipoResponsableModel->update(
                    $id_tipo_responsable,
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