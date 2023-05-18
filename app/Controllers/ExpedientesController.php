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

class ExpedientesController extends BaseController
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
            return view('Expedientes/Expedientes', $datos);
        }
    }

    public function ObtenerCasoLegal()
    {

        header('Content-Type: application/json');
        $resultado = [];

        if ($this->request->getMethod() == 'post') {

            $usuario = session()->get('id_usuario');

            if(session()->get('id_perfil') == 1){
                $usuario = "-1";
            }

            $ClienteCasoLegal = $this->miClienteCasoLegal->getDatosExpediente($usuario);

            $i = 0;
            foreach ($ClienteCasoLegal as $ClienteCL) {
                array_push($resultado, (array)$ClienteCL);
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
                
                $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="VerCasoLegal(' . $ClienteCL->id_cliente_caso_legal .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalle de Caso Legal" ><i class="fas fa-eye"></i></button>';

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