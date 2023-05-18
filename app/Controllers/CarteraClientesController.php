<?php

namespace App\Controllers;
use App\Models\{sistClienteModel,estadoLogicoModel};

class CarteraClientesController extends BaseController
{

    private $miClienteModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miClienteModel = new sistClienteModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('CarteraClientes/CarteraClientes', $datos);
        }
        
    }

    public function ObtenerCarteraCliente()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {
           
            $ddl_estatus = $this->request->getVar('ddl_estatus');

            $Cliente = $this->miClienteModel->getCliente($ddl_estatus);
            $i = 0;
            foreach ($Cliente as $cli) {
                array_push($resultado, (array)$cli);
                //$resultado[$i]['row'] = $cli->row;
                $resultado[$i]['id_cliente'] = $cli->id_cliente;
                $resultado[$i]['id_estado_logico'] = $cli->id_estado_logico;
                $resultado[$i]['id_captura'] = $cli->id_captura;
                $resultado[$i]['id_actualiza'] = $cli->id_actualiza;
                $resultado[$i]['f_captura'] = $cli->f_captura; 
                $resultado[$i]['f_actualiza'] = $cli->f_actualiza;
                $resultado[$i]['tipo_cliente'] = $cli->tipo_cliente;
                $resultado[$i]['rfc'] = $cli->rfc;
                $resultado[$i]['curp'] = $cli->curp; 
                $resultado[$i]['razon_social'] = $cli->razon_social;
                $resultado[$i]['estado_logico'] = $cli->estado_logico;
                $resultado[$i]['captura'] = $cli->n_captura . ' ' . $cli->pa_captura . ' ' . $cli->sa_captura;
                $resultado[$i]['actualiza'] = $cli->n_actualiza . ' ' . $cli->pa_actualiza . ' ' . $cli->sa_actualiza;
                
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="ActivarCliente(' . $cli->id_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar Cliente" ><i class="fas fa-check"></i></button>
                                                  <button class="btn btn-primary btn-sm" onclick="DesactivarCliente(' . $cli->id_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Inactivar Cliente" ><i class="fas fa-times"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    function ActivarCliente($id_cliente)
    {     
        if ($id_cliente != 0) {

            $idUsuario = session()->get('id_usuario');

            $this->miClienteModel->update(
                $id_cliente,[
                'id_estado_logico'  => intval(1),
                'id_actualiza'      => $idUsuario,
                'f_actualiza'      => date('Y-m-d H:i:s')
            ]);

            echo 1;

        } else{
            echo 0;
        }
    }

    function DesactivarCliente($id_cliente)
    {     
        if ($id_cliente != 0) {

            $idUsuario = session()->get('id_usuario');

            $this->miClienteModel->update(
                $id_cliente,[
                'id_estado_logico'  => intval(2),
                'id_actualiza'      => $idUsuario,
                'f_actualiza'      => date('Y-m-d H:i:s')
            ]);

            echo 1;

        } else{
            echo 0;
        }
    }

}