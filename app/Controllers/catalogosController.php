<?php

namespace App\Controllers;
use App\Models\{catAlcaldiaMunicipioModel, catEntidadFederativaModel};

class catalogosController extends BaseController
{
    private $miMunicipioModel;
    private $miEntidadModel;
    

    function __construct()
    {
        $this->miMunicipioModel = new catAlcaldiaMunicipioModel();
        $this->miEntidadModel = new catEntidadFederativaModel();
       
    }

    public function getCatalogoMunicipios($params)
    {
        $htmlOptions = "";   
        $id_entidad = $params;

        $datos_municipio = $this->miMunicipioModel->where('id_entidad_federativa',$id_entidad)->where('id_estado_logico',1)
        ->findAll();

        echo json_encode($datos_municipio, JSON_UNESCAPED_UNICODE);	
    }	

    public function getCatalogosEntidad($params)
    {
        $htmlOptions = "";   
        $id_pais = $params;

        $datos_entidad = $this->miEntidadModel->where('id_pais',$id_pais)->where('id_estado_logico',1)
        ->findAll();

        echo json_encode($datos_entidad, JSON_UNESCAPED_UNICODE);	
    }	

    
}
