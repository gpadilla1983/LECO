<?php

namespace App\Controllers;
use App\Models\{tipoClienteModel,estadoLogicoModel};

class TipoClienteController extends BaseController
{

    private $miTipoClienteModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miTipoClienteModel = new tipoClienteModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('catTipoCliente/catTipoCliente', $datos);
        }
        
    }

    public function ObtenerTipoCliente()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $tipoCliente = $this->miTipoClienteModel->getDatosTipoCliente($ddl_estatus);

            $i = 0;
            foreach ($tipoCliente as $tipCliente) {
                array_push($resultado, (array)$tipCliente);
                //$resultado[$i]['row'] = $tipCliente->row;
                $resultado[$i]['id_tipo_cliente'] = $tipCliente->id_tipo_cliente;
                $resultado[$i]['id_estado_logico'] = $tipCliente->id_estado_logico;
                $resultado[$i]['id_captura'] = $tipCliente->id_captura;
                $resultado[$i]['id_actualiza'] = $tipCliente->id_actualiza;
                $resultado[$i]['f_captura'] = $tipCliente->f_captura; 
                $resultado[$i]['f_actualiza'] = $tipCliente->f_actualiza;
                $resultado[$i]['desc_corta'] = $tipCliente->desc_corta;
                $resultado[$i]['desc_larga'] = $tipCliente->desc_larga; 
                $resultado[$i]['estado_logico'] = $tipCliente->estado_logico;
                $resultado[$i]['captura'] = $tipCliente->n_captura . ' ' . $tipCliente->pa_captura . ' ' . $tipCliente->sa_captura;
                $resultado[$i]['actualiza'] = $tipCliente->n_actualiza . ' ' . $tipCliente->pa_actualiza . ' ' . $tipCliente->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){     
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarTipoCliente(' . $tipCliente->id_tipo_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Tipo Cliente" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getTipoCliente($id_tipo_cliente)
    {
        header('Content-Type: application/json');

        $tipoCliente = [];

        if ($id_tipo_cliente > 0) {
            $tipoCliente =  $this->miTipoClienteModel->find($id_tipo_cliente);
        }
        echo json_encode((array)$tipoCliente, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_tipo_cliente)
    {
        if ($id_tipo_cliente != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_tipo_cliente'] = $id_tipo_cliente;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('catTipoCliente/ModalTipoCliente', $datos);
    }

    function AgregarActualizarTipoCliente($id_tipo_cliente)
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
        

       

        if ($id_tipo_cliente == 0) {

            $estatus = $this->request->getVar('ddl_estatus_tipo_cliente');
            $idUsuario = session()->get('id_usuario');

            $this->miTipoClienteModel->insert([
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
            if($id_tipo_cliente != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_tipo_cliente');

                $this->miTipoClienteModel->update(
                    $id_tipo_cliente,
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