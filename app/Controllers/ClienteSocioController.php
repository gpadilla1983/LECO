<?php

namespace App\Controllers;
use App\Models\{sistVClienteSocioModel,estadoLogicoModel,sistClienteSocioModel};

class ClienteSocioController extends BaseController
{

    private $miVClienteSocioModel;
    private $miEstadoLogico;
    private $miClienteSocioModel;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miVClienteSocioModel = new sistVClienteSocioModel();
        $this->miClienteSocioModel = new sistClienteSocioModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('relClienteSocio/relClienteSocio', $datos);
        }
        
    }

    public function ObtenerClienteSocio()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $clienteSocio = $this->miVClienteSocioModel->getDatosClienteSocio($ddl_estatus);

            $i = 0;
            foreach ($clienteSocio as $cliSocio) {
                array_push($resultado, (array)$cliSocio);
                //$resultado[$i]['row'] = $cliSocio->row;
                $resultado[$i]['id_cliente_socio'] = $cliSocio->id_cliente_socio;
                $resultado[$i]['id_estado_logico'] = $cliSocio->id_estado_logico;
                $resultado[$i]['id_captura'] = $cliSocio->id_captura;
                $resultado[$i]['id_actualiza'] = $cliSocio->id_actualiza;
                $resultado[$i]['f_captura'] = $cliSocio->f_captura; 
                $resultado[$i]['f_actualiza'] = $cliSocio->f_actualiza;
                $resultado[$i]['id_cliente'] = $cliSocio->id_cliente; 
                $resultado[$i]['id_socio'] = $cliSocio->id_socio;
                $resultado[$i]['datos_socio'] = $cliSocio->datos_socio;
                $resultado[$i]['datos_cliente'] = $cliSocio->datos_cliente;
                $resultado[$i]['estado_logico'] = $cliSocio->estado_logico;
                $resultado[$i]['captura'] = $cliSocio->captura;
                $resultado[$i]['actualiza'] = $cliSocio->actualiza;
               
                if (session()->get('id_perfil') == 1){  
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarClienteSocio(' . $cliSocio->id_cliente_socio . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Relacion Cliente - Socio" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getClienteSocio($id_cliente_socio)
    {
        header('Content-Type: application/json');

        $clienteSocio = [];

        if ($id_cliente_socio > 0) {
            $clienteSocio =  $this->miVClienteSocioModel->find($id_cliente_socio);
        }
        echo json_encode((array)$clienteSocio, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_cliente_socio)
    {
        if ($id_cliente_socio != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_cliente_socio'] = $id_cliente_socio;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('relClienteSocio/ModalClienteSocio', $datos);
    }

    function AgregarActualizarClienteSocio($id_cliente_socio)
    {
        if($id_cliente_socio != 0){

            $idUsuario = session()->get('id_usuario');
            $estatus = $this->request->getVar('ddl_estatus_cliente_socio');

            $this->miClienteSocioModel->update(
                    $id_cliente_socio,
                    [
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