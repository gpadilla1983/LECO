<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Cliente
<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>
<style>
    #tbx_rfc_cliente {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_rfc_cliente.ok {
        background-color: #EAFAF1;
    }

    #resultado {
        color: red;
        font-weight: bold;
    }
    #resultado.ok {
        color: green;
        font-weight: bold;
    }

    #tbx_curp_cliente {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_curp_cliente.ok {
        background-color: #EAFAF1;
    }

    #resultadoCURP {
        color: red;
        font-weight: bold;
    }
    #resultadoCURP.ok {
        color: green;
        font-weight: bold;
    }

    #busqueda_rfc {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #busqueda_rfc.ok {
        background-color: #EAFAF1;
    }

    #resultadoRFCBusqueda {
        color: red;
        font-weight: bold;
    }
    #resultadoRFCBusqueda.ok {
        color: green;
        font-weight: bold;
    }

    #tbx_rfc_socio {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_rfc_socio.ok {
        background-color: #EAFAF1;
    }

    #resultadoRFCSocio {
        color: red;
        font-weight: bold;
    }
    #resultadoRFCSocio.ok {
        color: green;
        font-weight: bold;
    }


    #tbx_curp_socio {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_curp_socio.ok {
        background-color: #EAFAF1;
    }

    #resultadoCURPSocio {
        color: red;
        font-weight: bold;
    }
    #resultadoCURPSocio.ok {
        color: green;
        font-weight: bold;
    }

     /* siguen Reponsables */
     #tbx_rfc_responsable {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_rfc_responsable.ok {
        background-color: #EAFAF1;
    }

    #resultadoRFCResponsable {
        color: red;
        font-weight: bold;
    }
    #resultadoRFCResponsable.ok {
        color: green;
        font-weight: bold;
    }


    #tbx_curp_responsable {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_curp_responsable.ok {
        background-color: #EAFAF1;
    }

    #resultadoCURPResponsable {
        color: red;
        font-weight: bold;
    }
    #resultadoCURPResponsable.ok {
        color: green;
        font-weight: bold;
    }

/* validaciones correos */

    #tbx_mail {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_mail.ok {
        background-color: #EAFAF1;
    }

    #resultadoEmailCliente{
        color: red;
        font-weight: bold;
    }
    #resultadoEmailCliente.ok {
        color: green;
        font-weight: bold;
    }

    #tbx_mailS {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_mailS.ok {
        background-color: #EAFAF1;
    }

    #resultadoEmailSocio{
        color: red;
        font-weight: bold;
    }
    #resultadoEmailSocio.ok {
        color: green;
        font-weight: bold;
    }

    #tbx_mail_responsable {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_mail_responsable.ok {
        background-color: #EAFAF1;
    }

    #resultadoMailResponsable{
        color: red;
        font-weight: bold;
    }
    #resultadoMailResponsable.ok {
        color: green;
        font-weight: bold;
    }


    
    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    form .text-error {
        color: red;
    }
</style>


<div class="app-title">
    <div>
        <h1><i class="fas fa-address-book"></i> Clientes</h1>
        <br />
        <br />
        <button class="btn btn-primary" type="button" id="btn-agregarclientes" onclick="nuevoCliente()"><i
                class="fas fa-plus-circle"></i>
            Nuevo cliente</button>

    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Clientes</a></li>
    </ul>
</div>

<div class="tile" id="div_busqueda" name="div_busqueda">
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">RFC</label>
            <input type="text" class="form-control" id="busqueda_rfc" name="busqueda_rfc" oninput="validarRFCBusqueda(this.value)"   onKeyUp="this.value = this.value.toUpperCase ();" autocomplete="off">
            <pre id="resultadoRFCBusqueda"></pre>
        </div>
        <div class="col-md-4">
            <label class="control-label">Nombre o Razón Social</label>
            <input class="form-control" type="text" id="tbx_razon_socialB" name="tbx_razon_socialB"></input>
        </div>
        <div class="col-md-1">
            <label class="control-label">&nbsp;</label>
            <button class="btn btn-primary" onclick="BuscarRFCCliente()">Buscar</button>
        </div>
    </div>
