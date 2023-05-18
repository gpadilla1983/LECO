<?php

namespace App\Controllers;
use App\Models\{catJuzgadoModel,estadoLogicoModel, catAlcaldiaMunicipioModel, catEntidadFederativaModel, catPaisModel};

class JuzgadoController extends BaseController
{

    private $miJuzgadoModel;
    private $miEstadoLogico;
    private $miEntidadFederativa;
    private $miPais;
    private $miMunicipio;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miJuzgadoModel = new catJuzgadoModel();
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
            return view('catJuzgado/catJuzgado', $datos);
        }
        
    }

    public function ObtenerJuzgado()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $juzgado = $this->miJuzgadoModel->getDatosJuzgado($ddl_estatus);

            $i = 0;
            foreach ($juzgado as $juzg) {
                array_push($resultado, (array)$juzg);
                //$resultado[$i]['row'] = $juzg->row;
                $resultado[$i]['id_juzgado'] = $juzg->id_juzgado;
                $resultado[$i]['id_estado_logico'] = $juzg->id_estado_logico;
                $resultado[$i]['id_captura'] = $juzg->id_captura;
                $resultado[$i]['id_actualiza'] = $juzg->id_actualiza;
                $resultado[$i]['f_captura'] = $juzg->f_captura; 
                $resultado[$i]['f_actualiza'] = $juzg->f_actualiza;
                $resultado[$i]['no_juzgado'] = $juzg->no_juzgado;
                $resultado[$i]['desc_larga'] = $juzg->desc_larga;
                $resultado[$i]['id_pais'] = $juzg->id_pais;
                $resultado[$i]['id_entidad_federativa'] = $juzg->id_entidad_federativa;
                $resultado[$i]['id_alcaldia_municipio'] = $juzg->id_alcaldia_municipio;
                $resultado[$i]['estado_logico'] = $juzg->estado_logico;
                $resultado[$i]['pais'] = $juzg->pais;
                $resultado[$i]['entidad_federativa'] = $juzg->entidad_federativa;
                $resultado[$i]['alcaldia_municipio'] = $juzg->alcaldia_municipio;
                $resultado[$i]['captura'] = $juzg->n_captura . ' ' . $juzg->pa_captura . ' ' . $juzg->sa_captura;
                $resultado[$i]['actualiza'] = $juzg->n_actualiza . ' ' . $juzg->pa_actualiza . ' ' . $juzg->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarJuzgado(' . $juzg->id_juzgado .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Juzgado" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getJuzgado($id_juzgado)
    {
        header('Content-Type: application/json');

        $juzgado = [];

        if ($id_juzgado > 0) {
            $juzgado =  $this->miJuzgadoModel->find($id_juzgado);
        }
        echo json_encode((array)$juzgado, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_juzgado)
    {
        if ($id_juzgado != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_juzgado'] = $id_juzgado;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
        $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
        $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();

        return view('catJuzgado/ModalJuzgado', $datos);
    }

    function AgregarActualizarJuzgado($id_juzgado)
    {
        $pais = $this->request->getVar('ddl_pais');
        $estado = $this->request->getVar('ddl_entidad');
        $municipio = $this->request->getVar('ddl_municipio');

            $reglas = [
                'tbx_num_juzgado'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Número del Juzgado es obligatorio.'
                    ]
                ],
                'tbx_desc_larga'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Datos del Juzgado es obligatorio.'
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
        

       

        if ($id_juzgado == 0) {

            $estatus = $this->request->getVar('ddl_estatus_juzgado');
            $idUsuario = session()->get('id_usuario');

            $this->miJuzgadoModel->insert([
                'no_juzgado'        => $this->request->getVar('tbx_num_juzgado'),
                'desc_larga'    => $this->request->getVar('tbx_desc_larga'),
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
            if($id_juzgado != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_juzgado');

                $this->miJuzgadoModel->update(
                    $id_juzgado,
                    [
                        'no_juzgado'        => $this->request->getVar('tbx_num_juzgado'),
                        'desc_larga'    => $this->request->getVar('tbx_desc_larga'),
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