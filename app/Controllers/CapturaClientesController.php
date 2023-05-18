<?php

namespace App\Controllers;

use App\Models\{
    sistClienteModel,
    sistClienteSocioModel,
    sistSocioModel,
    catAlcaldiaMunicipioModel,
    catEntidadFederativaModel,
    catNotariaModel,
    catPaisModel,
    tipoClienteModel,
    estadoLogicoModel,
    tipoResponsableModel,
    sistResponsableModel,
    sistClienteResponsableModel,
    actividadEconomicaModel,
    sistClienteActividadModel,
    regimenFiscalModel,
    sistClienteRegimenModel

};

class CapturaClientesController extends BaseController
{
    private $miTipoCliente;
    private $miNotaria;
    private $miEntidadFederativa;
    private $miPais;
    private $miMunicipio;
    private $miEstadoLogico;
    private $micliente;
    private $miSocio;
    private $miClienteSocio;
    private $miTipoResponsable;
    private $miResponsable;
    private $miResponsableCliente;
    private $miActividad;
    private $miClienteActividad;
    private $miRegimenFiscal;
    private $miClienteRegimenFiscal;

    #region constructor
    function __construct()
    {
        $this->miTipoCliente = new tipoClienteModel();
        $this->miNotaria = new catNotariaModel();
        $this->miEntidadFederativa = new catEntidadFederativaModel();
        $this->miPais = new catPaisModel();
        $this->miMunicipio = new catAlcaldiaMunicipioModel();
        $this->micliente = new sistClienteModel();
        $this->miEstadoLogico = new estadoLogicoModel();
        $this->miSocio = new sistSocioModel();
        $this->miClienteSocio = new sistClienteSocioModel();
        $this->miTipoResponsable = new tipoResponsableModel();
        $this->miResponsable = new sistResponsableModel();
        $this->miResponsableCliente = new sistClienteResponsableModel();
        $this->miActividad = new actividadEconomicaModel();
        $this->miClienteActividad = new sistClienteActividadModel();
        $this->miRegimenFiscal = new regimenFiscalModel();
        $this->miClienteRegimenFiscal = new sistClienteRegimenModel();

    }
    #endregion

