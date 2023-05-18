<?php

namespace App\Controllers;
use App\Models\{actividadEconomicaModel,estadoLogicoModel};

class ActividadEconomicaController extends BaseController
{

    private $miActividadEconomicaModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miActividadEconomicaModel = new actividadEconomicaModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catActividadEconomica/catActividadEconomica', $datos);
        }
        
    }

    public function ObtenerActividadEconomica()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $actividadEconomica = $this->miActividadEconomicaModel->getDatosActividadEconomica($ddl_estatus);

            $i = 0;
            foreach ($actividadEconomica as $actEconomica) {
                array_push($resultado, (array)$actEconomica);
                //$resultado[$i]['row'] = $actEconomica->row;
                $resultado[$i]['id_actividad_economica'] = $actEconomica->id_actividad_economica;
                $resultado[$i]['id_estado_logico'] = $actEconomica->id_estado_logico;
                $resultado[$i]['id_captura'] = $actEconomica->id_captura;
                $resultado[$i]['id_actualiza'] = $actEconomica->id_actualiza;
                $resultado[$i]['f_captura'] = $actEconomica->f_captura; 
                $resultado[$i]['f_actualiza'] = $actEconomica->f_actualiza;
                $resultado[$i]['desc_corta'] = $actEconomica->desc_corta;
                $resultado[$i]['desc_larga'] = $actEconomica->desc_larga; 
                $resultado[$i]['estado_logico'] = $actEconomica->estado_logico;
                $resultado[$i]['captura'] = $actEconomica->n_captura . ' ' . $actEconomica->pa_captura . ' ' . $actEconomica->sa_captura;
                $resultado[$i]['actualiza'] = $actEconomica->n_actualiza . ' ' . $actEconomica->pa_actualiza . ' ' . $actEconomica->sa_actualiza;
                
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarActividadEconomica(' . $actEconomica->id_actividad_economica .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Actividad Económica" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getActividadEconomica($id_actividad_economica)
    {
        header('Content-Type: application/json');

        $actividadEconomica = [];

        if ($id_actividad_economica > 0) {
            $actividadEconomica =  $this->miActividadEconomicaModel->find($id_actividad_economica);
        }
        echo json_encode((array)$actividadEconomica, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_actividad_economica)
    {
        if ($id_actividad_economica != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_actividad_economica'] = $id_actividad_economica;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catActividadEconomica/ModalActividadEconomica', $datos);
    }

    function AgregarActualizarActividadEconomica($id_actividad_economica)
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
        

       

        if ($id_actividad_economica == 0) {

            $estatus = $this->request->getVar('ddl_estatus_actividad_economica');
            $idUsuario = session()->get('id_usuario');

            $this->miActividadEconomicaModel->insert([
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
            if($id_actividad_economica != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_actividad_economica');

                $this->miActividadEconomicaModel->update(
                    $id_actividad_economica,
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