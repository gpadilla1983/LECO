<?php

namespace App\Controllers;
use App\Models\{catEntidadFederativaModel,estadoLogicoModel,catPaisModel};

class EntidadFederativaController extends BaseController
{

    private $miEstadoLogico;
    private $miEntidadFederativa;
    private $miPais;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miEntidadFederativa = new catEntidadFederativaModel();
        $this->miPais = new catPaisModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
            return view('catEntidadFederativa/catEntidadFederativa', $datos);
        }
        
    }

    public function ObtenerEntidadFed()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $EF = $this->miEntidadFederativa->getDatosEntidadFed($ddl_estatus);

            $i = 0;
            foreach ($EF as $entidad) {
                array_push($resultado, (array)$entidad);
                //$resultado[$i]['row'] = $notpublica->row;
                $resultado[$i]['id_entidad_federativa'] = $entidad->id_entidad_federativa;
                $resultado[$i]['id_estado_logico'] = $entidad->id_estado_logico;
                $resultado[$i]['id_captura'] = $entidad->id_captura;
                $resultado[$i]['id_actualiza'] = $entidad->id_actualiza;
                $resultado[$i]['f_captura'] = $entidad->f_captura; 
                $resultado[$i]['f_actualiza'] = $entidad->f_actualiza;
                $resultado[$i]['desc_corta'] = $entidad->desc_corta;
                $resultado[$i]['desc_larga'] = $entidad->desc_larga;
                $resultado[$i]['id_pais'] = $entidad->id_pais;
                $resultado[$i]['estado_logico'] = $entidad->estado_logico;
                $resultado[$i]['pais'] = $entidad->pais;
                $resultado[$i]['captura'] = $entidad->n_captura . ' ' . $entidad->pa_captura . ' ' . $entidad->sa_captura;
                $resultado[$i]['actualiza'] = $entidad->n_actualiza . ' ' . $entidad->pa_actualiza . ' ' . $entidad->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarEntidadFed(' . $entidad->id_entidad_federativa .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Estado" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getEntidadFed($id_entidad_federativa)
    {
        header('Content-Type: application/json');

        $EF = [];

        if ($id_entidad_federativa > 0) {
            $EF =  $this->miEntidadFederativa->find($id_entidad_federativa);
        }
        echo json_encode((array)$EF, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_entidad_federativa)
    {
        if ($id_entidad_federativa != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_entidad_federativa'] = $id_entidad_federativa;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
     
        return view('catEntidadFederativa/ModalEntidadFederativa', $datos);
    }

    function AgregarActualizarEntidadFed($id_entidad_federativa)
    {
        $pais = $this->request->getVar('ddl_pais');

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
                   

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $pais == 0) 
        {
            $errores  = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            if ($pais == 0) {
                $errores = $errores . ' ' . 'El campo País es obligatorio.' . "\n";
            }
            echo $errores;
            return;
        }
        

       

        if ($id_entidad_federativa == 0) {

            $estatus = $this->request->getVar('ddl_estatus_entidad_federativa');
            $idUsuario = session()->get('id_usuario');

            $this->miEntidadFederativa->insert([
                'desc_corta'        => $this->request->getVar('tbx_desc_corta'),
                'desc_larga'        => $this->request->getVar('tbx_desc_larga'),
                'id_pais'           => $pais,
                'id_estado_logico'  => $estatus,
                'id_captura'        => $idUsuario,
                'id_actualiza'      => null,
                'f_captura'         => date('Y-m-d H:i:s'),
                'f_actualiza'       => null
            ]);

            echo 1;

        } else{
            if($id_entidad_federativa != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_entidad_federativa');

                $this->miEntidadFederativa->update(
                    $id_entidad_federativa,
                    [
                        'desc_corta'        => $this->request->getVar('tbx_desc_corta'),
                        'desc_larga'        => $this->request->getVar('tbx_desc_larga'),
                        'id_pais'           => $pais,
                        'id_estado_logico'  => $estatus,
                        'id_actualiza'      => $idUsuario,
                        'f_actualiza'       => date('Y-m-d H:i:s')
                    ]
                );

                echo 1;    
                
            }else{
                echo 0;
            }
        }

       
    }

}