    #region Vista
    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {

            $datos['tipoCliente'] = $this->miTipoCliente->where('id_estado_logico', 1)->findAll();
            $datos['Notaria'] = $this->miNotaria->where('id_estado_logico', 1)->findAll();
            $datos['EntidadFederativa'] = $this->miEntidadFederativa->where('id_estado_logico', 1)->findAll();
            $datos['Pais'] = $this->miPais->where('id_estado_logico', 1)->findAll();
            $datos['Municipio'] = $this->miMunicipio->where('id_estado_logico', 1)->findAll();
            $datos['EstadoLogico'] = $this->miEstadoLogico->where('id_estado_logico_r', 1)->findAll();
            $datos['TipoResponsable'] = $this->miTipoResponsable->where('id_estado_logico', 1)->findAll();
            $datos['ActividadEconomica'] = $this->miActividad->where('id_estado_logico', 1)->findAll();
            $datos['RegimenFiscal'] = $this->miRegimenFiscal->where('id_estado_logico', 1)->findAll();
            return view('CapturaClientes/CapturaClientes', $datos);
        }
    }
    #endregion

    #region Captura Datos Generales
    function AgregarActualizarDatosGenerales()
    {

        if ($this->request->getMethod() == 'post') {

            $tipo_cliente = $this->request->getVar('ddl_tipoCliente');

            if ($tipo_cliente == 1) {
                $reglasdatosGenerales = [
                    'ddl_tipoCliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El Tipo Cliente es obligatorio.'
                        ]
                    ],
                    'tbx_rfc_cliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo RFC es obligatorio.'
                        ]
                    ],
                    'tbx_razon_social' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Nombre o Razón Social es obligatorio.'
                        ]
                    ],
                    'tbx_curp_cliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo CURP es obligatorio.'
                        ]
                    ],

                ];
            } else {
                $reglasdatosGenerales = [
                    'ddl_tipoCliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El Tipo Cliente es obligatorio.'
                        ]
                    ],
                    'tbx_rfc_cliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo RFC es obligatorio.'
                        ]
                    ],
                    'tbx_razon_social' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Nombre o Razón Social es obligatorio.'
                        ]
                    ],

                ];
            }

            if (!$this->request->getMethod() == 'POST' || !$this->validate($reglasdatosGenerales) || $tipo_cliente == 0) {
                $errores = '';
                foreach ($this->validator->getErrors() as $error) {
                    $errores = $errores . ' ' . $error . "\n";
                }

                if ($tipo_cliente == 0) {
                    $errores = $errores . ' ' . 'El Tipo Cliente es obligatorio.' . "\n";
                }
                echo $errores;
                return;
            }

            $RFC = $this->request->getVar('tbx_rfc_cliente');
            $curp = $this->request->getVar('tbx_curp_cliente');
            $Nombre_razon_social = $this->request->getVar('tbx_razon_social');
            $estatus = 1;
            $idUsuario = session()->get('id_usuario');
            $id_cliente = intval($this->request->getVar('id_cliente'));

        }

        if ($id_cliente == 0) {
            $id_cliente = $this->micliente->insert([
                'id_tipo_cliente' => $tipo_cliente,
                'rfc' => $RFC,
                'curp' => $curp,
                'razon_social' => $Nombre_razon_social,
                'id_estado_logico' => $estatus,
                'id_captura' => $idUsuario,
                "id_actualiza" => null,
                "f_captura" => date('Y-m-d H:i:s'),
                "f_actualiza" => null
            ]);

            if ($id_cliente > 0) {
                echo $id_cliente;
            } else {
                echo 0;
            }


        } else {
            try {
                $this->micliente->update(
                    $id_cliente,
                    [
                        'id_tipo_cliente' => $tipo_cliente,
                        'rfc' => $RFC,
                        'curp' => $curp,
                        'razon_social' => $Nombre_razon_social,
                        "id_actualiza" => $idUsuario,
                        "f_actualiza" => date('Y-m-d H:i:s')
                    ]
                );

                echo -1;
            } catch (Exception $e) {
                echo 0;
            }

        }

    }
    #endregion

    #region Actualiza Domicilio
    function ActualizarDomicilio()
    {
        if ($this->request->getMethod() == 'post') {

            $tipoCliente = $this->request->getVar('tipo_cliente');
            $pais = $this->request->getVar('ddl_pais');
            $estado = $this->request->getVar('ddl_entidad');
            $municipio = $this->request->getVar('ddl_municipio');
            $notaria = $this->request->getVar('ddl_notaria');

            if ($tipoCliente == 2) {
                $reglasDomicilio = [
                    'tbx_calle' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Calle es obligatorio.'
                        ]
                    ],
                    'tbx_no_exterior' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo No. Exterior es obligatorio.'
                        ]
                    ],
                    'tbx_colonia' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Colonia es obligatorio.'
                        ]
                    ],
                    'tbx_entre_calle' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Entre calle es obligatorio.'
                        ]
                    ],
                    'tbx_y_calle' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Y calle es obligatorio.'
                        ]
                    ],
                    'tbx_cp' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Código Postal es obligatorio.'
                        ]
                    ],
                    'tbx_mail' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo E-mail es obligatorio.'
                        ]
                    ],
                    'tbx_telefono' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Teléfono es obligatorio.'
                        ]
                    ],
                    'tbx_no_escritura' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Número de escritura es obligatorio.'
                        ]
                    ],
                    'tbx_fecha_escritura' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Fecha de escritura es obligatorio.'
                        ]
                    ],
                    'tbx_folio_mercantil' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Folio mercantil es obligatorio.'
                        ]
                    ],
                    'tbx_fecha_registro' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Fecha de registro es obligatorio.'
                        ]
                    ],

                ];

                if (!$this->request->getMethod() == 'POST' || !$this->validate($reglasDomicilio) || $pais == 0 || $estado == 0 || $municipio == 0 || $notaria == 0) {
                    $errores = '';
                    foreach ($this->validator->getErrors() as $error) {
                        $errores = $errores . ' ' . $error . "\n";
                    }

                    if ($pais == 0) {
                        $errores = $errores . ' ' . 'El campo País es obligatorio.' . "\n";
                    }
                    if ($estado == 0) {
                        $errores = $errores . ' ' . 'El campo Entidad Federativa es obligatorio.' . "\n";
                    }
                    if ($municipio == 0) {
                        $errores = $errores . ' ' . 'El campo Municipio o Alcaldía es obligatorio.' . "\n";
                    }
                    if ($notaria == 0) {
                        $errores = $errores . ' ' . 'El campo Notaria es obligatorio.' . "\n";
                    }
                    echo $errores;
                    return;
                }

            } else {
                if ($tipoCliente == 1) {
                    $reglasDomicilio = [
                        'tbx_calle' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo Calle es obligatorio.'
                            ]
                        ],
                        'tbx_no_exterior' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo No. Exterior es obligatorio.'
                            ]
                        ],
                        'tbx_colonia' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo Colonia es obligatorio.'
                            ]
                        ],
                        'tbx_entre_calle' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo Entre calle es obligatorio.'
                            ]
                        ],
                        'tbx_y_calle' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo Y calle es obligatorio.'
                            ]
                        ],
                        'tbx_cp' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo Código Postal es obligatorio.'
                            ]
                        ],
                        'tbx_mail' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo E-mail es obligatorio.'
                            ]
                        ],
                        'tbx_telefono' => [
                            'rules' => 'required',
                            'errors' => [
                                'required' => 'El campo Teléfono es obligatorio.'
                            ]
                        ],

                    ];

                    if (!$this->request->getMethod() == 'POST' || !$this->validate($reglasDomicilio) || $pais == 0 || $estado == 0 || $municipio == 0) {
                        $errores = '';
                        foreach ($this->validator->getErrors() as $error) {
                            $errores = $errores . ' ' . $error . "\n";
                        }

                        if ($pais == 0) {
                            $errores = $errores . ' ' . 'El campo País es obligatorio.' . "\n";
                        }
                        if ($estado == 0) {
                            $errores = $errores . ' ' . 'El campo Entidad Federativa es obligatorio.' . "\n";
                        }
                        if ($municipio == 0) {
                            $errores = $errores . ' ' . 'El campo Municipio o Alcaldía es obligatorio.' . "\n";
                        }
                        echo $errores;
                        return;
                    }
                }
            }

            $calle = $this->request->getVar('tbx_calle');
            $num_exterior = $this->request->getVar('tbx_no_exterior');
            $num_interior = $this->request->getVar('tbx_no_interior');
            $colonia = $this->request->getVar('tbx_colonia');
            $entre_calle = $this->request->getVar('tbx_entre_calle');
            $y_calle = $this->request->getVar('tbx_y_calle');
            $cp = $this->request->getVar('tbx_cp');
            $mail = $this->request->getVar('tbx_mail');
            $telefono = $this->request->getVar('tbx_telefono');
            if($tipoCliente == 2){
                $notaria = $this->request->getVar('ddl_notaria');
                $num_escritura = $this->request->getVar('tbx_no_escritura');
                $FechaEscritura = $this->request->getVar('tbx_fecha_escritura');
                $Folio_mercantil = $this->request->getVar('tbx_folio_mercantil');
            }
            
            $fecha_registro = $this->request->getVar('tbx_fecha_registro');
            $id_cliente = $this->request->getVar('id_clienteD');
            $idUsuario = session()->get('id_usuario');


            try {
                if($tipoCliente == 2){
                    $this->micliente->update(
                        $id_cliente,
                        [
                            'e_mail' => $mail,
                            'calle' => $calle,
                            'no_exterior' => $num_exterior,
                            'no_interior' => $num_interior,
                            'colonia' => $colonia,
                            'entre_calle' => $entre_calle,
                            'y_calle' => $y_calle,
                            'id_alcaldia_municipio' => $municipio,
                            'id_entidad_federativa' => $estado,
                            'id_pais' => $pais,
                            'codigo_postal' => $cp,
                            'telefono' => $telefono,
                            'id_notaria_publica' => $notaria,
                            'no_escritura' => $num_escritura,
                            'f_escritura' => $FechaEscritura,
                            'folio_mercantil' => $Folio_mercantil,
                            'f_registro' => $fecha_registro,
                            "id_actualiza" => $idUsuario,
                            "f_actualiza" => date('Y-m-d H:i:s')
                        ]
                    );
                }else{
                    $this->micliente->update(
                        $id_cliente,
                        [
                            'e_mail' => $mail,
                            'calle' => $calle,
                            'no_exterior' => $num_exterior,
                            'no_interior' => $num_interior,
                            'colonia' => $colonia,
                            'entre_calle' => $entre_calle,
                            'y_calle' => $y_calle,
                            'id_alcaldia_municipio' => $municipio,
                            'id_entidad_federativa' => $estado,
                            'id_pais' => $pais,
                            'codigo_postal' => $cp,
                            'telefono' => $telefono,
                            'f_registro' => $fecha_registro,
                            "id_actualiza" => $idUsuario,
                            "f_actualiza" => date('Y-m-d H:i:s')
                        ]
                    );
                }
               

                echo $id_cliente;
            } catch (Exception $e) {
                echo 0;
            }

        } else {
            echo 0;
        }
    }
    #endregion

    #region Buscar RFC de Socios
    public function getBuscarRFC($rfc)
    {

        $resultado = $this->miSocio->where('rfc', $rfc)->findAll();

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function AgregarSocio()
    {
        header('Content-Type: application/json');

        $idClienteS = $_POST["idClienteS"];
        $IdSocioCliente = $_POST["IdSocioCliente"];
        $id_socioS = intval($_POST["idSocioS"]);
        $RFC = $_POST["RFC"];
        $Nombre = $_POST["Nombre"];
        $PrimerAp = $_POST["PrimerAp"];
        $SegundoAp = $_POST["SegundoAp"];
        $Curp = $_POST["Curp"];
        $Email = $_POST["Email"];
        $Estatus = $_POST["Estatus"];


        $reglas = [
            'RFC' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo RFC es obligatorio.'
                ]
            ],
            'Nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Nombre es obligatorio.'
                ]
            ],
            'PrimerAp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Primer apellido es obligatorio.'
                ]
            ],
            'SegundoAp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Segundo apellido es obligatorio.'
                ]
            ],
            'Curp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Curp es obligatorio.'
                ]
            ],
            'Email' => [
                'rules' => "required|min_length[6]|max_length[70]",
                'errors' => [
                    'required' => 'El campo Correo electrónico es obligatorio.',

                ]
            ]
        ];

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas)) {
            $errores = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }

            echo $errores;
            return;
        }

        if ($id_socioS == 0) {
            $id_socioS = $this->miSocio->insert([
                'nombre' => $Nombre,
                'primer_apellido' => $PrimerAp,
                'segundo_apellido' => $SegundoAp,
                'rfc' => $RFC,
                'curp' => $Curp,
                'e_mail' => $Email,
                'id_estado_logico' => $Estatus,
                'id_captura' => session()->get('id_usuario'),
                'f_captura' => date('Y-m-d H:i:s'),

            ]);

            $id_clienteSocio = $this->miClienteSocio->insert([
                'id_estado_logico' => $Estatus,
                'id_captura' => session()->get('id_usuario'),
                'f_captura' => date('Y-m-d H:i:s'),
                'id_cliente' => $idClienteS,
                'id_socio' => $id_socioS,

            ]);

            if ($id_clienteSocio >= 1) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            if ($IdSocioCliente == 0) {

                $IdSocioClienteSoc = $this->miClienteSocio->select('id_cliente_socio')->where('id_cliente', $idClienteS)->where('id_socio', $id_socioS)->find();
                if ($IdSocioClienteSoc != null) {
                    $IdSocioCliente = $IdSocioClienteSoc[0]->id_cliente_socio;
                    echo 0;
                    return;
                } else {
                    $id_clienteSocio = $this->miClienteSocio->insert([
                        'id_estado_logico' => $Estatus,
                        'id_captura' => session()->get('id_usuario'),
                        'f_captura' => date('Y-m-d H:i:s'),
                        'id_cliente' => $idClienteS,
                        'id_socio' => $id_socioS,

                    ]);

                    if ($id_clienteSocio >= 1) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                }



            } else {
                $this->miSocio->update(
                    $id_socioS,
                    [
                        'nombre' => $Nombre,
                        'primer_apellido' => $PrimerAp,
                        'segundo_apellido' => $SegundoAp,
                        'rfc' => $RFC,
                        'curp' => $Curp,
                        'e_mail' => $Email,
                        //'id_estado_logico' => $Estatus,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                $datosSociosClientes = $this->miClienteSocio->update(
                    $IdSocioCliente,
                    [
                        'id_estado_logico' => $Estatus,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($datosSociosClientes) {
                    echo 1;
                } else {
                    echo 0;
                }
            }



        }
    }

    public function ObtenerUsuarios()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $idCliente = $this->request->getVar('IdCliente');

        $socios = $this->miSocio->getDatosSociobyCliente($idCliente);

        $i = 0;
        foreach ($socios as $soc) {
            array_push($resultado, (array) $soc);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['id_cliente'] = $soc->id_cliente;
            $resultado[$i]['id_socio'] = $soc->id_socio;
            $resultado[$i]['rfc'] = $soc->rfc;
            $resultado[$i]['curp'] = $soc->curp;
            $resultado[$i]['nombre_completo'] = $soc->nombre . ' ' . $soc->primer_apellido . ' ' . $soc->segundo_apellido;
            if ($soc->edologicocs == 1) {
                $resultado[$i]['estado_logico'] = 'ACTIVO';
            } else {
                $resultado[$i]['estado_logico'] = 'INACTIVO';
            }
            // $resultado[$i]['estado_logico'] = $soc->estado_logico;
            $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarSocio(' . $soc->id_cliente_socio . ',' . $soc->id_socio . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar socio" ><i class="fa fa-pencil"></i></button>';

            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function ObtenerUsuariosbysocio()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $IdSocioCliente = $this->request->getVar('IdSocioCliente');

        $socios = $this->miSocio->getDatosSociobySocio($IdSocioCliente);

        $i = 0;
        foreach ($socios as $soc) {
            array_push($resultado, (array) $soc);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['id_cliente'] = $soc->id_cliente;
            $resultado[$i]['id_socio'] = $soc->id_socio;
            $resultado[$i]['rfc'] = $soc->rfc;
            $resultado[$i]['curp'] = $soc->curp;
            $resultado[$i]['nombre_completo'] = $soc->nombre . ' ' . $soc->primer_apellido . ' ' . $soc->segundo_apellido;
            $resultado[$i]['estado_logico'] = $soc->estado_logico;
            $resultado[$i]['Estatus'] = $soc->id_estado_logico;
            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }
    #endregion

    #region Buscar RFC de Responsable
    public function getBuscarRFCResponsable($rfc)
    {

        $resultado = $this->miResponsable->ObtenerResponsablebyRFC($rfc);

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function AgregarResponsable()
    {
        header('Content-Type: application/json');

        $idClienteS = $_POST["idClienteS"];
        $IdResponsableCliente = $_POST["idResponsableCliente"];
        $id_responsableS = intval($_POST["idResponsableS"]);
        $RFC = $_POST["RFC"];
        $Nombre = $_POST["Nombre"];
        $PrimerAp = $_POST["PrimerAp"];
        $SegundoAp = $_POST["SegundoAp"];
        $Curp = $_POST["Curp"];
        $Email = $_POST["Email"];
        $Estatus = $_POST["Estatus"];
        $idTipoResponsable = $_POST["idTipoResponsable"];

        $reglas = [
            'RFC' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo RFC es obligatorio.'
                ]
            ],
            'Nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Nombre es obligatorio.'
                ]
            ],
            'PrimerAp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Primer apellido es obligatorio.'
                ]
            ],
            'SegundoAp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Segundo apellido es obligatorio.'
                ]
            ],
            'Curp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo Curp es obligatorio.'
                ]
            ],
            'Email' => [
                'rules' => "required|min_length[6]|max_length[70]",
                'errors' => [
                    'required' => 'El campo Correo electrónico es obligatorio.',

                ]
            ]
        ];

        if (!$this->request->getMethod() == 'POST' || !$this->validate($reglas) || $idTipoResponsable == 0) {
            $errores = '';
            foreach ($this->validator->getErrors() as $error) {
                $errores = $errores . ' ' . $error . "\n";
            }

            if ($idTipoResponsable == 0) {
                $errores = $errores . ' ' . 'El campo tipo responsable es obligatorio' . "\n";
            }

            echo $errores;
            return;
        }

        if ($id_responsableS == 0) {
            $id_responsableS = $this->miResponsable->insert([
                'nombre' => $Nombre,
                'primer_apellido' => $PrimerAp,
                'segundo_apellido' => $SegundoAp,
                'rfc' => $RFC,
                'curp' => $Curp,
                'e_mail' => $Email,
                'id_estado_logico' => $Estatus,
                'id_captura' => session()->get('id_usuario'),
                'f_captura' => date('Y-m-d H:i:s'),

            ]);

            $id_clienteResponsable = $this->miResponsableCliente->insert([
                'id_estado_logico' => $Estatus,
                'id_captura' => session()->get('id_usuario'),
                'f_captura' => date('Y-m-d H:i:s'),
                'id_cliente' => $idClienteS,
                'id_responsable' => $id_responsableS,
                'id_tipo_responsable' => $idTipoResponsable,

            ]);

            if ($id_clienteResponsable >= 1) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            if ($IdResponsableCliente == 0) {

                if ($IdResponsableCliente == 0) {

                    $IdResponsableCliente = $this->miResponsableCliente->select('id_cliente_tresponsable')->where('id_cliente', $idClienteS)->where('id_responsable', $id_responsableS)->where('id_tipo_responsable', $idTipoResponsable)->find();
                    if ($IdResponsableCliente != null) {
                        // $IdClienteResponsable = $IdResponsableCliente[0]->id_cliente_responsable;
                        echo 0;
                        return;
                    } else {
                        $id_clienteResponsable = $this->miResponsableCliente->insert([
                            'id_estado_logico' => $Estatus,
                            'id_captura' => session()->get('id_usuario'),
                            'f_captura' => date('Y-m-d H:i:s'),
                            'id_cliente' => $idClienteS,
                            'id_responsable' => $id_responsableS,
                            'id_tipo_responsable' => $idTipoResponsable,

                        ]);

                        if ($id_clienteResponsable >= 1) {
                            echo 1;
                        } else {
                            echo 0;
                        }
                    }
                }

            } else {
                $this->miResponsable->update(
                    $id_responsableS,
                    [
                        'nombre' => $Nombre,
                        'primer_apellido' => $PrimerAp,
                        'segundo_apellido' => $SegundoAp,
                        'rfc' => $RFC,
                        'curp' => $Curp,
                        'e_mail' => $Email,
                        //'id_estado_logico' => $Estatus,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                $datosResponsableClientes = $this->miResponsableCliente->update(
                    $IdResponsableCliente,
                    [
                        'id_estado_logico' => $Estatus,
                        'id_tipo_responsable' => $idTipoResponsable,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($datosResponsableClientes) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
        }
    }

    public function ObtenerResponsable()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $idCliente = $this->request->getVar('IdCliente');

        $responsable = $this->miResponsable->getDatosResponsablebyCliente($idCliente);

        $i = 0;
        foreach ($responsable as $resp) {
            array_push($resultado, (array) $resp);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['id_cliente'] = $resp->id_cliente;
            $resultado[$i]['id_responsable'] = $resp->id_responsable;
            $resultado[$i]['rfc'] = $resp->rfc;
            $resultado[$i]['curp'] = $resp->curp;
            $resultado[$i]['nombre_completo'] = $resp->nombre . ' ' . $resp->primer_apellido . ' ' . $resp->segundo_apellido;
            if ($resp->IdEdoLogicoCR == 1) {
                $resultado[$i]['estado_logico'] = 'ACTIVO';
            } else {
                $resultado[$i]['estado_logico'] = 'INACTIVO';
            }
            $resultado[$i]['tipo_responsable'] = $resp->desc_larga;
            $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarResponsable(' . $resp->id_cliente_tresponsable . ',' . $resp->id_responsable . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar responsable" ><i class="fa fa-pencil"></i></button>';

            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function ObtenerClientebyResponsable()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $IdResponsableCliente = $this->request->getVar('IdResponsableCliente');

        $responsable = $this->miResponsable->getDatosResponsablebyResponsable($IdResponsableCliente);

        $i = 0;
        foreach ($responsable as $resp) {
            array_push($resultado, (array) $resp);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['id_cliente'] = $resp->id_cliente;
            $resultado[$i]['id_responsable'] = $resp->id_responsable;
            $resultado[$i]['rfc'] = $resp->rfc;
            $resultado[$i]['curp'] = $resp->curp;
            $resultado[$i]['nombre_completo'] = $resp->nombre . ' ' . $resp->primer_apellido . ' ' . $resp->segundo_apellido;
            $resultado[$i]['estado_logico'] = $resp->estado_logico;
            $resultado[$i]['tipo_responsable'] = $resp->desc_larga;
            $resultado[$i]['Estatus'] = $resp->id_estado_logico;
            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }
    #endregion

    #region Actividades Económicas
    public function ActualizaActividadEconomica()
    {

        $IdCliente = $this->request->getVar('IdCliente');
        $IdActividad = $this->request->getVar('IdActividad');

        $verificarClienteActividad = $this->miClienteActividad->where('id_cliente', $IdCliente)->where('id_actividad_economica', $IdActividad)->find();

        if ($verificarClienteActividad == null) {

            $id_clienteActividad = $this->miClienteActividad->insert([
                'id_estado_logico' => 1,
                'id_captura' => session()->get('id_usuario'),
                'f_captura' => date('Y-m-d H:i:s'),
                'id_cliente' => $IdCliente,
                'id_actividad_economica' => $IdActividad,

            ]);

            if ($id_clienteActividad > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {

            if ($verificarClienteActividad[0]->id_estado_logico == 2) {
                $datosResponsableClientes = $this->miClienteActividad->update(
                    $verificarClienteActividad[0]->id_cliente_actividad_economica,
                    [
                        'id_estado_logico' => 1,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($datosResponsableClientes) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $datosResponsableClientes = $this->miClienteActividad->update(
                    $verificarClienteActividad[0]->id_cliente_actividad_economica,
                    [
                        'id_estado_logico' => 2,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($datosResponsableClientes) {
                    echo 1;
                } else {
                    echo 0;
                }
            }

        }
    }


    public function obtenerActividades()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $idCliente = $this->request->getVar('IdCliente');

        $actividadesCliente = $this->miClienteActividad->getDatosActividadbyCliente($idCliente);

        $i = 0;
        foreach ($actividadesCliente as $AC) {
            array_push($resultado, (array) $AC);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['row'] = $AC->row;
            $resultado[$i]['ActividadEconomica'] = $AC->desc_larga;
            $resultado[$i]['Estatus'] = $AC->estado_logico;

            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }
    #endregion

    #region Regimen Fiscal
    public function ActualizaRegimenFiscal()
    {

        $IdCliente = $this->request->getVar('IdCliente');
        $IdRegimen = $this->request->getVar('IdRegimen');

        $verificarClienteRegimen = $this->miClienteRegimenFiscal->where('id_cliente', $IdCliente)->where('id_regimen_fiscal', $IdRegimen)->find();

        if ($verificarClienteRegimen == null) {

            $id_clienteRegimen = $this->miClienteRegimenFiscal->insert([
                'id_estado_logico' => 1,
                'id_captura' => session()->get('id_usuario'),
                'f_captura' => date('Y-m-d H:i:s'),
                'id_cliente' => $IdCliente,
                'id_regimen_fiscal' => $IdRegimen,

            ]);

            if ($id_clienteRegimen > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {

            if ($verificarClienteRegimen[0]->id_estado_logico == 2) {
                $datosRegimenClientes = $this->miClienteRegimenFiscal->update(
                    $verificarClienteRegimen[0]->id_cliente_regimen_fiscal,
                    [
                        'id_estado_logico' => 1,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($datosRegimenClientes) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $datosRegimenClientes = $this->miClienteRegimenFiscal->update(
                    $verificarClienteRegimen[0]->id_cliente_regimen_fiscal,
                    [
                        'id_estado_logico' => 2,
                        'id_actualiza' => session()->get('id_usuario'),
                        'f_actualiza' => date('Y-m-d H:i:s'),
                    ]
                );

                if ($datosRegimenClientes) {
                    echo 1;
                } else {
                    echo 0;
                }
            }

        }
    }


    public function ObtenerRegimenFiscal()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $idCliente = $this->request->getVar('IdCliente');

        $RegimenCliente = $this->miClienteRegimenFiscal->getDatosRegimenbyCliente($idCliente);

        $i = 0;
        foreach ($RegimenCliente as $RC) {
            array_push($resultado, (array) $RC);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['row'] = $RC->row;
            $resultado[$i]['RegimenFiscal'] = $RC->desc_larga;
            $resultado[$i]['Estatus'] = $RC->estado_logico;

            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }
    #endregion



    public function ValidarRFC()
    {
        header('Content-Type: application/json');
        $resultado = [];

        $RFC = $this->request->getVar('RFC');

        $ValidandoRFC = $this->micliente->where('rfc', $RFC)->find();

        if ($ValidandoRFC != null) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function ValidarCURP()
    {
        header('Content-Type: application/json');
        $resultado = [];

        $CURP = $this->request->getVar('CURP');

        $ValidandoCURP = $this->micliente->where('curp', $CURP)->find();

        if ($ValidandoCURP != null) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function GetClientebyRFC()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $RFC = $this->request->getVar('RFC');
        $Nombre = $this->request->getVar('Nombre');

        $CienteRFC = $this->micliente->getClientebyRFC($RFC,$Nombre);

        $i = 0;
        foreach ($CienteRFC as $c) {
            array_push($resultado, (array) $c);
            //$resultado[$i]['row'] = $user->row;
            $resultado[$i]['row'] = $c->row;
            $resultado[$i]['RFC'] = $c->rfc;
            $resultado[$i]['CURP'] = $c->curp;
            $resultado[$i]['TipoCliente'] = $c->desc_larga;
            $resultado[$i]['NOmbreRS'] = $c->razon_social;


            if ($c->id_estado_logico == 1) {
                $resultado[$i]['Estatus'] = 'ACTIVO';
            } else {
                $resultado[$i]['Estatus'] = 'INACTIVO';
            }
            // $resultado[$i]['estado_logico'] = $soc->estado_logico;
            $resultado[$i]['acciones'] = '<button class="btn btn-primary btn-sm" onclick="EditarCliente(' . $c->id_cliente . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar cliente" >&nbsp;<i class="fa fa-pencil"></i></button>';

            $i++;
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function GetClientebyIdCliente()
    {

        header('Content-Type: application/json');
        $resultado = [];

        $IdCliente = $this->request->getVar('IdCliente');

        $ClienteID = $this->micliente->getClientebyIdCliente($IdCliente);

        $i = 0;
        foreach ($ClienteID as $c) {
            array_push($resultado, (array) $c);
        }

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    #region Actualizar Datos Generales
    function ActualizarDatosGenerales()
    {

        if ($this->request->getMethod() == 'post') {

            $tipo_cliente = $this->request->getVar('ddl_tipoCliente');

            if ($tipo_cliente == 1) {
                $reglasdatosGenerales = [
                    'ddl_tipoCliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El Tipo Cliente es obligatorio.'
                        ]
                    ],
                    'tbx_rfc_cliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo RFC es obligatorio.'
                        ]
                    ],
                    'tbx_razon_social' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Nombre o Razón Social es obligatorio.'
                        ]
                    ],
                    'tbx_curp_cliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo CURP es obligatorio.'
                        ]
                    ],

                ];
            } else {
                $reglasdatosGenerales = [
                    'ddl_tipoCliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El Tipo Cliente es obligatorio.'
                        ]
                    ],
                    'tbx_rfc_cliente' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo RFC es obligatorio.'
                        ]
                    ],
                    'tbx_razon_social' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'El campo Nombre o Razón Social es obligatorio.'
                        ]
                    ],

                ];
            }

            if (!$this->request->getMethod() == 'POST' || !$this->validate($reglasdatosGenerales) || $tipo_cliente == 0) {
                $errores = '';
                foreach ($this->validator->getErrors() as $error) {
                    $errores = $errores . ' ' . $error . "\n";
                }

                if ($tipo_cliente == 0) {
                    $errores = $errores . ' ' . 'El Tipo Cliente es obligatorio.' . "\n";
                }
                echo $errores;
                return;
            }

            $RFC = $this->request->getVar('tbx_rfc_cliente');
            $curp = $this->request->getVar('tbx_curp_cliente');
            $Nombre_razon_social = $this->request->getVar('tbx_razon_social');
            $estatus = 1;
            $idUsuario = session()->get('id_usuario');
            $id_cliente = intval($this->request->getVar('id_cliente'));

        }

        if ($id_cliente != 0) {
            $this->micliente->update(
                $id_cliente,
                [
                    'id_tipo_cliente' => $tipo_cliente,
                    'rfc' => $RFC,
                    'curp' => $curp,
                    'razon_social' => $Nombre_razon_social,
                    "id_actualiza" => $idUsuario,
                    "f_actualiza" => date('Y-m-d H:i:s')
                ]
            );

            if ($id_cliente > 0) {
                echo $id_cliente;
            } else {
                echo 0;
            }

        } else {
           
            echo 0;
        }

    }
#endregion
}