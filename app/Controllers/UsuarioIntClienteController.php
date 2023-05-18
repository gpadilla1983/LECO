<?php

namespace App\Controllers;
use App\Models\{sistClienteUsuarioIntModel,estadoLogicoModel, usuarioModel, sistClienteModel, clienteSinUsuarioIntModel};

class UsuarioIntClienteController extends BaseController
{

    private $miClienteUsuaruioInt;
    private $miEstadoLogico;
    private $miUsuario;
    private $miCliente;
    private $miCienteSinUsuario;
   

    function __construct()
    {
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miClienteUsuaruioInt = new sistClienteUsuarioIntModel();
        $this->miUsuario = new usuarioModel();
        $this->miCliente = new sistClienteModel();
        $this->miCienteSinUsuario = new clienteSinUsuarioIntModel();
       
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            $datos['Cliente'] = $this->miCliente->where('id_estado_logico', 1)->findAll();
            $datos['Usuario'] = $this->miUsuario->where('id_estado_logico', 1)->where('id_perfil <>', 3)->findAll();
            $datos['UsuarioAux'] = $this->miUsuario->where('id_estado_logico', 1)->where('id_perfil <>', 3)->findAll();
            return view('sistClienteUsuarioInt/sistClienteUsuarioInt', $datos);
        }
        
    }

    public function ObtenerClienteSinUsuarioInt()
    {
        header('Content-Type: application/json');
        $resultado2 = [];
       
        if ($this->request->getMethod() == 'post') {

            $clienteSinUsInt = $this->miCienteSinUsuario->getDatosUsuarioSinClienteInt();

            $j = 0;
            foreach ($clienteSinUsInt as $cliSinUsInt) {
                array_push($resultado2, (array)$cliSinUsInt);
                //$resultado[$i]['row'] = $notpublica->row;
                                            
                $resultado2[$j]['rfc'] = $cliSinUsInt->razon_social;
                $resultado2[$j]['curp'] = $cliSinUsInt->razon_social;
                $resultado2[$j]['razon_social'] = $cliSinUsInt->razon_social;
                $resultado2[$j]['estado_logico'] = $cliSinUsInt->estado_logico;
                $resultado2[$j]['f_captura'] = $cliSinUsInt->f_captura; 
                $j++;
            }
        }
        echo json_encode($resultado2, JSON_UNESCAPED_UNICODE);

    }


    public function ObtenerClienteUsuarioInt()
    {

        header('Content-Type: application/json');
        $resultado = [];  
       
        if ($this->request->getMethod() == 'post') {

            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $ddl_clienteb = $this->request->getVar('ddl_clienteb');
            $ddl_usuariob = $this->request->getVar('ddl_usuariob');
            $ddl_usuario_auxb = $this->request->getVar('ddl_usuario_auxb');
            $clienteUsInt = $this->miClienteUsuaruioInt->getDatosUsuarioClienteInt($ddl_estatus, $ddl_clienteb, $ddl_usuariob, $ddl_usuario_auxb);

            $i = 0;
            foreach ($clienteUsInt as $cliUsInt) {
                array_push($resultado, (array)$cliUsInt);
                //$resultado[$i]['row'] = $notpublica->row;
                $resultado[$i]['id_usuario_cliente'] = $cliUsInt->id_usuario_cliente;
                $resultado[$i]['id_estado_logico'] = $cliUsInt->id_estado_logico;
                $resultado[$i]['id_captura'] = $cliUsInt->id_captura;
                $resultado[$i]['id_actualiza'] = $cliUsInt->id_actualiza;
                $resultado[$i]['f_captura'] = $cliUsInt->f_captura; 
                $resultado[$i]['f_actualiza'] = $cliUsInt->f_actualiza;
                $resultado[$i]['id_usuario'] = $cliUsInt->id_usuario;
                $resultado[$i]['id_cliente'] = $cliUsInt->id_cliente;
                $resultado[$i]['id_usuario_auxiliar'] = $cliUsInt->id_usuario_auxiliar;
                
                $resultado[$i]['usuario'] = $cliUsInt->n_usuario . ' ' . $cliUsInt->pa_usuario . ' ' . $cliUsInt->sa_usuario;
                $resultado[$i]['usuario_aux'] = $cliUsInt->n_usuario_aux . ' ' . $cliUsInt->pa_usuario_aux . ' ' . $cliUsInt->sa_usuario_aux;
                
                $resultado[$i]['razon_social'] = $cliUsInt->razon_social;

                $resultado[$i]['estado_logico'] = $cliUsInt->estado_logico;
                
                $resultado[$i]['captura'] = $cliUsInt->n_captura . ' ' . $cliUsInt->pa_captura . ' ' . $cliUsInt->sa_captura;
                $resultado[$i]['actualiza'] = $cliUsInt->n_actualiza . ' ' . $cliUsInt->pa_actualiza . ' ' . $cliUsInt->sa_actualiza;
                
                if (session()->get('id_perfil') == 1){
                    $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarClienteUsuarioInt(' . $cliUsInt->id_usuario_cliente .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Cliente Usuario Interno" ><i class="fa fa-pencil"></i></button>';
                }else {
                    $resultado[$i]['acciones'] = '<label class="control-label">SIN AUTORIZACIÓN</label>';
                }
                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getClienteUsuarioInt($id_usuario_cliente)
    {
        header('Content-Type: application/json');

        $cliUserInt = [];

        if ($id_usuario_cliente > 0) {
            $cliUserInt =  $this->miClienteUsuaruioInt->find($id_usuario_cliente);
        }
        echo json_encode((array)$cliUserInt, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_usuario_cliente)
    {
        if ($id_usuario_cliente != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_usuario_cliente'] = $id_usuario_cliente;
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['Cliente'] = $this->miCliente->where('id_estado_logico', 1)->findAll();
        $datos['Usuario'] = $this->miUsuario->where('id_estado_logico', 1)->where('id_perfil <>', 3)->findAll();
        $datos['UsuarioAux'] = $this->miUsuario->where('id_estado_logico', 1)->where('id_perfil <>', 3)->findAll();

        return view('sistClienteUsuarioInt/ModalClienteUsuarioInt', $datos);
    }

    function AgregarActualizarClienteUsuarioInt($id_usuario_cliente)
    {
        
        $cliente = $this->request->getVar('ddl_cliente');
        $usuario = $this->request->getVar('ddl_usuario');
        $usuario_aux = $this->request->getVar('ddl_usuario_aux');

        if($usuario_aux == 0){
            $usuario_aux = null;
        }
              

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
        

        
       

        if ($id_usuario_cliente == 0) {

            $estatus = $this->request->getVar('ddl_estatus_cliente_usuario_int');
            $idUsuario = session()->get('id_usuario');


            $IdUsuarioIntCliente = $this->miClienteUsuaruioInt->select('id_usuario_cliente')->where('id_cliente', $cliente)->where('id_usuario', $usuario)->find();
            if ($IdUsuarioIntCliente != null) {
                $IdUsuarioIntCliente = $IdUsuarioIntCliente[0]->id_usuario_cliente;
                echo 0;
                return;
            } else {
                $this->miClienteUsuaruioInt->insert([
                    'id_cliente'            => $cliente,
                    'id_usuario'            => $usuario,
                    'id_usuario_auxiliar'   => $usuario_aux,
                    'id_estado_logico'      => $estatus,
                    'id_captura'            => $idUsuario,
                    'id_actualiza'          => null,
                    'f_captura'             => date('Y-m-d H:i:s'),
                    'f_actualiza'           => null
                ]);
                echo 1;
            }

        } else{
            if($id_usuario_cliente != 0){

                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_cliente_usuario_int');

                $this->miClienteUsuaruioInt->update(
                    $id_usuario_cliente,
                    [
                        'id_cliente'            => $cliente,
                        'id_usuario'            => $usuario,
                        'id_usuario_auxiliar'   => $usuario_aux,
                        'id_estado_logico'  => $estatus,
                        'id_actualiza'     => $idUsuario,
                        'f_actualiza'       => date('Y-m-d H:i:s')
                    ]
                );

                echo 1;    
                
            }else{
                echo 0;
            }
        }
    }

}