</div>

<!-- comienza captura de clientes registrados -->

<div class="tile" id="div_clientesRegistrados" name="div_clientesRegistrados">
    <table class="table table-hover table-bordered" id="table-clientes">
        <thead>
            <tr style="background-color:gray; color:white">
                <th class="text-center">Núm.</th>
                <th class="text-center">Tipo de cliente</th>
                <th class="text-center">RFC</th>
                <th class="text-center">Nombre completo</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="tile" id="div_clientesRegistradosFisica" name="div_clientesRegistradosFisica">
    <table class="table table-hover table-bordered" id="table-clientesFisica">
        <thead>
            <tr style="background-color:gray; color:white">
                <th class="text-center">Núm.</th>
                <th class="text-center">Tipo de cliente</th>
                <th class="text-center">RFC</th>
                <th class="text-center">CURP</th>
                <th class="text-center">Nombre completo</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<!-- Termina tabla de clientes registrado -->

<div class="tile" id="div_identificacionCliente" name="div_identificacionCliente">
    <div class="col-md-12">
        <label class="control-label">RFC:  </label>
        <label class="control-label" id="lbl_rfc" name="lbl_rfc"><b></b></label> 
    </div>
    <div class="col-md-12">
        <label class="control-label">Nombre o Razón Social:  </label>
        <label class="control-label" id="lbl_razonSocial" name="lbl_razonSocial"><b></b></label> 
    </div>
</div>

<!-- Comienza Captura de datos generales -->

