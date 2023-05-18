<?php

namespace App\Controllers;
use App\Models\{obligacionFiscalModel,estadoLogicoModel};

class ObligacionFiscalController extends BaseController
{

    private $miObligacionFiscal;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miObligacionFiscal = new obligacionFiscalModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catObligacionFiscal/catObligacionFiscal', $datos);
        }
        
    }

    public function ObtenerObligacionFisc()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $obligacionFiscal = $this->miObligacionFiscal->getDatosObligacionFisc($ddl_estatus);

            $i = 0;
            foreach ($obligacionFiscal as $obligacionFisc) {
                array_push($resultado, (array)$obligacionFisc);
                //$resultado[$i]['row'] = $obligacionFisc->row;
                $resultado[$i]['id_obligacion_fiscal'] = $obligacionFisc->id_obligacion_fiscal;
                $resultado[$i]['id_estado_logico'] = $obligacionFisc->id_estado_logico;
                $resultado[$i]['id_captura'] = $obligacionFisc->id_captura;
                $resultado[$i]['id_actualiza'] = $obligacionFisc->id_actualiza;
                $resultado[$i]['f_captura'] = $obligacionFisc->f_captura; 
                $resultado[$i]['f_actualiza'] = $obligacionFisc->f_actualiza;
                $resultado[$i]['desc_corta'] = $obligacionFisc->desc_corta;
                $resultado[$i]['desc_larga'] = $obligacionFisc->desc_larga; 
                $resultado[$i]['estado_logico'] = $obligacionFisc->estado_logico;
                $resultado[$i]['captura'] = $obligacionFisc->n_captura . ' ' . $obligacionFisc->pa_captura . ' ' . $obligacionFisc->sa_captura;
                $resultado[$i]['actualiza'] = $obligacionFisc->n_actualiza . ' ' . $obligacionFisc->pa_actualiza . ' ' . $obligacionFisc->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){         
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarObligacionFisc(' . $obligacionFisc->id_obligacion_fiscal .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Obligación Fiscal" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getObligacionFisc($id_obligacion_fiscal)
    {
        header('Content-Type: application/json');

        if ($id_obligacion_fiscal > 0) {
            $obligacion_fiscal =  $this->miObligacionFiscal->find($id_obligacion_fiscal);
        }
        echo json_encode((array)$obligacion_fiscal, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_obligacion_fiscal)
    {
        if ($id_obligacion_fiscal != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_obligacion_fiscal'] = $id_obligacion_fiscal;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catObligacionFiscal/ModalObligacionFiscal', $datos);
    }

    function AgregarActualizarObligacionFisc($id_obligacion_fiscal)
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
        

       

        if ($id_obligacion_fiscal == 0) {

            $estatus = $this->request->getVar('ddl_estatus_obligacion_fiscal');
            $idUsuario = session()->get('id_usuario');

            $this->miObligacionFiscal->insert([
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
            if($id_obligacion_fiscal != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_obligacion_fiscal');

                $this->miObligacionFiscal->update(
                    $id_obligacion_fiscal,
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