<?php

namespace App\Controllers;
use App\Models\{sistVClienteTResponsableModel,estadoLogicoModel,sistClienteResponsableModel};

class ClienteTResponsableController extends BaseController
{

    private $miVClienteTResponsableModel;
    private $miEstadoLogico;
    private $miClienteResponsableModel;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miVClienteTResponsableModel = new sistVClienteTResponsableModel();
        $this->miClienteResponsableModel = new sistClienteResponsableModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('relClienteTResponsable/relClienteTResponsable', $datos);
        }
        
    }

    public function ObtenerClienteTResponsable()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $clienteTResponsable = $this->miVClienteTResponsableModel->getDatosClienteTResponsable($ddl_estatus);

            $i = 0;
            foreach ($clienteTResponsable as $cliTResponsable) {
                array_push($resultado, (array)$cliTResponsable);
                //$resultado[$i]['row'] = $cliTResponsable->row;
                $resultado[$i]['id_cliente_tresponsable'] = $cliTResponsable->id_cliente_tresponsable;
                $resultado[$i]['id_estado_logico'] = $cliTResponsable->id_estado_logico;
                $resultado[$i]['id_captura'] = $cliTResponsable->id_captura;
                $resultado[$i]['id_actualiza'] = $cliTResponsable->id_actualiza;
                $resultado[$i]['f_captura'] = $cliTResponsable->f_captura; 
                $resultado[$i]['f_actualiza'] = $cliTResponsable->f_actualiza;
                $resultado[$i]['id_cliente'] = $cliTResponsable->id_cliente; 
                $resultado[$i]['id_responsable'] = $cliTResponsable->id_responsable;
                $resultado[$i]['datos_responsable'] = $cliTResponsable->datos_responsable;
                $resultado[$i]['datos_cliente'] = $cliTResponsable->datos_cliente;
                $resultado[$i]['estado_logico'] = $cliTResponsable->estado_logico;
                $resultado[$i]['captura'] = $cliTResponsable->captura;
                $resultado[$i]['actualiza'] = $cliTResponsable->actualiza;
               
                if (session()->get('id_perfil') == 1){  
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarClienteTResponsable(' . $cliTResponsable->id_cliente_tresponsable . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Relacion Cliente - Responsable" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getClienteTResponsable($id_cliente_tresponsable)
    {
        header('Content-Type: application/json');

        $clienteTResponsable = [];

        if ($id_cliente_tresponsable > 0) {
            $clienteTResponsable =  $this->miVClienteTResponsableModel->find($id_cliente_tresponsable);
        }
        echo json_encode((array)$clienteTResponsable, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_cliente_tresponsable)
    {
        if ($id_cliente_tresponsable != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_cliente_tresponsable'] = $id_cliente_tresponsable;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('relClienteTResponsable/ModalClienteTResponsable', $datos);
    }

    function AgregarActualizarClienteTResponsable($id_cliente_tresponsable)
    {
        if($id_cliente_tresponsable != 0){

            $idUsuario = session()->get('id_usuario');
            $estatus = $this->request->getVar('ddl_estatus_cliente_tresponsable');

            $this->miClienteResponsableModel->update(
                    $id_cliente_tresponsable,
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