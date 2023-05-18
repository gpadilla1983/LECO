<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Expedientes
<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>
<div class="app-title">
    <div>
        <h1><i class="fas fa-folder"></i> Expedientes</h1>
        <br />
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Expedientes</a></li>
    </ul>
</div>

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

<div style="margin-left:10px" id="div_encabezado">
    <div class="row">
        <div class="col-md-12">
            <h4><label class="control-label">Expediente:  </label>
            <label class="control-label" id="tbx_numExpdiente" name="tbx_numExpdiente"></label></h4>
        </div>
        <div class="col-md-12">
            <h4><label class="control-label">Nombre o Razón Social:  </label>
            <label class="control-label" id="tbx_razonSocial" name="tbx_razonSocial"></label></h4> 
        </div>
        <!--tbx_id_cliente2--><input type="text" id="tbx_id_cliente2" name="tbx_id_cliente2" hidden></input>
        <!--asunto_busqueda--><input type="text" id="tbx_asunto" name="tbx_asunto" hidden></input>
        <!--id_file_cliente--><input type="text" id="tbx_id_file_cliente" name="tbx_id_file_cliente" hidden></input>
        <!--id_cliente_caso_legal--><input type="text" id="tbx_id_cliente_caso_legal" name="id_cliente_caso_legal" hidden></input>        
    </div>
</div>

<div class="tile" id="div_datosGenerales" name="div_datosGenerales">
    <div class="row col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Detalle de Caso Legal</a>
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
                    <select class="form-control" id="ddl_tipoCasoLegal" name="ddl_tipoCasoLegal" tabindex="1" disabled>
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($TipoCasoLegal as $tc) { ?>
                            <option value="<?php echo $tc->id_tipo_caso_legal; ?>"><?php echo $tc->desc_larga; ?></option>
                        <?php } ?>
                    </select> 
                </div>
                <div class="col-md-4">
                    <label class="control-label">Cliente</label>
                    <select class="form-control" id="ddl_Cliente" name="ddl_Cliente" tabindex="2" disabled>
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Cliente as $c) { ?>
                            <option value="<?php echo $c->id_cliente; ?>"><?php echo $c->razon_social; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="tbx_f_inicio">Fecha Inicio</label>
                        <input type="date" id="tbx_f_inicio" name="tbx_f_inicio" class="form-control" required="required" tabindex="3" autocomplete="off" disabled>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="tbx_f_termino">Fecha Término</label>
                        <input type="date" id="tbx_f_termino" name="tbx_f_termino" class="form-control" required="required" tabindex="4" autocomplete="off" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Juzgado</label>
                    <select class="form-control" id="ddl_juzgado" name="ddl_juzgado" tabindex="5" disabled>
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Juzgado as $j) { ?><option value="<?php echo $j->id_juzgado; ?>"><?php echo $j->desc_larga;?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="tbx_contraparte">Contraparte</label>
                        <input type="text" id="tbx_contraparte" name="tbx_contraparte" class="form-control" required="required" tabindex="6" autocomplete="off" disabled>
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Pais</label>
                    <select class="form-control" id="ddl_pais" name="ddl_pais" tabindex="7" onchange="ObtenerEntidad(this)" disabled>
                        <option value="0" selected>Seleccione...</option>
                        <?php foreach ($Pais as $pa) { ?>
                            <option value="<?php echo $pa->id_pais; ?>"><?php echo $pa->desc_larga; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Estado</label>
                    <select class="form-control" id="ddl_entidad_federativa" name="ddl_entidad_federativa" tabindex="8" onchange="Obtenermunicipio(this)" disabled>
                        <option value="0" selected>Seleccione...</option>
                            <?php foreach ($EntidadFederativa as $EF) { ?><option value="<?php echo $EF->id_entidad_federativa; ?>"><?php echo $EF->desc_larga; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Ciudad</label>
                    <select class="form-control" id="ddl_alcaldia_municipio" name="ddl_alcaldia_municipio" tabindex="9" disabled>
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
                    <textarea class="form-control" id="tbx_desc_larga" name="tbx_desc_larga" tabindex="10" required="required" disabled></textarea>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-4">
                    <br />
                    <label class="control-label">No. de Expediente</label>
                    <input type="text" class="form-control" id="tbx_no_expediente" name="tbx_no_expediente" required="required" tabindex="11" autocomplete="off" disabled>
                </div>
                <div class="col-md-4" id="div_estatus">
                    <br />
                    <div class="form-group">
                        <label class="control-label" for="ddl_estatus_cliente_caso_legal">Estatus:</label>
                        <select class="form-control" name="ddl_estatus_cliente_caso_legal" id="ddl_estatus_cliente_caso_legal" tabindex="12" disabled>
                            <option value="0" selected>Seleccione...</option>
                            <?php foreach ($EstadoLogico as $EdoLog) { ?>
                                <option value="<?php echo $EdoLog->id_estado_logico; ?>"><?php echo $EdoLog->desc_larga; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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
                            <!--th class="text-center">Estatus</th-->
                            <th class="text-center">Documentos</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<div class="tile" align="right" id="div_botonesArchivos">
    <br>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="btn_cancelarArchivos" name="btn_cancelarArchivos" onclick="habilitaInicio();">Finalizar</button>
        </div>
    </div>
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

<?= $this->endSection(); ?>

<?= $this->section('FooterContent'); ?>
<script src="<?= base_url(); ?>Assets/js/functions_expedientes.js"></script>
<?= $this->endSection(); ?>