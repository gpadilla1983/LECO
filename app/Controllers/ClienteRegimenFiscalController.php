<?php

namespace App\Controllers;
use App\Models\{sistVClienteRegimenFiscalModel,estadoLogicoModel,sistClienteRegimenModel,tipoClienteModel,regimenFiscalModel};

class ClienteRegimenFiscalController extends BaseController
{

    private $miVClienteRegimenFiscalModel;
    private $miEstadoLogico;
    private $miClienteRegimenModel;
    private $miRegimenFiscalModel;
    private $miTipoClienteModel;

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miVClienteRegimenFiscalModel = new sistVClienteRegimenFiscalModel();
        $this->miClienteRegimenModel = new sistClienteRegimenModel();
        $this->miTipoClienteModel = new tipoClienteModel();
        $this->miRegimenFiscalModel = new regimenFiscalModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['TipoCliente'] = $this->miTipoClienteModel->where('id_estado_logico', 1)->findAll();
            $datos['RegimenFiscal'] = $this->miRegimenFiscalModel->where('id_estado_logico', 1)->findAll();
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            return view('relClienteRegimenFiscal/relClienteRegimenFiscal', $datos);
        }
        
    }

    public function ObtenerClienteRegimenFiscal()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

            $ddl_tipo_cliente = $this->request->getVar('ddl_tipo_cliente');
            $ddl_regimen_fiscal = $this->request->getVar('ddl_regimen_fiscal');
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $clienteRegimenFiscal = $this->miVClienteRegimenFiscalModel->getDatosClienteRegimenFiscal($ddl_estatus, $ddl_tipo_cliente, $ddl_regimen_fiscal);

            $i = 0;
            foreach ($clienteRegimenFiscal as $cliRegimenFiscal) {
                array_push($resultado, (array)$cliRegimenFiscal);
                //$resultado[$i]['row'] = $cliRegimenFiscal->row;
                $resultado[$i]['id_cliente_regimen_fiscal'] = $cliRegimenFiscal->id_cliente_regimen_fiscal;
                $resultado[$i]['id_estado_logico'] = $cliRegimenFiscal->id_estado_logico;
                $resultado[$i]['id_captura'] = $cliRegimenFiscal->id_captura;
                $resultado[$i]['id_actualiza'] = $cliRegimenFiscal->id_actualiza;
                $resultado[$i]['f_captura'] = $cliRegimenFiscal->f_captura; 
                $resultado[$i]['f_actualiza'] = $cliRegimenFiscal->f_actualiza;
                $resultado[$i]['id_cliente'] = $cliRegimenFiscal->id_cliente; 
                $resultado[$i]['id_regimen_fiscal'] = $cliRegimenFiscal->id_regimen_fiscal;
                $resultado[$i]['datos_regimen_fiscal'] = $cliRegimenFiscal->datos_regimen_fiscal;
                $resultado[$i]['id_tipo_cliente'] = $cliRegimenFiscal->id_tipo_cliente;
                $resultado[$i]['tipo_cliente'] = $cliRegimenFiscal->tipo_cliente;
                $resultado[$i]['datos_cliente'] = $cliRegimenFiscal->datos_cliente;
                $resultado[$i]['estado_logico'] = $cliRegimenFiscal->estado_logico;
                $resultado[$i]['captura'] = $cliRegimenFiscal->captura;
                $resultado[$i]['actualiza'] = $cliRegimenFiscal->actualiza;
               
                if (session()->get('id_perfil') == 1){  
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarClienteRegimenFiscal(' . $cliRegimenFiscal->id_cliente_regimen_fiscal . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Relacion Cliente - Régimen Fiscal" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getClienteRegimenFiscal($id_cliente_regimen_fiscal)
    {
        header('Content-Type: application/json');

        $clienteRegimenFiscal = [];

        if ($id_cliente_regimen_fiscal > 0) {
            $clienteRegimenFiscal =  $this->miVClienteRegimenFiscalModel->find($id_cliente_regimen_fiscal);
        }
        echo json_encode((array)$clienteRegimenFiscal, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_cliente_regimen_fiscal)
    {
        if ($id_cliente_regimen_fiscal != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_cliente_regimen_fiscal'] = $id_cliente_regimen_fiscal;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();

        return view('relClienteRegimenFiscal/ModalClienteRegimenFiscal', $datos);
    }

    function AgregarActualizarClienteRegimenFiscal($id_cliente_regimen_fiscal)
    {
        if($id_cliente_regimen_fiscal != 0){

            $idUsuario = session()->get('id_usuario');
            $estatus = $this->request->getVar('ddl_estatus_cliente_regimen_fiscal');

            $this->miClienteRegimenModel->update(
                    $id_cliente_regimen_fiscal,
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