<?php

namespace App\Controllers;
use App\Models\{sistVClienteActividadEconomicaModel,estadoLogicoModel,sistClienteActividadModel,tipoClienteModel,actividadEconomicaModel};

class ClienteActividadEconomicaController extends BaseController
{

    private $miVClienteActividadEconomicaModel;
    private $miEstadoLogico;
    private $miClienteActividadModel;
    private $miActividadEconomicaModel;
    private $miTipoClienteModel;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miVClienteActividadEconomicaModel = new sistVClienteActividadEconomicaModel();
        $this->miClienteActividadModel = new sistClienteActividadModel();
        $this->miTipoClienteModel = new tipoClienteModel();
        $this->miActividadEconomicaModel = new actividadEconomicaModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['TipoCliente'] = $this->miTipoClienteModel->where('id_estado_logico', 1)->findAll();
            $datos['ActividadEconomica'] = $this->miActividadEconomicaModel->where('id_estado_logico', 1)->findAll();
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('relClienteActividadEconomica/relClienteActividadEconomica', $datos);
        }
        
    }

    public function ObtenerClienteActividadEconomica()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

            $ddl_tipo_cliente = $this->request->getVar('ddl_tipo_cliente');
            $ddl_actividad_economica = $this->request->getVar('ddl_actividad_economica');
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $clienteActividadEconomica = $this->miVClienteActividadEconomicaModel->getDatosClienteActividadEconomica($ddl_estatus, $ddl_tipo_cliente, $ddl_actividad_economica);

            $i = 0;
            foreach ($clienteActividadEconomica as $cliActividadEconomica) {
                array_push($resultado, (array)$cliActividadEconomica);
                //$resultado[$i]['row'] = $cliActividadEconomica->row;
                $resultado[$i]['id_cliente_actividad_economica'] = $cliActividadEconomica->id_cliente_actividad_economica;
                $resultado[$i]['id_estado_logico'] = $cliActividadEconomica->id_estado_logico;
                $resultado[$i]['id_captura'] = $cliActividadEconomica->id_captura;
                $resultado[$i]['id_actualiza'] = $cliActividadEconomica->id_actualiza;
                $resultado[$i]['f_captura'] = $cliActividadEconomica->f_captura; 
                $resultado[$i]['f_actualiza'] = $cliActividadEconomica->f_actualiza;
                $resultado[$i]['id_cliente'] = $cliActividadEconomica->id_cliente; 
                $resultado[$i]['id_actividad_economica'] = $cliActividadEconomica->id_actividad_economica;
                $resultado[$i]['datos_actividad_economica'] = $cliActividadEconomica->datos_actividad_economica;
                $resultado[$i]['id_tipo_cliente'] = $cliActividadEconomica->id_tipo_cliente;
                $resultado[$i]['tipo_cliente'] = $cliActividadEconomica->tipo_cliente;
                $resultado[$i]['datos_cliente'] = $cliActividadEconomica->datos_cliente;
                $resultado[$i]['estado_logico'] = $cliActividadEconomica->estado_logico;
                $resultado[$i]['captura'] = $cliActividadEconomica->captura;
                $resultado[$i]['actualiza'] = $cliActividadEconomica->actualiza;
               
                if (session()->get('id_perfil') == 1){  
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarClienteActividadEconomica(' . $cliActividadEconomica->id_cliente_actividad_economica . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Relacion Cliente - Actividad Económica" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getClienteActividadEconomica($id_cliente_actividad_economica)
    {
        header('Content-Type: application/json');

        $clienteActividadEconomica = [];

        if ($id_cliente_actividad_economica > 0) {
            $clienteActividadEconomica =  $this->miVClienteActividadEconomicaModel->find($id_cliente_actividad_economica);
        }
        echo json_encode((array)$clienteActividadEconomica, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_cliente_actividad_economica)
    {
        if ($id_cliente_actividad_economica != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_cliente_actividad_economica'] = $id_cliente_actividad_economica;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('relClienteActividadEconomica/ModalClienteActividadEconomica', $datos);
    }

    function AgregarActualizarClienteActividadEconomica($id_cliente_actividad_economica)
    {
        if($id_cliente_actividad_economica != 0){

            $idUsuario = session()->get('id_usuario');
            $estatus = $this->request->getVar('ddl_estatus_cliente_actividad_economica');

            $this->miClienteActividadModel->update(
                    $id_cliente_actividad_economica,
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