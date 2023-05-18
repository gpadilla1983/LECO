<?php

namespace App\Controllers;
use App\Models\{catEntidadFederativaModel,estadoLogicoModel,catAlcaldiaMunicipioModel};

class AlcaldiaMunicipioController extends BaseController
{

    private $miEstadoLogico;
    private $miAlcaldiaMunicipio;
    private $miEntidadFederativa;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miAlcaldiaMunicipio = new catAlcaldiaMunicipioModel();
        $this->miEntidadFederativa = new catEntidadFederativaModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
            return view('catAlcaldiaMunicipio/catAlcaldiaMunicipio', $datos);
        }
        
    }

    public function ObtenerAlcaldiaMun()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $AlcaldiaMunicipio = $this->miAlcaldiaMunicipio->getDatosAlcadiaMun($ddl_estatus);

            $i = 0;
            foreach ($AlcaldiaMunicipio as $alcaldiaMun) {
                array_push($resultado, (array)$alcaldiaMun);
                //$resultado[$i]['row'] = $notpublica->row;
                $resultado[$i]['id_alcaldia_municipio'] = $alcaldiaMun->id_alcaldia_municipio;
                $resultado[$i]['id_estado_logico'] = $alcaldiaMun->id_estado_logico;
                $resultado[$i]['id_captura'] = $alcaldiaMun->id_captura;
                $resultado[$i]['id_actualiza'] = $alcaldiaMun->id_actualiza;
                $resultado[$i]['f_captura'] = $alcaldiaMun->f_captura; 
                $resultado[$i]['f_actualiza'] = $alcaldiaMun->f_actualiza;
                $resultado[$i]['desc_corta'] = $alcaldiaMun->desc_corta;
                $resultado[$i]['desc_larga'] = $alcaldiaMun->desc_larga;
                $resultado[$i]['id_entidad_federativa'] = $alcaldiaMun->id_entidad_federativa;
                $resultado[$i]['estado_logico'] = $alcaldiaMun->estado_logico;
                $resultado[$i]['entidad_federativa'] = $alcaldiaMun->entidad_federativa;
                $resultado[$i]['captura'] = $alcaldiaMun->n_captura . ' ' . $alcaldiaMun->pa_captura . ' ' . $alcaldiaMun->sa_captura;
                $resultado[$i]['actualiza'] = $alcaldiaMun->n_actualiza . ' ' . $alcaldiaMun->pa_actualiza . ' ' . $alcaldiaMun->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarAlcaldiaMun(' . $alcaldiaMun->id_alcaldia_municipio .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Ciudad" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getAlcaldiaMun($id_alcaldia_municipio)
    {
        header('Content-Type: application/json');

        $AlcaldiaMun = [];

        if ($id_alcaldia_municipio > 0) {
            $AlcaldiaMun =  $this->miAlcaldiaMunicipio->find($id_alcaldia_municipio);
        }
        echo json_encode((array)$AlcaldiaMun, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_alcaldia_municipio)
    {
        if ($id_alcaldia_municipio != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_alcaldia_municipio'] = $id_alcaldia_municipio;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
     
        return view('catAlcaldiaMunicipio/ModalAlcaldiaMunicipio', $datos);
    }

    function AgregarActualizarAlcaldiaMun($id_alcaldia_municipio)
    {
        $entidad = $this->request->getVar('ddl_entidad');

            $reglas = [
                'tbx_desc_corta'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'La descripción corta es obligatoria.'
                    ]
                ],
                'tbx_desc_larga'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'La descripciónl larga es obligatorio.'
                    ]
                ],
                    
            ];
                   

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $entidad == 0) 
        {
            $errores  = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            if ($entidad == 0) {
                $errores = $errores . ' ' . 'El campo Estado es obligatorio.' . "\n";
            }
            echo $errores;
            return;
        }
        

       

        if ($id_alcaldia_municipio == 0) {

            $estatus = $this->request->getVar('ddl_estatus_alcaldia_municipio');
            $idUsuario = session()->get('id_usuario');

            $this->miAlcaldiaMunicipio->insert([
                'desc_corta'            => $this->request->getVar('tbx_desc_corta'),
                'desc_larga'            => $this->request->getVar('tbx_desc_larga'),
                'id_entidad_federativa' => $entidad,
                'id_estado_logico'      => $estatus,
                'id_captura'            => $idUsuario,
                'id_actualiza'          => null,
                'f_captura'             => date('Y-m-d H:i:s'),
                'f_actualiza'           => null
            ]);

            echo 1;

        } else{
            if($id_alcaldia_municipio != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_alcaldia_municipio');

                $this->miAlcaldiaMunicipio->update(
                    $id_alcaldia_municipio,
                    [
                        'desc_corta'            => $this->request->getVar('tbx_desc_corta'),
                        'desc_larga'            => $this->request->getVar('tbx_desc_larga'),
                        'id_entidad_federativa' => $entidad,
                        'id_estado_logico'      => $estatus,
                        'id_actualiza'          => $idUsuario,
                        'f_actualiza'           => date('Y-m-d H:i:s')
                    ]
                );

                echo 1;    
                
            }else{
                echo 0;
            }
        }

       
    }

}