<div class="tile" id="div_datosGenerales" name="div_datosGenerales">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Datos Generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Domicilio Fiscal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Socios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Responsables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Actividad Económica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Regimen Fiscal</a>
            </li>
        </ul>
    </div>
    <br>
    <form id="formDatosGenerales" class="modal-content" method="POST">

        <br>
        <div class="row" style="margin-left:5px">
            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Tipo de Cliente</label>
                    <select class="form-control" id="ddl_tipoCliente" name="ddl_tipoCliente"
                        onchange="tipoCliente(this.value)">
                        <option value="0" selected>
                            Seleccione...
                        </option>
                        <?php foreach ($tipoCliente as $tc) { ?>
                            <option value="<?php echo $tc->id_tipo_cliente; ?>">
                                <?php echo $tc->desc_larga; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="text" id="id_cliente" name="id_cliente" hidden></input>
                </div>
                <div class="col-md-4">
                    <label class="control-label">RFC</label>
                    <input class="form-control" type="text" id="tbx_rfc_cliente" name="tbx_rfc_cliente" required
                        onchange="validarRFC(this.value)" onKeyUp="this.value = this.value.toUpperCase ();" autocomplete="off"></input>
                        <pre id="resultado"></pre>
                </div>
                <div class="col-md-4">
                    <label class="control-label">CURP</label>
                    <input class="form-control" type="text" id="tbx_curp_cliente" name="tbx_curp_cliente" required
                        onchange="validarCURP(this.value)" onKeyUp="this.value = this.value.toUpperCase ();" autocomplete="off"></input>
                        <pre id="resultadoCURP"></pre>
                </div>

            </div>

            <div class="row col-md-12">
                <div class="col-md-12">
                    <br />
                    <label class="control-label">Nombre o Razón Social</label>
                    <input class="form-control" type="text" id="tbx_razon_social" name="tbx_razon_social"
                        required></input>
                </div>
            </div>

            <div class="row col-md-12">
                <div class="col-md-12" align="right">
                    <br>
                    <button type="button" class="btn btn-primary" id="btn_regresar" name="btn_regresar"
                        onclick="BusquedaCliente()">Regresar</button>
                    <button type="button" class="btn btn-primary" id="btn_guardarDatosGenerales"
                        name="btn_guardarDatosGenerales" onclick="AgregarActualizarDatosGenerales()">Continuar</button>
                    <button type="button" class="btn btn-primary" id="btn_ActualizarDatosGenerales"
                        name="btn_ActualizarDatosGenerales" onclick="ActualizarDatosGenerales()">Continuar</button>

                </div>
            </div>

        </div>
        <br>
    </form>
</div>

<!-- Termina Captura de Datos Generales -->

<!-- Datos del Domicilio Fiscal -->

<div class="tile" id="div_domicilioFiscal" name="div_domicilioFiscal">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Datos Generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Domicilio Fiscal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Socios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Responsables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Actividad Económica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Regimen Fiscal</a>
            </li>
        </ul>
    </div>
    <br>
    <form id="formDomicilioFiscal" class="modal-content" method="POST">

        <br>
        <div class="row" style="margin-left:5px">

            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Calle</label>
                    <input class="form-control" type="text" id="tbx_calle" name="tbx_calle"></input>
                    <input type="hidden" id="id_clienteD" name="id_clienteD"></input>
                    <input type="hidden" id="tipo_cliente" name="tipo_cliente"></input>
                </div>
                <div class="col-md-4">
                    <label class="control-label">No.Exterior</label>
                    <input class="form-control" type="text" id="tbx_no_exterior" name="tbx_no_exterior"></input>
                </div>
                <div class="col-md-4">
                    <label class="control-label">No.Interior</label>
                    <input class="form-control" type="text" id="tbx_no_interior" name="tbx_no_interior"></input>
                </div>

            </div>
            <br>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Colonia</label>
                    <input class="form-control" type="text" id="tbx_colonia" name="tbx_colonia"></input>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Entre calle</label>
                    <input class="form-control" type="text" id="tbx_entre_calle" name="tbx_entre_calle"></input>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Y calle</label>
                    <input class="form-control" type="text" id="tbx_y_calle" name="tbx_y_calle"></input>
                </div>
            </div>
            <br>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <br>
                    <label class="control-label">País</label>
                    <select class="form-control" id="ddl_pais" name="ddl_pais" onchange="ObtenerEntidad(this)">
                        <option value="0" selected>
                            Seleccione...
                        </option>
                        <?php foreach ($Pais as $p) { ?>
                            <option value="<?php echo $p->id_pais; ?>">
                                <?php echo $p->desc_larga ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Estado</label>
                    <select class="form-control" id="ddl_entidad" name="ddl_entidad" onchange="Obtenermunicipio(this)">
                        <option value="0" selected>
                            Seleccione...
                        </option>
                        <?php foreach ($EntidadFederativa as $EF) { ?>
                            <option value="<?php echo $EF->id_entidad_federativa; ?>">
                                <?php echo $EF->desc_larga ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Ciudad</label>
                    <select class="form-control" id="ddl_municipio" name="ddl_municipio">

                    </select>
                </div>
            </div>
            <br>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Código Postal</label>
                    <input class="form-control" type="text" id="tbx_cp" name="tbx_cp"></input>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">E-mail</label>
                    <input class="form-control" oninput="validarEmail(this.value, 'tbx_mail')" type="text" id="tbx_mail" name="tbx_mail"
                        autocomplete="off"></input>
                    <pre id='resultadoEmailCliente'></pre>
                </div>

                <div class="col-md-4">
                    <br>
                    <label class="control-label">Teléfono</label>
                    <input class="form-control" type="text" id="tbx_telefono" name="tbx_telefono"
                        onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="10"></input>
                </div>
            </div>

            <div class="row col-md-12">
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Notaria</label>
                    <select class="form-control" id="ddl_notaria" name="ddl_notaria">
                        <option value="0" selected>
                            Seleccione...
                        </option>
                        <?php foreach ($Notaria as $Nt) { ?>
                            <option value="<?php echo $Nt->id_notaria_publica; ?>">
                                <?php echo $Nt->no_notaria . ' - ' . $Nt->nombre_notario ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Número de escritura</label>
                    <input class="form-control" type="text" id="tbx_no_escritura" name="tbx_no_escritura"></input>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Fecha de escritura</label>
                    <input class="form-control" type="date" id="tbx_fecha_escritura" name="tbx_fecha_escritura"></input>
                </div>
            </div>

            <div class="row col-md-12">
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Folio mercantil</label>
                    <input class="form-control" type="text" id="tbx_folio_mercantil" name="tbx_folio_mercantil"></input>
                </div>
                <div class="col-md-4">
                    <br>
                    <label class="control-label">Fecha de registro</label>
                    <input class="form-control" type="date" id="tbx_fecha_registro" name="tbx_fecha_registro"></input>
                </div>
            </div>
            <div class="row col-md-12" id="div_botones">
                <div class="col-md-12" align="right">
                    <br>
                    <button type="button" class="btn btn-primary" id="btn_regresar" name="btn_regresar"
                        onclick="DatosGenerales()">Regresar</button>
                    <button type="button" class="btn btn-primary btnvalida" id="btn_guardarDomicilio"
                        name="btn_guardarDomicilio" onclick="ActualizarDomicilio()">Continuar</button>

                    <br>
                </div>
            </div>
        </div>
        <br>
    </form>
</div>

<!-- Termina captura de datos de Domicilio Fiscal -->

<!-- Datos de los socios -->

<div class="tile" id="div_socios" name="div_socios">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Datos Generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page">Domicilio Fiscal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Socios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Responsables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Actividad Económica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Regimen Fiscal</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="modal-content">
        <br>
        <div class="row col-md-12" style="margin-left:5px; margin-right:5px">
            <button class="btn btn-primary" type="button" id="btn_agregar_socio"><i class="fas fa-plus-circle"></i>
                Nuevo socio</button>
        </div>
        <br>
        <div class="row col-md-12" style="margin-left:5px; margin-right:5px" id="divTablaSocios" name="divTablaSocios">
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-socios">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <th class="text-center">RFC</th>
                            <th class="text-center">CURP</th>
                            <th class="text-center">Nombre completo</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row" id="div_btnContinuarResponsable">
            <div class="col-md-12" style="margin-left:-10px" align="right">
                <button class="btn btn-primary" id="btn_continuarResponsables"
                    onclick="ContinuarResponsables()">Continuar</button>
            </div>
        </div>
        <div class="row" style="margin-left:5px; margin-right:5px" id="div_captura_socios" name="div_captura_socios">
            <div class="col-md-12">
                <h3 id="lbl_titulo_socios" name="lbl_titulo_socios"></h3>
                <input type="hidden" name="id_clienteS" id="id_clienteS">
                <input type="hidden" name="id_socioS" id="id_socioS" value="0">
                <input type="hidden" name="id_cliente_socio" id="id_cliente_socio" value="0">
            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_rfc_socio">RFC:</label>
                <div class="input-group">
                    <input type="text" id="tbx_rfc_socio" name="tbx_rfc_socio" class="form-control" required="required"
                        tabindex="1" autocomplete="off" maxlength="15" oninput="validarRFCSocio(this.value)" 
                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                    <a class="btn btn-primary" onclick="buscarRFC()">
                        <span class="fa fa-search" aria-hidden="true" style="color:white"></span>
                    </a><br>
                </div>
                <pre id="resultadoRFCSocio"></pre>
            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_nombre_socio">Nombre:</label>
                <input type="text" id="tbx_nombre_socio" name="tbx_nombre_socio" class="form-control"
                    required="required" tabindex="2" autocomplete="off" maxlength="150">

            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_primer_apellido">Primer Apellido:</label>
                <input type="text" id="tbx_primer_apellido" name="tbx_primer_apellido" class="form-control"
                    required="required" tabindex="3" autocomplete="off" maxlength="150">

            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_segundo_apellido">Segundo Apellido:</label>
                <input type="text" id="tbx_segundo_apellido" name="tbx_segundo_apellido" class="form-control"
                    required="required" tabindex="4" autocomplete="off" maxlength="150">

            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_curp_socio">CURP:</label>
                <input type="text" id="tbx_curp_socio" name="tbx_curp_socio" class="form-control" required="required"
                    tabindex="5" autocomplete="off" maxlength="25" oninput="validarCURPSocio(this.value)"
                    onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <pre id="resultadoCURPSocio"></pre>
            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label">E-mail</label>
                <input class="form-control"  type="text" id="tbx_mailS" name="tbx_mailS"
                    autocomplete="off" tabindex="6" oninput="validarEmail(this.value, 'tbx_mailS')"></input>
                    <pre id='resultadoEmailSocio'></pre>
            </div>
            <div class="col-md-4" id="div_estatus">
                <br>
                <label class="control-label" for="ddl_estatus_socio">Estatus:</label>
                <select class="form-control" name="ddl_estatus_socio" id="ddl_estatus_socio" tabindex="7">
                    <?php foreach ($EstadoLogico as $EdoLog) { ?>
                        <option value="<?php echo $EdoLog->id_estado_logico; ?>">
                            <?php echo $EdoLog->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>

            </div>
            <div class="col-md-12" align="right">
                <br>
                <button class="btn btn-danger" onclick="Cerrar()">Cancelar</button>
                <button class="btn btn-primary" onclick="guardarSocios()">
                    Guardar
                </button>
            </div>
        </div>
        <br>

    </div>
</div>

<!-- Termina datos de los socios -->

<!-- Datos de los Responsables -->

<div class="tile" id="div_Responsable" name="div_Responsable">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Datos Generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page">Domicilio Fiscal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Socios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Responsables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Actividad Económica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Regimen Fiscal</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="modal-content">
        <br>
        <div class="row col-md-12" style="margin-left:5px; margin-right:5px">
            <button class="btn btn-primary" type="button" id="btn_agregar_responsable"><i
                    class="fas fa-plus-circle"></i>
                Nuevo Responsable</button>
        </div>
        <br>
        <div class="row col-md-12" style="margin-left:5px; margin-right:5px" id="divTablaResponsable"
            name="divTablaResponsable">
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-Responsable">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <th class="text-center">RFC</th>
                            <th class="text-center">CURP</th>
                            <th class="text-center">Nombre completo</th>
                            <th class="text-center">Tipo responsable</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row" id="div_btnContinuarResponsable">
            <div class="col-md-12" style="margin-left:-10px" align="right">
                <button class="btn btn-primary" id="btn-continuarActividad"
                    onclick="ContinuarActividad()">Continuar</button>
            </div>
        </div>
        <div class="row" style="margin-left:5px; margin-right:5px" id="div_captura_responsable"
            name="div_captura_responsable">
            <div class="col-md-12">
                <h3 id="lbl_titulo_responsable" name="lbl_titulo_responsable"></h3>
                <input type="hidden" name="id_responsableS" id="id_responsableS" value="0">
                <input type="hidden" name="id_cliente_responsable" id="id_cliente_responsable" value="0">
                <!-- <input type="text" name="id_cliente_tipo_responsable" id="id_cliente_tipo_responsable" value="0"> -->
            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_rfc_responsable">RFC:</label>
                <div class="input-group">
                    <input type="text" id="tbx_rfc_responsable" name="tbx_rfc_responsable" class="form-control"
                        required="required" tabindex="1" autocomplete="off" maxlength="15" oninput="validarRFCResponsable(this.value)" 
                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                    <a class="btn btn-primary" onclick="buscarRFCResponsable();">
                        <span class="fa fa-search" aria-hidden="true" style="color:white"></span>
                    </a>
                </div>
                <pre id="resultadoRFCResponsable"></pre>
            </div>
            <div class="col-md-4" id="div_tipo_resp">
                <br>
                <label class="control-label" for="ddl_tipo_responsable">Tipo Responsable:</label>
                <select class="form-control" name="ddl_tipo_responsable" id="ddl_tipo_responsable" tabindex="2">
                    <option value="0" selected>
                        Seleccione...
                    </option>
                    <?php foreach ($TipoResponsable as $TipoResp) { ?>
                        <option value="<?php echo $TipoResp->id_tipo_responsable; ?>">
                            <?php echo $TipoResp->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_nombre_responsable">Nombre:</label>
                <input type="text" id="tbx_nombre_responsable" name="tbx_nombre_responsable" class="form-control"
                    required="required" tabindex="3" autocomplete="off" maxlength="150">

            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_primer_apellido_responsable">Primer Apellido:</label>
                <input type="text" id="tbx_primer_apellido_responsable" name="tbx_primer_apellido_responsable"
                    class="form-control" required="required" tabindex="4" autocomplete="off" maxlength="150">

            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_segundo_apellido_responsable">Segundo Apellido:</label>
                <input type="text" id="tbx_segundo_apellido_responsable" name="tbx_segundo_apellido_responsable"
                    class="form-control" required="required" tabindex="5" autocomplete="off" maxlength="150">

            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label" for="tbx_curp_responsable">CURP:</label>
                <input type="text" id="tbx_curp_responsable" name="tbx_curp_responsable" class="form-control"
                    required="required" tabindex="6" autocomplete="off" maxlength="25" oninput="validarCURPResponsable(this.value)" 
                    onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                    <pre id="resultadoCURPResponsable"></pre>
            </div>
            <div class="col-md-4">
                <br>
                <label class="control-label">E-mail</label>
                <input class="form-control"  type="text" id="tbx_mail_responsable" name="tbx_mail_responsable" oninput="validarEmail(this.value,'tbx_mail_responsable')" 
                    autocomplete="off" tabindex="7"></input>
                    <pre id="resultadoMailResponsable"></pre>
            </div>
            <div class="col-md-4" id="div_estatus_resp">
                <br>
                <label class="control-label" for="ddl_estatus_responsable">Estatus:</label>
                <select class="form-control" name="ddl_estatus_responsable" id="ddl_estatus_responsable" tabindex="8">
                    <?php foreach ($EstadoLogico as $EdoLog) { ?>
                        <option value="<?php echo $EdoLog->id_estado_logico; ?>">
                            <?php echo $EdoLog->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-12" align="right">
                <br>
                <button class="btn btn-danger" onclick="CerrarResponsable()">Cancelar</button>
                <button class="btn btn-primary" onclick="GuardarResponsable()">
                    Guardar
                </button>
            </div>
        </div>
        <br>

    </div>
</div>



<!-- Termina datos de los Responsable -->

<!-- Actividad Economica -->
<div class="tile" id="divActividad" name="divActividad">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Datos Generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page">Domicilio Fiscal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Socios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Responsables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Actividad Económica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Regimen Fiscal</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="modal-content">

        <div class="row col-md-12" style="margin-left:5px; margin-right:5px; margin-top:10px">
            <button class="btn btn-primary" type="button" id="btn_agregar_actividad"><i class="fas fa-eye"></i>
                Actividades Económicas</button>
        </div>

        <div class="row col-md-12" style="margin-left:5px; margin-right:5px; margin-top:20px" id="divTablaActividad"
            name="divTablaActividad">
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-Actividad">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <th class="text-center">Actividad Económica</th>
                            <th class="text-center">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row" id="div_btnContinuarResponsable">
            <div class="col-md-12" style="margin-left:-10px" align="right">
                <button class="btn btn-primary" id="btn-continuarRegimen"
                    onclick="ContinuarRegimen()">Continuar</button>
            </div>
        </div>
        <div class="row" style="margin-left:50px; margin-right:5px;" id="div_capturarActividad"
            name="div_capturarActividad">
            <h3 id="lbl_titulo_Actividad" name="lbl_titulo_Actividad"></h3><br><br>
            <div class="col-md-12" id="div_chbxActividad">
                <div class="toggle">
                    <?php foreach ($ActividadEconomica as $AE) { ?>

                        <label>
                            <input type="checkbox" id="chbx_<?= $AE->id_actividad_economica ?>" name="checks[]"
                                value="<?= $AE->id_actividad_economica ?>" onchange="GuardaCheck(this.value)"><span
                                class="button-indecator">
                                <?= $AE->desc_larga ?>
                            </span>
                        </label>
                        <br>
                    <?php } ?>
                </div>
                <div hidden>Ids seleccionados en matriz <span id="arr"></span></div>
                <div hidden>Ids seleccionados <span id="str"></span></div>
            </div>
            <div class="col-md-12" align="right">
                <br>
                <button class="btn btn-primary" onclick="CerrarActividad()">Regresar</button>
                <!-- <button class="btn btn-primary" onclick="GuardarActividad()">
                    Guardar
                </button> -->
            </div>
        </div>
        <br>

    </div>
</div>




<!-- Termina Actividad Economica -->


<!-- Regimen Fiscal -->

<div class="tile" id="divRegimenFiscal" name="divRegimenFiscal">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Datos Generales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page">Domicilio Fiscal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Socios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Responsables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Actividad Económica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Regimen Fiscal</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="modal-content">

        <div class="row col-md-12" style="margin-left:5px; margin-right:5px; margin-top:10px">
            <button class="btn btn-primary" type="button" id="btn_agregar_regimen"><i class="fas fa-eye"></i>
                Regimen Fiscal</button>
        </div>

        <div class="row col-md-12" style="margin-left:5px; margin-right:5px; margin-top:20px" id="divTablaRegimen"
            name="divTablaRegimen">
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-Regimen">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <th class="text-center">Regimen Fiscal</th>
                            <th class="text-center">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-left:50px; margin-right:5px;" id="div_capturarRegimen"
            name="div_capturarRegimen">
            <h3 id="lbl_titulo_Regimen" name="lbl_titulo_Regimen"></h3><br><br>
            <div class="col-md-12" id="div_chbxRegimen">
                <div class="toggle">
                    <?php foreach ($RegimenFiscal as $RF) { ?>

                        <label>
                            <input type="checkbox" id="chbxR_<?= $RF->id_regimen_fiscal ?>" name="checks[]"
                                value="<?= $RF->id_regimen_fiscal ?>" onchange="GuardaCheckRegimen(this.value)"><span
                                class="button-indecator">
                                <?= $RF->desc_larga ?>
                            </span>
                        </label>
                        <br>
                    <?php } ?>
                </div>
                <div hidden>Ids seleccionados en matriz <span id="arrReg"></span></div>
                <div hidden>Ids seleccionados <span id="arrReg"></span></div>
            </div>
            <div class="col-md-12" align="right">
                <br>
                <button class="btn btn-primary" onclick="CerrarRegimen()">Regresar</button>
                <!-- <button class="btn btn-primary" onclick="GuardarActividad()">
                    Guardar
                </button> -->
            </div>
        </div>
        <br>
        <div class="row" id="div_btnFinalizarCaptura">
            <div class="col-md-12" style="margin-left:-10px" align="right">
                <button class="btn btn-primary" id="btn_fianalizar_captura"
                    onclick="FinalizarCaptura()">Finalizar</button>
            </div>
        </div>
        <br>
    </div>
</div>



<!-- Termina Regimen Fiscal -->


<?= $this->endSection(); ?>

<?= $this->section('FooterContent'); ?>
<script src="<?= base_url(); ?>Assets/js/functions_capturaCliente.js"></script>
<script src="<?= base_url(); ?>Assets/js/functions_validaciones.js"></script>
<?= $this->endSection(); ?>