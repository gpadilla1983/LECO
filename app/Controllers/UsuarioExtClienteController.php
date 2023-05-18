<?php

namespace App\Controllers;
use App\Models\{sistClienteUsuarioExtModel,estadoLogicoModel, usuarioModel, sistClienteModel};

class UsuarioExtClienteController extends BaseController
{

    private $miClienteUsuaruioExt;
    private $miEstadoLogico;
    private $miUsuario;
    private $miCliente;
   

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miClienteUsuaruioExt = new sistClienteUsuarioExtModel();
        $this->miUsuario = new usuarioModel();
        $this->miCliente = new sistClienteModel();
       
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            $datos['Cliente'] = $this->miCliente->where('id_estado_logico', 1)->findAll();
            $datos['Usuario'] = $this->miUsuario->where('id_estado_logico', 1)->where('id_perfil', 3)->findAll();
            return view('sistClienteUsuarioExt/sistClienteUsuarioExt', $datos);
        }
        
    }

    public function ObtenerClienteUsuarioExt()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $ddl_clienteb = $this->request->getVar('ddl_clienteb');
            $ddl_usuariob = $this->request->getVar('ddl_usuariob');
            $clienteUsExt = $this->miClienteUsuaruioExt->getDatosUsuarioClienteExt($ddl_estatus, $ddl_clienteb, $ddl_usuariob);

            $i = 0;
            foreach ($clienteUsExt as $cliUsExt) {
                array_push($resultado, (array)$cliUsExt);
                //$resultado[$i]['row'] = $notpublica->row;
                $resultado[$i]['id_usuario_externo_cliente'] = $cliUsExt->id_usuario_externo_cliente;
                $resultado[$i]['id_estado_logico'] = $cliUsExt->id_estado_logico;
                $resultado[$i]['id_captura'] = $cliUsExt->id_captura;
                $resultado[$i]['id_actualiza'] = $cliUsExt->id_actualiza;
                $resultado[$i]['f_captura'] = $cliUsExt->f_captura; 
                $resultado[$i]['f_actualiza'] = $cliUsExt->f_actualiza;
                $resultado[$i]['id_usuario'] = $cliUsExt->id_usuario;
                $resultado[$i]['id_cliente'] = $cliUsExt->id_cliente;
                
                $resultado[$i]['usuario'] = $cliUsExt->n_usuario . ' ' . $cliUsExt->pa_usuario . ' ' . $cliUsExt->sa_usuario;
                
                $resultado[$i]['razon_social'] = $cliUsExt->razon_social;

                $resultado[$i]['estado_logico'] = $cliUsExt->estado_logico;
                
                $resultado[$i]['captura'] = $cliUsExt->n_captura . ' ' . $cliUsExt->pa_captura . ' ' . $cliUsExt->sa_captura;
                $resultado[$i]['actualiza'] = $cliUsExt->n_actualiza . ' ' . $cliUsExt->pa_actualiza . ' ' . $cliUsExt->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarClienteUsuarioExt(' . $cliUsExt->id_usuario_externo_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Cliente Usuario Externo" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getClienteUsuarioExt($id_usuario_externo_cliente)
    {
        header('Content-Type: application/json');

        $cliUserExt = [];

        if ($id_usuario_externo_cliente > 0) {
            $cliUserExt =  $this->miClienteUsuaruioExt->find($id_usuario_externo_cliente);
        }
        echo json_encode((array)$cliUserExt, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_usuario_externo_cliente)
    {
        if ($id_usuario_externo_cliente != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_usuario_externo_cliente'] = $id_usuario_externo_cliente;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['Cliente'] = $this->miCliente->where('id_estado_logico', 1)->findAll();
        $datos['Usuario'] = $this->miUsuario->where('id_estado_logico', 1)->where('id_perfil', 3)->findAll();

        return view('sistClienteUsuarioExt/ModalClienteUsuarioExt', $datos);
    }

    function AgregarActualizarClienteUsuarioExt($id_usuario_externo_cliente)
    {
        
        $cliente = $this->request->getVar('ddl_cliente');
        $usuario = $this->request->getVar('ddl_usuario');
             

        if (!$this->request->getMethod() == 'POST' || $cliente == 0 || $usuario == 0) 
        {
            $errores  = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            if ($cliente == 0) {
                $errores = $errores . ' ' . 'El campo Cliente es obligatorio.' . "\n";
            }
            if ($usuario == 0) {
                $errores = $errores . ' ' . 'El campo Usuario Asignado es obligatorio.' . "\n";
            }
            echo $errores;
            return;
        }
        

        
       

        if ($id_usuario_externo_cliente == 0) {

            $estatus = $this->request->getVar('ddl_estatus_cliente_usuario_ext');
            $idUsuario = session()->get('id_usuario');


            $IdUsuarioExtCliente = $this->miClienteUsuaruioExt->select('id_usuario_externo_cliente')->where('id_cliente', $cliente)->where('id_usuario', $usuario)->find();
            if ($IdUsuarioExtCliente != null) {
                $IdUsuarioExtCliente = $IdUsuarioExtCliente[0]->id_usuario_externo_cliente;
                echo 0;
                return;
            } else {
                $this->miClienteUsuaruioExt->insert([
                    'id_cliente'            => $cliente,
                    'id_usuario'            => $usuario,
                    'id_estado_logico'      => $estatus,
                    'id_captura'            => $idUsuario,
                    'id_actualiza'          => null,
                    'f_captura'             => date('Y-m-d H:i:s'),
                    'f_actualiza'           => null
                ]);
                echo 1;
            }

        } else{
            if($id_usuario_externo_cliente != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_cliente_usuario_ext');

                $this->miClienteUsuaruioExt->update(
                    $id_usuario_externo_cliente,
                    [
                        'id_cliente'            => $cliente,
                        'id_usuario'            => $usuario,
                        'id_estado_logico'      => $estatus,
                        'id_actualiza'          => $idUsuario,
                        'f_actualiza'           => date('Y-m-d H:i:s')
                    ]
                );

                echo 1;    
                
            }else{
                echo 0;
            }
        }
    }

}
