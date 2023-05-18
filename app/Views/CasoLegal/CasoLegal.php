<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Caso Legal
<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>
<style>
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
        <h1><i class="fas fa-gavel"></i> Caso Legal</h1>
        <br />
        <br />
        <button class="btn btn-primary" type="button" id="btn-agregarcasolegal" onclick="nuevoCasoLegal()"><i class="fas fa-plus-circle"></i> Nuevo Caso Legal</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Caso Legal</a></li>
    </ul>
</div>


<!--------Búsqueda principal registrados-------->
<div class="tile" id="div_busqueda" name="div_busqueda">
    <div class="row">
        <div class="col-md-4">
            <label class="control-label" for="ddl_estatus_cliente_caso_legalB">Estatus:</label>
            <select class="form-control" name="ddl_estatus_cliente_caso_legalB" id="ddl_estatus_cliente_caso_legalB" tabindex="3">
                <option value="-1" selected>Todos</option>
                <?php foreach ($EstadoLogico as $EdoLog) { ?>
                    <option value="<?php echo $EdoLog->id_estado_logico; ?>"><?php echo $EdoLog->desc_larga; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="control-label">Núm. de Expediente</label>
            <input class="form-control" type="text" id="tbx_no_expedienteB" name="tbx_no_expedienteB"></input>
        </div>
        <div class="col-md-4">
            <label class="control-label">Tipo de Caso Legal</label>
            <select class="form-control" id="ddl_tipoCasoLegalB" name="ddl_tipoCasoLegalB" tabindex="1">
                <option value="-1" selected>Todos</option>
                <?php foreach ($TipoCasoLegal as $tc) { ?>
                    <option value="<?php echo $tc->id_tipo_caso_legal; ?>"><?php echo $tc->desc_larga; ?></option>
                <?php } ?>
            </select> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <br/>
            <label class="control-label">Pais</label>
            <select class="form-control" id="ddl_paisB" name="ddl_paisB" tabindex="5" onchange="ObtenerEntidadB(this)">
                <option value="-1" selected>Todos</option>
                <?php foreach ($Pais as $pa) { ?>
                    <option value="<?php echo $pa->id_pais; ?>"><?php echo $pa->desc_larga; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <br/>
            <label class="control-label">Estado</label>
            <select class="form-control" id="ddl_entidad_federativaB" name="ddl_entidad_federativaB" tabindex="2" onchange="ObtenermunicipioB(this)">
                <option value="-1" selected>Todos</option>
                    <?php foreach ($EntidadFederativa as $EF) { ?><option value="<?php echo $EF->id_entidad_federativa; ?>"><?php echo $EF->desc_larga; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <br/>
            <label class="control-label">Ciudad</label>
            <select class="form-control" id="ddl_alcaldia_municipioB" name="ddl_alcaldia_municipioB" tabindex="2">
                <option value="-1" selected>Todos</option>
                <?php foreach ($Municipio as $M) { ?>
                    <option value="<?php echo $M->id_alcaldia_municipio; ?>"><?php echo $M->desc_larga; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <br/>
            <label class="control-label">Juzgado</label>
            <select class="form-control" id="ddl_juzgadoB" name="ddl_juzgadoB" tabindex="5">
                <option value="-1" selected>Todos</option>
                <?php foreach ($Juzgado as $j) { ?><option value="<?php echo $j->id_juzgado; ?>"><?php echo $j->desc_larga;?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <br/>
            <br/>
            <label class="control-label">&nbsp;</label>
            <button class="btn btn-primary" onclick="BuscarCasoLegal()">Buscar</button>
        </div>
    </div>
</div>
<!-----Fin de Búsqueda principal registrados----->

<!--------Tabla de casos legales registrados------>
<div class="tile" id="div_CasosLegalesRegistrados" name="div_CasosLegalesRegistrados">
    <table class="table table-hover table-bordered" id="table-casos_legales">
        <thead>
            <tr style="background-color:gray; color:white">
                <th class="text-center">Núm.</th>
                <!--th class="text-center">ID.</th-->
                <th class="text-center">Tipo Caso Legal</th>
                <th class="text-center">Núm. de Expediente</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Pais, Estado, Ciudad</th>
                <th class="text-center">Fecha de Inicio</th>
                <th class="text-center">Fecha de Termino</th>
                <th class="text-center">Juzgado</th>
                <th class="text-center">Contraparte</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!---Termina tabla de casos legales registrados--->

<!------------Pestaña de Captura de Casos Legales---------->
<div class="tile" id="div_datosGenerales" name="div_datosGenerales">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Caso Legal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Expedientes</a>
            </li>
        </ul>
    </div>
    <br>
    <form id="formDatosGenerales" class="modal-content" method="POST">
        <input type="text" id="id_cliente_caso_legal" name="id_cliente_caso_legal" hidden></input> 
        <br>
        <div class="row" style="margin-left:5px">
            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Tipo de Caso Legal</label>
                    <select class="form-control" id="ddl_tipoCasoLegal" name="ddl_tipoCasoLegal" tabindex="1">
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($TipoCasoLegal as $tc) { ?>
                            <option value="<?php echo $tc->id_tipo_caso_legal; ?>"><?php echo $tc->desc_larga; ?></option>
                        <?php } ?>
                    </select> 
                </div>
                <div class="col-md-4">
                    <label class="control-label">Cliente</label>
                    <select class="form-control" id="ddl_Cliente" name="ddl_Cliente" tabindex="2">
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Cliente as $c) { ?>
                            <option value="<?php echo $c->id_cliente; ?>"><?php echo $c->razon_social; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="tbx_f_inicio">Fecha Inicio</label>
                        <input type="date" id="tbx_f_inicio" name="tbx_f_inicio" class="form-control" required="required" tabindex="3" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="tbx_f_termino">Fecha Término</label>
                        <input type="date" id="tbx_f_termino" name="tbx_f_termino" class="form-control" required="required" tabindex="4" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Juzgado</label>
                    <select class="form-control" id="ddl_juzgado" name="ddl_juzgado" tabindex="5">
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Juzgado as $j) { ?><option value="<?php echo $j->id_juzgado; ?>"><?php echo $j->desc_larga;?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="tbx_contraparte">Contraparte</label>
                        <input type="text" id="tbx_contraparte" name="tbx_contraparte" class="form-control" required="required" tabindex="4" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Pais</label>
                    <select class="form-control" id="ddl_pais" name="ddl_pais" tabindex="5" onchange="ObtenerEntidad(this)">
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Pais as $pa) { ?>
                            <option value="<?php echo $pa->id_pais; ?>"><?php echo $pa->desc_larga; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Estado</label>
                    <select class="form-control" id="ddl_entidad_federativa" name="ddl_entidad_federativa" tabindex="2" onchange="Obtenermunicipio(this)">
                        <option value="0" selected>Seleccione...</option>
                            <?php foreach ($EntidadFederativa as $EF) { ?><option value="<?php echo $EF->id_entidad_federativa; ?>"><?php echo $EF->desc_larga; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Ciudad</label>
                    <select class="form-control" id="ddl_alcaldia_municipio" name="ddl_alcaldia_municipio" tabindex="2">
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Municipio as $M) { ?>
                            <option value="<?php echo $M->id_alcaldia_municipio; ?>"><?php echo $M->desc_larga; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-12">
                    <br />
                    <label class="control-label">Descripción</label>
                    <textarea class="form-control" id="tbx_desc_larga" name="tbx_desc_larga" tabindex="4" required="required"></textarea>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <br />
                    <label class="control-label">No. de Expediente</label>
                    <input type="text" class="form-control" id="tbx_no_expediente" name="tbx_no_expediente" required="required" tabindex="4" autocomplete="off">
                </div>
                <div class="col-md-4" id="div_estatus">
                    <br />
                    <div class="form-group">
                        <label class="control-label" for="ddl_estatus_cliente_caso_legal">Estatus:</label>
                        <select class="form-control" name="ddl_estatus_cliente_caso_legal" id="ddl_estatus_cliente_caso_legal" tabindex="3">
                            <option value="0" selected>Seleccione...</option>
                            <?php foreach ($EstadoLogico as $EdoLog) { ?>
                                <option value="<?php echo $EdoLog->id_estado_logico; ?>"><?php echo $EdoLog->desc_larga; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-12" align="right">
                    <br>
                    <button type="button" class="btn btn-danger" id="btn_cancelar" name="btn_cancelar" onclick="Cancelar()">Cancelar</button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" id="btn_guardarDatosGenerales" name="btn_guardarDatosGenerales" 
                           onclick="AgregarActualizarDatosGenerales()">Guardar</button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" id="btn_irExpedientes" name="btn_irExpedientes" 
                           onclick="visualizarArchivos()">Expediente</button>
                    <br>
                    <br>
                </div>
                <br>
                <br>
            </div>
        </div>
    </form>
</div>
<!-------Fin de Pestaña de Captura de Casos Legales-------->

<!--------------Pestaña de carga de archivos--------------->
<div style="margin-left:10px" id="div_encabezado">
    <div class="row">
        <div class="col-md-12">
            <h4><label class="control-label">Expediente:  </label>
            <label class="control-label" id="tbx_numExpdiente" name="tbx_numExpdiente"></label> </h4>
        </div>
        <div class="col-md-12">
            <h4><label class="control-label">Nombre o Razón Social:  </label>
            <label class="control-label" id="tbx_razonSocial" name="tbx_razonSocial"></label> </h4>
        </div>
        <!--tbx_id_cliente2--><input type="text" id="tbx_id_cliente2" name="tbx_id_cliente2" hidden></input>
        <!--asunto_busqueda--><input type="text" id="tbx_asunto" name="tbx_asunto" hidden></input>
        <!--id_file_cliente--><input type="text" id="tbx_id_file_cliente" name="tbx_id_file_cliente" hidden></input>
        <!--id_cliente_caso_legal--><input type="text" id="tbx_id_cliente_caso_legal" name="id_cliente_caso_legal" hidden></input>        
    </div>
</div>
<div style="margin-left:10px" id="div_botonesArchivos">
    <br>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary" type="button" id="btn_buscar" onclick="buscarExpediente();"><i class="fa fa-search"></i>&nbsp;&nbsp;Ver Expediente</button>&nbsp;&nbsp;
            <button class="btn btn-primary" type="button" id="btn_agregar_file" onclick="capturaNuevoExpediente();"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Nuevo Documento                    
                </button>&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" id="btn_cancelarArchivos" name="btn_cancelarArchivos" onclick="habilitaInicio();">Finalizar</button>
        </div>
    </div>
</div>
<br>
<br>
<div class="tile" id="div_resultados">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-expediente">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Num.</th>
                            <th class="text-center">Asunto del Seguimiento/Documento</th>
                            <th class="text-center">Seguimiento</th>
                            <th class="text-center">Fecha de Seguimiento</th>
                            <th class="text-center">Tipo de Documento</th>
                            <th class="text-center">Fecha de Documento</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<br>
<br>
<div class="tile" id="div_archivos" name="div_archivos">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page">Caso Legal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Expedientes</a>
            </li>
        </ul>
    </div>
    <br/> 
    <form id="formArchivos" class="modal-content" method="POST">
        <div class="row col-md-12" style="margin-left:10px">
            <div class="row col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <br />  
                        <label class="control-label">Documento:</label><br>
                        <input type="file"  id="file_expediente" name="file_expediente" accept=".pdf" onchange="text_change(this)">
                    </div>
                </div>
                <div class="col-md-4">
                    <br/> 
                    <label class="control-label">Seguimiento del Caso Legal</label>
                    <select class="form-control" id="ddl_estatus_caso_legal" name="ddl_estatus_caso_legal" tabindex="2">
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($EstatusCasoLegal as $ECL) { ?>
                            <option value="<?php echo $ECL->id_estado_caso_legal; ?>"><?php echo $ECL->desc_larga; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <br/> 
                    <div class="form-group">
                        <label class="control-label" for="tbx_f_seguimiento">Fecha de Seguimiento</label>
                        <input type="date" id="tbx_f_seguimiento" name="tbx_f_seguimiento" class="form-control" required="required" tabindex="3" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-12">
                    <br />
                    <label class="control-label">Asunto del Seguimiento/Documento</label>
                    <textarea class="form-control" id="tbx_asuntoCap" name="tbx_asuntoCap" tabindex="4" required="required"></textarea>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <br/> 
                    <div class="form-group">
                        <label class="control-label" for="tbx_f_docto">Fecha del Documento</label>
                        <input type="date" id="tbx_f_docto" name="tbx_f_docto" class="form-control" required="required" tabindex="3" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <br />
                    <div class="form-group">
                        <label class="control-label" for="ddl_tipo_archivo">Tipo Documento:</label>
                        <select class="form-control" name="ddl_tipo_archivo" id="ddl_tipo_archivo" tabindex="5">
                            <option value="0" selected>Seleccione...</option>
                            <option value="1">Interno</option>
                            <option value="2">Interno y Externo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4" id="div_estatus_archivo">
                    <br />
                    <div class="form-group">
                        <label class="control-label" for="ddl_estatus_archivo">Estatus:</label>
                        <select class="form-control" name="ddl_estatus_archivo" id="ddl_estatus_archivo"
                            tabindex="6">
                            <option value="0" selected>Seleccione...</option>
                            <?php foreach ($EstadoLogico as $EdoLog) { ?>
                                <option value="<?php echo $EdoLog->id_estado_logico; ?>"><?php echo $EdoLog->desc_larga; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-12" align="right">
                    <br>
                    <button class="btn btn-primary" type="button" id="btn_verArchivo" onclick="ObtenerIdFileCliente();"><i class="fa fa-file-pdf"></i>&nbsp;&nbsp;Ver Archivo</button>&nbsp;&nbsp;
                    <button class="btn btn-danger" type="button" id="btn_cancelarArchivos" onclick="CancelarArchivos();">Cancelar</button>&nbsp;&nbsp;
                    <button class="btn btn-primary" type="button" id="btn_guardar" onclick="SubirArchivo();"><i
                            class="fas fa-file-upload"></i>&nbsp;&nbsp;Guardar y Subir Archivo</button>&nbsp;&nbsp;
                    <button class="btn btn-primary" type="button" id="btn_guardarSinArchivo" onclick="ActualizarExpedienteSinArchivo();">Guardar</button>      
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade modalVisor" id="modalVisor" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <iframe id="iframe_visor" src="" frameborder="0" height="600" width="100%"></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-----------Fin de Pestaña de carga de archivos----------->

<?= $this->endSection(); ?>

<?= $this->section('FooterContent'); ?>
<script src="<?= base_url(); ?>Assets/js/functions_cliente_file_caso_legal.js"></script>
<?= $this->endSection(); ?>