<?php

namespace App\Controllers;
use App\Models\{usuarioModel,perfilModel,estadoLogicoModel};

class LoginController extends BaseController
{

    private $miUsuarioModel;
    private $miPerfilModel;
    private $miEstadoLogico;

    function __construct()
    {
        $this->miPerfilModel = new perfilModel();
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miUsuarioModel = new usuarioModel();
    }
    public function GetVista()
    {
        return view('Login/Login');
    }

    public function authenticate()
    {
        if ($this->request->getMethod() == 'post') {

            $usuario = $this->request->getVar('tbx_usuario');
            $password = $this->request->getVar('tbx_password');

            $rules = [
                'usuario'  => [
                    'rules' => 'required|min_length[6]|max_length[50]',
                    'errors' => [
                        'required' => 'El campo Usuario es obligatorio.',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Contraseña es obligatorio.'
                    ]
                ],
            ];

            if ($this->validate($rules)) {
                $datos['validation'] = $this->validator;
                return view('Login/Login', $datos);
            } else {

                    $usuario = $this->miUsuarioModel->select('usuario.*, p.id_perfil')
                        ->join('perfil p', 'p.id_perfil = usuario.id_perfil', 'INNER')
                        ->where('usuario.usuario', $usuario)
                        ->where('usuario.contrasena', crypt($password, '$5$rounds=5000$usesomesillystringforsalt$'))
                        ->where('usuario.id_estado_logico', 1)
                        ->first();
                    if ($usuario != null) {

                        $this->_setUserSession($usuario);

                        return view('MasterPage/PaginaPrincipal');

                        // switch ($usuario->fk_id_type_usrsys) {
                        //     case 3:
                        //         return redirect()->route('verificacion');
                        //         break;
                        //     case 4:
                        //         return redirect()->route('cuestionarios');
                        //         break;
                        //     case 5:
                        //         return redirect()->route('supervision');
                        //         break;
                        //     case 6:
                        //         return redirect()->route('orft');
                        //         break;
                        // }
                    } else {
                        $datos['alerta'] = 'El usuario y/o password proporcionados son incorrectos, favor de verificar.';
                    return view('login/login', $datos);
                    }
                
                    
                
            }

            
        }
    }

    private function _setUserSession($usuario)
    {

        $SessionData = [
            'id_usuario'        => $usuario->id_usuario,
            'id_estado_logico'  => $usuario->id_estado_logico,
            'id_captura'        => $usuario->id_captura,
            'usuario'           => $usuario->usuario,
            'nombre'            => $usuario->nombre,
            'primer_apellido'   => $usuario->primer_apellido,
            'segundo_apellido'  => $usuario->segundo_apellido,
            'rfc'               => $usuario->rfc,
            'curp'              => $usuario->curp,
            'puesto'            => $usuario->puesto,
            'email'             => $usuario->e_mail,
            'id_perfil'         => $usuario->id_perfil
        ];

        session()->set($SessionData);

        return true;
    }

    public function logout()
    {
        session()->destroy();
        
        return redirect()->route('/');
    }
}
