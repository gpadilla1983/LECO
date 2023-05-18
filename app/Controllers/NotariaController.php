<?php

namespace App\Controllers;
use App\Models\{catNotariaModel,estadoLogicoModel, catAlcaldiaMunicipioModel, catEntidadFederativaModel, catPaisModel};

class NotariaController extends BaseController
{

    private $miNotariaModel;
    private $miEstadoLogico;
    private $miEntidadFederativa;
    private $miPais;
    private $miMunicipio;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miNotariaModel = new catNotariaModel();
        $this->miEntidadFederativa = new catEntidadFederativaModel();
        $this->miPais = new catPaisModel();
        $this->miMunicipio = new catAlcaldiaMunicipioModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
            $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
            $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();
            return view('catNotaria/catNotaria', $datos);
        }
        
    }

    public function ObtenerNotaria()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $notaria = $this->miNotariaModel->getDatosNotaria($ddl_estatus);

            $i = 0;
            foreach ($notaria as $notpublica) {
                array_push($resultado, (array)$notpublica);
                //$resultado[$i]['row'] = $notpublica->row;
                $resultado[$i]['id_notaria_publica'] = $notpublica->id_notaria_publica;
                $resultado[$i]['id_estado_logico'] = $notpublica->id_estado_logico;
                $resultado[$i]['id_captura'] = $notpublica->id_captura;
                $resultado[$i]['id_actualiza'] = $notpublica->id_actualiza;
                $resultado[$i]['f_captura'] = $notpublica->f_captura; 
                $resultado[$i]['f_actualiza'] = $notpublica->f_actualiza;
                $resultado[$i]['no_notaria'] = $notpublica->no_notaria;
                $resultado[$i]['nombre_notario'] = $notpublica->nombre_notario;
                $resultado[$i]['id_pais'] = $notpublica->id_pais;
                $resultado[$i]['id_entidad_federativa'] = $notpublica->id_entidad_federativa;
                $resultado[$i]['id_alcaldia_municipio'] = $notpublica->id_alcaldia_municipio;
                $resultado[$i]['estado_logico'] = $notpublica->estado_logico;
                $resultado[$i]['pais'] = $notpublica->pais;
                $resultado[$i]['entidad_federativa'] = $notpublica->entidad_federativa;
                $resultado[$i]['alcaldia_municipio'] = $notpublica->alcaldia_municipio;
                $resultado[$i]['captura'] = $notpublica->n_captura . ' ' . $notpublica->pa_captura . ' ' . $notpublica->sa_captura;
                $resultado[$i]['actualiza'] = $notpublica->n_actualiza . ' ' . $notpublica->pa_actualiza . ' ' . $notpublica->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarNotaria(' . $notpublica->id_notaria_publica .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Notaria Pública" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getNotaria($id_notaria_publica)
    {
        header('Content-Type: application/json');

        $notPublica = [];

        if ($id_notaria_publica > 0) {
            $notPublica =  $this->miNotariaModel->find($id_notaria_publica);
        }
        echo json_encode((array)$notPublica, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_notaria_publica)
    {
        if ($id_notaria_publica != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_notaria_publica'] = $id_notaria_publica;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
        $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
        $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();

        return view('catNotaria/ModalNotaria', $datos);
    }

    function AgregarActualizarNotaria($id_notaria_publica)
    {
        $pais = $this->request->getVar('ddl_pais');
        $estado = $this->request->getVar('ddl_entidad');
        $municipio = $this->request->getVar('ddl_municipio');

            $reglas = [
                'tbx_num_notaria'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Número de la Notaria es obligatorio.'
                    ]
                ],
                'tbx_nombre_notario'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre del Notario es obligatorio.'
                    ]
                ],
                    
            ];
                   

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $pais == 0 || $estado == 0 || $municipio == 0) 
        {
            $errores  = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            if ($pais == 0) {
                $errores = $errores . ' ' . 'El campo País es obligatorio.' . "\n";
            }
            if ($estado == 0) {
                $errores = $errores . ' ' . 'El campo Entidad Federativa es obligatorio.' . "\n";
            }
            if ($municipio == 0) {
                $errores = $errores . ' ' . 'El campo Municipio o Alcaldía es obligatorio.' . "\n";
            }
            echo $errores;
            return;
        }
        

       

        if ($id_notaria_publica == 0) {

            $estatus = $this->request->getVar('ddl_estatus_notaria');
            $idUsuario = session()->get('id_usuario');

            $this->miNotariaModel->insert([
                'no_notaria'        => $this->request->getVar('tbx_num_notaria'),
                'nombre_notario'    => $this->request->getVar('tbx_nombre_notario'),
                'id_alcaldia_municipio' => $municipio,
                'id_entidad_federativa' => $estado,
                'id_pais'           => $pais,
                'id_estado_logico'  => $estatus,
                'id_captura'        => $idUsuario,
                'id_actualiza'      => null,
                'f_captura'         => date('Y-m-d H:i:s'),
                'f_actualiza'       => null
            ]);

            echo 1;

        } else{
            if($id_notaria_publica != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_notaria');

                $this->miNotariaModel->update(
                    $id_notaria_publica,
                    [
                        'no_notaria'        => $this->request->getVar('tbx_num_notaria'),
                        'nombre_notario'    => $this->request->getVar('tbx_nombre_notario'),
                        'id_alcaldia_municipio' => $municipio,
                        'id_entidad_federativa' => $estado,
                        'id_pais'           => $pais,
                        'id_estado_logico'  => $estatus,
                        'id_actualiza'     => $idUsuario,
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