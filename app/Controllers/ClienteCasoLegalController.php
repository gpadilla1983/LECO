<?php

namespace App\Controllers;

use App\Models\{
    sistClienteModel,
    catAlcaldiaMunicipioModel,
    catEntidadFederativaModel,
    catJuzgadoModel,
    catPaisModel,
    catTipoCasoLegalModel,
    estadoLogicoModel,
    sistClienteCasoLegalModel,
    catEstadoCasoLegalModel,
};

class ClienteCasoLegalController extends BaseController
{
    private $miTipoCasoLegal;
    private $miJuzgado;
    private $miEntidadFederativa;
    private $miPais;
    private $miMunicipio;
    private $miEstadoLogico;
    private $miCliente;
    private $miClienteCasoLegal;
    private $miEstadoCasoLegal;

    function __construct()
    {
        $this->miTipoCasoLegal = new catTipoCasoLegalModel();
        $this->miJuzgado = new catJuzgadoModel();
        $this->miEntidadFederativa = new catEntidadFederativaModel();
        $this->miPais = new catPaisModel();
        $this->miMunicipio = new catAlcaldiaMunicipioModel();
        $this->miCliente = new sistClienteModel();
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miClienteCasoLegal = new sistClienteCasoLegalModel();
        $this->miEstadoCasoLegal  = new catEstadoCasoLegalModel();
    }
    
    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstatusCasoLegal'] = $this->miEstadoCasoLegal->where('id_estado_logico', 1)->findAll();
            $datos['TipoCasoLegal'] = $this->miTipoCasoLegal->where('id_estado_logico', 1)->findAll();
            $datos['Juzgado'] = $this->miJuzgado->where('id_estado_logico', 1)->findAll();
            $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
            $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
            $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r', 1)->findAll();
            $datos['Cliente'] = $this->miCliente->where('id_estado_logico', 1)->findAll();
             return view('CasoLegal/CasoLegal', $datos);
        }
    }

    function AgregarActualizarDatosGenerales()
    {
        if ($this->request->getMethod() == 'post') {

            $id_cliente_caso_legal = intval($this->request->getVar('id_cliente_caso_legal'));
            $tipocasolegal = $this->request->getVar('ddl_tipoCasoLegal');
            $cliente = $this->request->getVar('ddl_Cliente');
            $juzgado = $this->request->getVar('ddl_juzgado');
            $pais = $this->request->getVar('ddl_pais');
            $entidadfederativa = $this->request->getVar('ddl_entidad_federativa');
            $municipio = $this->request->getVar('ddl_alcaldia_municipio');
            $estatus = $this->request->getVar('ddl_estatus_cliente_caso_legal');
            $finicio = $this->request->getVar('tbx_f_inicio');
            $ftermino = $this->request->getVar('tbx_f_termino');
            if($ftermino == ""){
                $ftermino = null;
            }
            $contraparte = $this->request->getVar('tbx_contraparte');
            $desclarga = $this->request->getVar('tbx_desc_larga');
            $noexpediente = $this->request->getVar('tbx_no_expediente');       
            $idUsuario = session()->get('id_usuario');
            
            $reglasdatosGenerales = [
                    
                    'tbx_f_inicio' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Fecha de Inicio es obligatorio.'
                        ]
                    ],
                    
                    'tbx_contraparte' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Contraparte es obligatorio.'
                        ]
                    ],
                    
                    'tbx_desc_larga' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Descripción es obligatorio.'
                        ]
                    ],
                    'tbx_no_expediente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Núm. de Expediente es obligatorio.'
                        ]
                    ],

                ];

            if (!$this->request->getMethod() == 'POST' || !$this->validate($reglasdatosGenerales) || $tipocasolegal == 0 || $cliente == 0 || $juzgado == 0 || $pais == 0 || $entidadfederativa == 0 || $municipio == 0 || $estatus == 0) {
        
                $errores = '';
                foreach ($this->validator->getErrors() as $error) {
                    $errores = $errores . ' ' . $error . "\n";
                }

                if ($tipocasolegal == 0) {
                    $errores = $errores . ' ' . 'El campo Tipo Caso Legal es obligatorio.' . "\n";
                }
                if ($cliente == 0) {
                    $errores = $errores . ' ' . 'El campo Cliente es obligatorio.' . "\n";
                }
                if ($juzgado == 0) {
                    $errores = $errores . ' ' . 'El campo Juzgado es obligatorio.' . "\n";
                }
                if ($pais == 0) {
                    $errores = $errores . ' ' . 'El campo País es obligatorio.' . "\n";
                }
                if ($entidadfederativa == 0) {
                    $errores = $errores . ' ' . 'El campo Estado es obligatorio.' . "\n";
                }
                if ($municipio == 0) {
                    $errores = $errores . ' ' . 'El campo Ciudad es obligatorio.' . "\n";
                }
                if ($estatus == 0) {
                    $errores = $errores . ' ' . 'El campo Estatus es obligatorio.' . "\n";
                }
                echo $errores;
                return;
            }

            if ($id_cliente_caso_legal == 0) {
               
                $id_cliente_caso_legal = $this->miClienteCasoLegal->insert([
                    'id_tipo_caso_legal'    => $tipocasolegal,
                    'no_expediente'         => $noexpediente,
                    'desc_larga'            => $desclarga,
                    'id_cliente'            => $cliente,
                    'f_inicio'              => $finicio,
                    'f_termino'             => $ftermino,
                    'id_pais'               => $pais,
                    'id_entidad_federativa' => $entidadfederativa,
                    'id_alcaldia_municipio' => $municipio,
                    'id_juzgado'            => $juzgado,
                    'contraparte'           => $contraparte,
                    'id_estado_logico'      => $estatus,
                    'id_captura'            => $idUsuario,
                    'id_actualiza'          => null,
                    'f_captura'             => date('Y-m-d H:i:s'),
                    'f_actualiza'           => null
    
                ]);
    
                if ($id_cliente_caso_legal > 0) {
                    echo $id_cliente_caso_legal;
                } else {
                    echo 0;
                }
    
            } else {
                try {
                    $this->miClienteCasoLegal->update(
                        $id_cliente_caso_legal,
                        [
                            'id_tipo_caso_legal'    => $tipocasolegal,
                            'no_expediente'         => $noexpediente,
                            'desc_larga'            => $desclarga,
                            'id_cliente'            => $cliente,
                            'f_inicio'              => $finicio,
                            'f_termino'             => $ftermino,
                            'id_pais'               => $pais,
                            'id_entidad_federativa' => $entidadfederativa,
                            'id_alcaldia_municipio' => $municipio,
                            'id_juzgado'            => $juzgado,
                            'contraparte'           => $contraparte,
                            'id_estado_logico'      => $estatus,
                            'id_actualiza'          => $idUsuario,
                            'f_actualiza'           => date('Y-m-d H:i:s')
                        ]
                    );
    
                    echo $id_cliente_caso_legal;                 

                } catch (Exception $e) {
                    echo 0;
                }
            }

        }
    }

    public function ObtenerCasoLegal()
    {

        header('Content-Type: application/json');
        $resultado = [];

        if ($this->request->getMethod() == 'post') {

            $ddl_tipoCasoLegalB = $this->request->getVar('ddl_tipoCasoLegalB');
            $ddl_paisB = $this->request->getVar('ddl_paisB');
            $ddl_entidad_federativaB = $this->request->getVar('ddl_entidad_federativaB');
            $ddl_alcaldia_municipioB = $this->request->getVar('ddl_alcaldia_municipioB');
            $ddl_juzgadoB = $this->request->getVar('ddl_juzgadoB');
            $ddl_estatus_cliente_caso_legalB = $this->request->getVar('ddl_estatus_cliente_caso_legalB');
            $no_expedienteB = $this->request->getVar('no_expedienteB');

            $usuario = session()->get('id_usuario');

            if(session()->get('id_perfil') == 1){
                $usuario = "-1";
            }

            $ClienteCasoLegal = $this->miClienteCasoLegal->getDatosClienteCasoLegal($ddl_tipoCasoLegalB, $ddl_paisB, $ddl_entidad_federativaB, $ddl_alcaldia_municipioB, $ddl_juzgadoB, $ddl_estatus_cliente_caso_legalB, $no_expedienteB, $usuario);

            $i = 0;
            foreach ($ClienteCasoLegal as $ClienteCL) {
                array_push($resultado, (array)$ClienteCL);
                //$resultado[$i]['row'] = $actEconomica->row;
                $resultado[$i]['id_cliente_caso_legal'] = $ClienteCL->id_cliente_caso_legal;
                $resultado[$i]['id_estado_logico'] = $ClienteCL->id_estado_logico;
                $resultado[$i]['id_captura'] = $ClienteCL->id_captura;
                $resultado[$i]['id_actualiza'] = $ClienteCL->id_actualiza;
                $resultado[$i]['f_captura'] = $ClienteCL->f_captura; 
                $resultado[$i]['f_actualiza'] = $ClienteCL->f_actualiza;
                $resultado[$i]['no_expediente'] = $ClienteCL->no_expediente;
                $resultado[$i]['desc_larga'] = $ClienteCL->desc_larga;
                $resultado[$i]['id_cliente'] = $ClienteCL->id_cliente;
                $resultado[$i]['id_tipo_caso_legal'] = $ClienteCL->id_tipo_caso_legal;
                $resultado[$i]['f_inicio'] = $ClienteCL->f_inicio;
                $resultado[$i]['f_termino'] = $ClienteCL->f_termino;
                $resultado[$i]['id_pais'] = $ClienteCL->id_pais;
                $resultado[$i]['id_entidad_federativa'] = $ClienteCL->id_entidad_federativa;
                $resultado[$i]['id_alcaldia_municipio'] = $ClienteCL->id_alcaldia_municipio;
                $resultado[$i]['id_juzgado'] = $ClienteCL->id_juzgado;
                $resultado[$i]['contraparte'] = $ClienteCL->contraparte;
                $resultado[$i]['pais'] = $ClienteCL->pais;
                $resultado[$i]['entidad_federativa'] = $ClienteCL->entidad_federativa;
                $resultado[$i]['alcaldia_municipio'] = $ClienteCL->alcaldia_municipio;
                $resultado[$i]['juzgado'] = $ClienteCL->juzgado;
                $resultado[$i]['razon_social'] = $ClienteCL->razon_social;
                $resultado[$i]['tipo_caso_legal'] = $ClienteCL->tipo_caso_legal;
                $resultado[$i]['estado_logico'] = $ClienteCL->estado_logico;
                $resultado[$i]['captura'] = $ClienteCL->n_captura . ' ' . $ClienteCL->pa_captura . ' ' . $ClienteCL->sa_captura;
                $resultado[$i]['actualiza'] = $ClienteCL->n_actualiza . ' ' . $ClienteCL->pa_actualiza . ' ' . $ClienteCL->sa_actualiza;
                $resultado[$i]['ubicacion'] = $ClienteCL->pais . ' - ' . $ClienteCL->entidad_federativa . ' - ' . $ClienteCL->alcaldia_municipio;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarCasoLegal(' . $ClienteCL->id_cliente_caso_legal .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Caso Legal" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    function getClienteCasoLegal($id_cliente_caso_legal)
    {
        header('Content-Type: application/json');

        $clienteCasoLegal = [];

        if ($id_cliente_caso_legal > 0) {
            $clienteCasoLegal =  $this->miClienteCasoLegal->find($id_cliente_caso_legal);
        }
        echo json_encode((array)$clienteCasoLegal, JSON_UNESCAPED_UNICODE);
    }

}