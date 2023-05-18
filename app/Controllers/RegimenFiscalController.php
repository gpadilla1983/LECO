<?php

namespace App\Controllers;
use App\Models\{regimenFiscalModel,estadoLogicoModel};

class RegimenFiscalController extends BaseController
{

    private $miRegimenFiscalModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miRegimenFiscalModel = new regimenFiscalModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catRegimenFiscal/catRegimenFiscal', $datos);
        }
        
    }

    public function ObtenerRegimenFiscal()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $regimenFiscales = $this->miRegimenFiscalModel->getDatosRegimenFiscal($ddl_estatus);

            $i = 0;
            foreach ($regimenFiscales as $regFiscal) {
                array_push($resultado, (array)$regFiscal);
                //$resultado[$i]['row'] = $regFiscal->row;
                $resultado[$i]['id_regimen_fiscal'] = $regFiscal->id_regimen_fiscal;
                $resultado[$i]['id_estado_logico'] = $regFiscal->id_estado_logico;
                $resultado[$i]['id_captura'] = $regFiscal->id_captura;
                $resultado[$i]['id_actualiza'] = $regFiscal->id_actualiza;
                $resultado[$i]['f_captura'] = $regFiscal->f_captura; 
                $resultado[$i]['f_actualiza'] = $regFiscal->f_actualiza;
                $resultado[$i]['desc_corta'] = $regFiscal->desc_corta;
                $resultado[$i]['desc_larga'] = $regFiscal->desc_larga; 
                $resultado[$i]['estado_logico'] = $regFiscal->estado_logico;
                $resultado[$i]['captura'] = $regFiscal->n_captura . ' ' . $regFiscal->pa_captura . ' ' . $regFiscal->sa_captura;
                $resultado[$i]['actualiza'] = $regFiscal->n_actualiza . ' ' . $regFiscal->pa_actualiza . ' ' . $regFiscal->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){          
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarRegimenFiscal(' . $regFiscal->id_regimen_fiscal .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Régimen Fiscal" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getRegimenFiscal($id_regimen_fiscal)
    {
        header('Content-Type: application/json');

        $regimenFiscal = [];

        if ($id_regimen_fiscal > 0) {
            $regimenFiscal =  $this->miRegimenFiscalModel->find($id_regimen_fiscal);
        }
        echo json_encode((array)$regimenFiscal, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_regimen_fiscal)
    {
        if ($id_regimen_fiscal != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_regimen_fiscal'] = $id_regimen_fiscal;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catRegimenFiscal/ModalRegimenFiscal', $datos);
    }

    function AgregarActualizarRegimenFiscal($id_regimen_fiscal)
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
        

       

        if ($id_regimen_fiscal == 0) {

            $estatus = $this->request->getVar('ddl_estatus_regimen_fiscal');
            $idUsuario = session()->get('id_usuario');

            $this->miRegimenFiscalModel->insert([
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
            if($id_regimen_fiscal != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_regimen_fiscal');

                $this->miRegimenFiscalModel->update(
                    $id_regimen_fiscal,
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