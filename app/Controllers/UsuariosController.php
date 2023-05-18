<?php

namespace App\Controllers;
use App\Models\{usuarioModel,perfilModel,estadoLogicoModel, catAlcaldiaMunicipioModel, catEntidadFederativaModel, catPaisModel};

class UsuariosController extends BaseController
{

    private $miUsuarioModel;
    private $miPerfilModel;
    private $miEstadoLogico;
    private $miEntidadFederativa;
    private $miPais;
    private $miMunicipio;

    function __construct()
    {
        $this->miPerfilModel = new perfilModel();
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miUsuarioModel = new usuarioModel();
        $this->miEntidadFederativa = new catEntidadFederativaModel();
        $this->miPais = new catPaisModel();
        $this->miMunicipio = new catAlcaldiaMunicipioModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            $datos['Perfiles'] = $this->miPerfilModel->where('id_estado_logico',1)->findAll();
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
            $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
            $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
            $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();
            return view('catUsuarios/catUsuarios', $datos);
        }
        
    }

    public function ObtenerUsuarios()
    {

        header('Content-Type: application/json');
        $resultado = [];

       
        if ($this->request->getMethod() == 'post') {

           
            $ddl_estatus = $this->request->getVar('ddl_estatus');
            $ddl_perfil = $this->request->getVar('ddl_perfil');
            $ddl_paisb = $this->request->getVar('ddl_paisb'); 
            $ddl_entidad_federativab = $this->request->getVar('ddl_entidad_federativab');
            $ddl_alcaldia_municipiob = $this->request->getVar('ddl_alcaldia_municipiob');

            $usuarios = $this->miUsuarioModel->getDatosUsuarios($ddl_perfil, $ddl_estatus, $ddl_paisb, $ddl_entidad_federativab, $ddl_alcaldia_municipiob);

            $i = 0;
            foreach ($usuarios as $user) {
                array_push($resultado, (array)$user);
                //$resultado[$i]['row'] = $user->row;
                $resultado[$i]['usuario'] = $user->usuario;
                $resultado[$i]['id_usuario'] = $user->id_usuario;
                $resultado[$i]['id_estado_logico'] = $user->id_estado_logico;
                $resultado[$i]['id_captura'] = $user->id_captura;
                $resultado[$i]['id_actualiza'] = $user->id_actualiza;
                $resultado[$i]['f_captura'] = $user->f_captura; 
                $resultado[$i]['f_actualiza'] = $user->f_actualiza;
                $resultado[$i]['contrasena'] = $user->contrasena;
                $resultado[$i]['nombre'] = $user->nombre; 
                $resultado[$i]['primer_apellido'] = $user->primer_apellido;
                $resultado[$i]['segundo_apellido'] = $user->segundo_apellido;
                $resultado[$i]['rfc'] = $user->rfc;
                $resultado[$i]['curp'] = $user->curp;
                $resultado[$i]['f_nacimiento'] = $user->f_nacimiento;
                $resultado[$i]['f_ingreso'] = $user->f_ingreso;
                $resultado[$i]['celular'] = $user->celular;
                $resultado[$i]['puesto'] = $user->puesto;
                $resultado[$i]['e_mail'] = $user->e_mail;
                $resultado[$i]['id_perfil'] = $user->id_perfil;
                $resultado[$i]['perfil'] = $user->perfil;
                $resultado[$i]['estado_logico'] = $user->estado_logico;
                $resultado[$i]['nombre_completo'] = $user->nombre . ' ' . $user->primer_apellido . ' ' . $user->segundo_apellido;
                $resultado[$i]['calle'] = $user->calle;


                $resultado[$i]['no_exterior'] = $user->no_exterior;
                $resultado[$i]['no_interior'] = $user->no_interior;
                $resultado[$i]['colonia'] = $user->colonia;
                $resultado[$i]['id_alcaldia_municipio'] = $user->id_alcaldia_municipio;
                $resultado[$i]['id_entidad_federativa'] = $user->id_entidad_federativa;
                $resultado[$i]['id_pais'] = $user->id_pais;
                $resultado[$i]['codigo_postal'] = $user->codigo_postal;
                $resultado[$i]['tel_fijo'] = $user->tel_fijo;

                $resultado[$i]['alcaldia_municipio'] = $user->alcaldia_municipio;
                $resultado[$i]['entidad_federativa'] = $user->entidad_federativa;
                $resultado[$i]['pais'] = $user->pais;

            
                $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarUsuario(' . $user->id_usuario .  ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar usuario" ><i class="fa fa-pencil"></i></button>';

                $i++;
            }
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    
    function getUsuario($id_usuario)
    {
        header('Content-Type: application/json');

        $usuario = [];

        if ($id_usuario > 0) {
            $usuario =  $this->miUsuarioModel->find($id_usuario);
        }
        echo json_encode((array)$usuario, JSON_UNESCAPED_UNICODE);
    }

    public function ModalAgregarActualizar($id_usuario)
    {
        if ($id_usuario != 0) {
            $accion = 'Guardar';
        } else {
            $accion = 'Agregar';
        }

        $datos['accion'] = $accion;
        $datos['id_usuario'] = $id_usuario;
        $datos['Perfiles'] = $this->miPerfilModel->where('id_estado_logico',1)->findAll();
        $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r',1)->findAll();
        $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
        $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
        $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();

        return view('catUsuarios/ModalUsuarios', $datos);
    }

    function AgregarActualizarUsuario($id_usuario)
    {
        
        if($id_usuario == 0)
        {
            $reglas = [
                'tbx_nombre_usuario'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre es obligatorio.'
                    ]
                ],
                'tbx_apellidop_usuario'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Primer Apellido es obligatorio.'
                    ]
                ],
                'tbx_apellidom_usuario'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Segundo Apellido es obligatorio.'
                    ]
                ],
                'tbx_email_usuario'  => [
                    'rules' => "required|min_length[6]|max_length[50]|valid_email",
                    'errors' => [
                        'required' => 'El campo Correo Electrónico es obligatorio.',
                        'valid_email' => 'El campo de Correo Electrónico tiene que ser un email.'
                        
                    ]
                ],
                'tbx_usuario'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Usuario es obligatorio.'
                    ]
                ],
                'tbx_contrasena'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Contraseña es obligatorio.'
                    ]
                ],
                'tbx_rfc'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo RFC es obligatorio.'
                    ]
                ],
                'tbx_curp'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo CURP es obligatorio.'
                    ]
                ],
                'tbx_puesto'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Puesto es obligatorio.'
                    ]
                ],
                'tbx_movil'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Celular es obligatorio.'
                    ]
                ],
                'tbx_fec_nac'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Fecha de Nacimiento es obligatorio.'
                    ]
                ],
                'tbx_fec_ingreso'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Fecha de Ingreso es obligatorio.'
                    ]
                ],
               
                'ddl_role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Perfil es obligatorio.'
                    ]
                ],

                'tbx_calle'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Calle es obligatorio.'
                    ]
                ],

                'tbx_no_exterior'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo No. Exterior es obligatorio.'
                    ]
                ],

                'tbx_colonia'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Colonia es obligatorio.'
                    ]
                ],

                'ddl_alcaldia_municipio'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Ciudad es obligatorio.'
                    ]
                ],

                'ddl_entidad_federativa'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Entidad Federativa es obligatorio.'
                    ]
                ],

                'ddl_pais'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Pais es obligatorio.'
                    ]
                ],

                'tbx_codigo_postal'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Código Postal es obligatorio.'
                    ]
                ],

                'tbx_tel_fijo'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Teléfono Fijo es obligatorio.'
                    ]
                ],
   
            ];
    
           
        }else{
            if($this->request->getVar('valor_check') == 0 || $this->request->getVar('valor_check') == "")
            {
                $reglas = [
                    'tbx_nombre_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Nombre es obligatorio.'
                        ]
                    ],
                    'tbx_apellidop_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Primer apellido es obligatorio.'
                        ]
                    ],
                    'tbx_apellidom_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Segundo apellido es obligatorio.'
                        ]
                    ],
                    'tbx_email_usuario'  => [
                        'rules' => "required|min_length[6]|max_length[50]|valid_email",
                        'errors' => [
                            'required' => 'El campo correo electronico es obligatorio.',
                            'valid_email' => 'El campo de correo electronico tiene que ser un email.'
                            
                        ]
                    ],
                    'tbx_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo usuario es obligatorio.'
                        ]
                    ],
                    'tbx_rfc'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo RFC es obligatorio.'
                        ]
                    ],
                    'tbx_curp'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo CURP es obligatorio.'
                        ]
                    ],
                    'tbx_puesto'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo puesto es obligatorio.'
                        ]
                    ],
                    'tbx_movil'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo celular es obligatorio.'
                        ]
                    ],
                    'tbx_fec_nac'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo fecha de nacimiento es obligatorio.'
                        ]
                    ],
                    'tbx_fec_ingreso'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo fecha de ingreso es obligatorio.'
                        ]
                    ],
                   
                    'ddl_role' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo perfil es obligatorio.'
                        ]
                    ],

                    'tbx_calle'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Calle es obligatorio.'
                        ]
                    ],
    
                    'tbx_no_exterior'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo No. Exterior es obligatorio.'
                        ]
                    ],
    
                    'tbx_colonia'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Colonia es obligatorio.'
                        ]
                    ],
    
                    'ddl_alcaldia_municipio'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Ciudad es obligatorio.'
                        ]
                    ],
    
                    'ddl_entidad_federativa'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Entidad Federativa es obligatorio.'
                        ]
                    ],
    
                    'ddl_pais'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Pais es obligatorio.'
                        ]
                    ],
    
                    'tbx_codigo_postal'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Código Postal es obligatorio.'
                        ]
                    ],
    
                    'tbx_tel_fijo'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Teléfono Fijo es obligatorio.'
                        ]
                    ],
        
                ]; 
            }else{
                $reglas = [
                    'tbx_nombre_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Nombre es obligatorio.'
                        ]
                    ],
                    'tbx_apellidop_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Primer apellido es obligatorio.'
                        ]
                    ],
                    'tbx_apellidom_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Segundo apellido es obligatorio.'
                        ]
                    ],
                    'tbx_email_usuario'  => [
                        'rules' => "required|min_length[6]|max_length[50]|valid_email",
                        'errors' => [
                            'required' => 'El campo correo electronico es obligatorio.',
                            'valid_email' => 'El campo de correo electronico tiene que ser un email.'
                            
                        ]
                    ],
                    'tbx_usuario'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo usuario es obligatorio.'
                        ]
                    ],
                    'tbx_contrasena'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo contraseña es obligatorio.'
                        ]
                    ],
                    'tbx_rfc'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo RFC es obligatorio.'
                        ]
                    ],
                    'tbx_curp'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo CURP es obligatorio.'
                        ]
                    ],
                    'tbx_puesto'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo puesto es obligatorio.'
                        ]
                    ],
                    'tbx_movil'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo celular es obligatorio.'
                        ]
                    ],
                    'tbx_fec_nac'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo fecha de nacimiento es obligatorio.'
                        ]
                    ],
                    'tbx_fec_ingreso'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo fecha de ingreso es obligatorio.'
                        ]
                    ],
                   
                    'ddl_role' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo perfil es obligatorio.'
                        ]
                    ],

                    'tbx_calle'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Calle es obligatorio.'
                        ]
                    ],
    
                    'tbx_no_exterior'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo No. Exterior es obligatorio.'
                        ]
                    ],
    
                    'tbx_colonia'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Colonia es obligatorio.'
                        ]
                    ],
    
                    'ddl_alcaldia_municipio'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Ciudad es obligatorio.'
                        ]
                    ],
    
                    'ddl_entidad_federativa'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Entidad Federativa es obligatorio.'
                        ]
                    ],
    
                    'ddl_pais'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Pais es obligatorio.'
                        ]
                    ],
    
                    'tbx_codigo_postal'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Código Postal es obligatorio.'
                        ]
                    ],
    
                    'tbx_tel_fijo'  => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Teléfono Fijo es obligatorio.'
                        ]
                    ],
                ];
            }

        }

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $this->request->getPost('ddl_role') == 0 || $this->request->getPost('ddl_pais') == 0 || $this->request->getPost('ddl_entidad_federativa') == 0 || $this->request->getPost('ddl_alcaldia_municipio') == 0) {
            $errores  = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }
            echo $errores;
            return;
        }
        

       

        if ($id_usuario == 0) {

            $pais = $this->request->getVar('ddl_pais');
            $entidad_federativa = $this->request->getVar('ddl_entidad_federativa');
            $alcaldia_municipio = $this->request->getVar('ddl_alcaldia_municipio');
            $perfil = $this->request->getVar('ddl_role');
            $estatus = $this->request->getVar('ddl_estatus_usuario');
            $idUsuario = session()->get('id_usuario');
            

            $this->miUsuarioModel->insert([
                'usuario'           => $this->request->getVar('tbx_usuario'),
                'contrasena'        => crypt($this->request->getVar('tbx_contrasena'), '$5$rounds=5000$usesomesillystringforsalt$'),
                'nombre'            => $this->request->getVar('tbx_nombre_usuario'),
                'primer_apellido'   => $this->request->getVar('tbx_apellidop_usuario'),
                'segundo_apellido'  => $this->request->getVar('tbx_apellidom_usuario'),
                'rfc'               => $this->request->getVar('tbx_rfc'),
                'curp'              => $this->request->getVar('tbx_curp'),
                'f_nacimiento'      => $this->request->getVar('tbx_fec_nac'),
                'f_ingreso'         => $this->request->getVar('tbx_fec_ingreso'),
                'celular'           => $this->request->getVar('tbx_movil'),
                'puesto'            => $this->request->getVar('tbx_puesto'),
                'e_mail'            => $this->request->getVar('tbx_email_usuario'),
                'id_perfil'         => $perfil,
                'id_estado_logico'  => $estatus,
                'id_captura'        => $idUsuario,
                'id_actualiza'      => null,
                'f_captura'         => date('Y-m-d H:i:s'),
                'f_actualiza'       => null,
                'calle'             => $this->request->getVar('tbx_calle'),
                'no_exterior'       => $this->request->getVar('tbx_no_exterior'),
                'no_interior'       => $this->request->getVar('tbx_no_interior'),
                'colonia'           => $this->request->getVar('tbx_colonia'),
                'id_alcaldia_municipio'  => $alcaldia_municipio,
                'id_entidad_federativa'  => $entidad_federativa,
                'id_pais'            => $pais,
                'codigo_postal'      => $this->request->getVar('tbx_codigo_postal'),
                'tel_fijo'           => $this->request->getVar('tbx_tel_fijo')
               
            ]);

            echo 1;

        } else{
            if($id_usuario != 0){
                $perfil = $this->request->getVar('ddl_role');
                $idUsuario = session()->get('id_usuario');
                $estatus = $this->request->getVar('ddl_estatus_usuario');
                $pais = $this->request->getVar('ddl_pais');
                $entidad_federativa = $this->request->getVar('ddl_entidad_federativa');
                $alcaldia_municipio = $this->request->getVar('ddl_alcaldia_municipio');
                //$idUsuario = session()->get('id_usuario');
                //$estatus = $this->request->getVar('ddl_estatus_usuario');


                if($this->request->getVar('tbx_contrasena') != "")
                {
                    $this->miUsuarioModel->update(
                        $id_usuario,
                        [
                            'usuario'           => $this->request->getVar('tbx_usuario'),
                            'contrasena'        => crypt($this->request->getVar('tbx_contrasena'), '$5$rounds=5000$usesomesillystringforsalt$'),
                            'nombre'            => $this->request->getVar('tbx_nombre_usuario'),
                            'primer_apellido'   => $this->request->getVar('tbx_apellidop_usuario'),
                            'segundo_apellido'  => $this->request->getVar('tbx_apellidom_usuario'),
                            'rfc'               => $this->request->getVar('tbx_rfc'),
                            'curp'              => $this->request->getVar('tbx_curp'),
                            'f_nacimiento'      => $this->request->getVar('tbx_fec_nac'),
                            'f_ingreso'         => $this->request->getVar('tbx_fec_ingreso'),
                            'celular'           => $this->request->getVar('tbx_movil'),
                            'puesto'            => $this->request->getVar('tbx_puesto'),
                            'e_mail'            => $this->request->getVar('tbx_email_usuario'),
                            'id_perfil'         => $perfil,
                            'id_estado_logico'  => $estatus,
                            "id_actualiza"      => $idUsuario,
                            "f_actualiza"       => date('Y-m-d H:i:s'),
                            'calle'             => $this->request->getVar('tbx_calle'),
                            'no_exterior'       => $this->request->getVar('tbx_no_exterior'),
                            'no_interior'       => $this->request->getVar('tbx_no_interior'),
                            'colonia'           => $this->request->getVar('tbx_colonia'),
                            'id_alcaldia_municipio'  => $alcaldia_municipio,
                            'id_entidad_federativa'  => $entidad_federativa,
                            'id_pais'            => $pais,
                            'codigo_postal'      => $this->request->getVar('tbx_codigo_postal'),
                            'tel_fijo'           => $this->request->getVar('tbx_tel_fijo')
                        ]
                    );
    
                    echo 1;
                }else{
                    $this->miUsuarioModel->update(
                        $id_usuario,
                        [
                            'usuario'           => $this->request->getVar('tbx_usuario'),
                            'nombre'            => $this->request->getVar('tbx_nombre_usuario'),
                            'primer_apellido'   => $this->request->getVar('tbx_apellidop_usuario'),
                            'segundo_apellido'  => $this->request->getVar('tbx_apellidom_usuario'),
                            'rfc'               => $this->request->getVar('tbx_rfc'),
                            'curp'              => $this->request->getVar('tbx_curp'),
                            'f_nacimiento'      => $this->request->getVar('tbx_fec_nac'),
                            'f_ingreso'         => $this->request->getVar('tbx_fec_ingreso'),
                            'celular'           => $this->request->getVar('tbx_movil'),
                            'puesto'            => $this->request->getVar('tbx_puesto'),
                            'e_mail'            => $this->request->getVar('tbx_email_usuario'),
                            'id_perfil'         => $perfil,
                            'id_estado_logico'  => $estatus,
                            "id_actualiza"      => $idUsuario,
                            "f_actualiza"       => date('Y-m-d H:i:s'),
                            'calle'             => $this->request->getVar('tbx_calle'),
                            'no_exterior'       => $this->request->getVar('tbx_no_exterior'),
                            'no_interior'       => $this->request->getVar('tbx_no_interior'),
                            'colonia'           => $this->request->getVar('tbx_colonia'),
                            'id_alcaldia_municipio'  => $alcaldia_municipio,
                            'id_entidad_federativa'  => $entidad_federativa,
                            'id_pais'            => $pais,
                            'codigo_postal'      => $this->request->getVar('tbx_codigo_postal'),
                            'tel_fijo'           => $this->request->getVar('tbx_tel_fijo')
                        ]
                    );
                    echo 1;
                }
            }else{
                echo 0;
            }
        }
    }
}