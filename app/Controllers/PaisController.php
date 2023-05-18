<?php

namespace App\Controllers;
use App\Models\{catPaisModel,estadoLogicoModel};

class PaisController extends BaseController
{

    private $miPaisModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miPaisModel = new catPaisModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catPais/catPais', $datos);
        }
        
    }

    public function ObtenerPais()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $pais = $this->miPaisModel->getDatosPais($ddl_estatus);

            $i = 0;
            foreach ($pais as $paises) {
                array_push($resultado, (array)$paises);
                //$resultado[$i]['row'] = $paises->row;
                $resultado[$i]['id_pais'] = $paises->id_pais;
                $resultado[$i]['id_estado_logico'] = $paises->id_estado_logico;
                $resultado[$i]['id_captura'] = $paises->id_captura;
                $resultado[$i]['id_actualiza'] = $paises->id_actualiza;
                $resultado[$i]['f_captura'] = $paises->f_captura; 
                $resultado[$i]['f_actualiza'] = $paises->f_actualiza;
                $resultado[$i]['desc_corta'] = $paises->desc_corta;
                $resultado[$i]['desc_larga'] = $paises->desc_larga; 
                $resultado[$i]['estado_logico'] = $paises->estado_logico;
                $resultado[$i]['captura'] = $paises->n_captura . ' ' . $paises->pa_captura . ' ' . $paises->sa_captura;
                $resultado[$i]['actualiza'] = $paises->n_actualiza . ' ' . $paises->pa_actualiza . ' ' . $paises->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){         
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarPais(' . $paises->id_pais .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar País" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getPais($id_pais)
    {
        header('Content-Type: application/json');

        if ($id_pais > 0) {
            $pais =  $this->miPaisModel->find($id_pais);
        }
        echo json_encode((array)$pais, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_pais)
    {
        if ($id_pais != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_pais'] = $id_pais;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catPais/ModalPais', $datos);
    }

    function AgregarActualizarPais($id_pais)
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
        

       

        if ($id_pais == 0) {

            $estatus = $this->request->getVar('ddl_estatus_pais');
            $idUsuario = session()->get('id_usuario');

            $this->miPaisModel->insert([
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
            if($id_pais != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_pais');

                $this->miPaisModel->update(
                    $id_pais,
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