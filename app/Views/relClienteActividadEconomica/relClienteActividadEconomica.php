<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Relación Cliente Actividad Económica<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>
<div class="app-title">
    <div>
        <h1><i class="fas fa-chart-bar"></i>    Relación Cliente Actividad Económica</h1>
        <br />
        <br />
        <!--button class="btn btn-primary" type="button" id="btn_agregar_cliente_actividad_economica"><i class="fas fa-plus-circle"></i> Nuevo</button-->
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Relación Cliente Actividad Económica</a></li>
    </ul>
</div>

<div class="tile">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Estatus:</label>
                <select class="form-control" name="ddl_estatus" id="ddl_estatus" required="required">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($EstadoLogico as $EdoLog) { ?>
                        <option value="<?php echo $EdoLog->id_estado_logico; ?>">
                            <?php echo $EdoLog->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Tipo Cliente:</label>
                <select class="form-control" name="ddl_tipo_cliente" id="ddl_tipo_cliente" required="required">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($TipoCliente as $TipoCli) { ?>
                        <option value="<?php echo $TipoCli->id_tipo_cliente; ?>">
                            <?php echo $TipoCli->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Actividad Económica:</label>
                <select class="form-control" name="ddl_actividad_economica" id="ddl_actividad_economica" required="required">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($ActividadEconomica as $ActEco) { ?>
                        <option value="<?php echo $ActEco->id_actividad_economica; ?>">
                            <?php echo $ActEco->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4 align-self-end">
            <button class="btn btn-primary" type="button" onclick="btn_consultarClick()" id="btn_buscar"><i class="fa fa-fw fa-lg fa fa-search"></i>Buscar</button>
        </div>
    </div>
</div>


<div class="tile" id="div_resultados" >
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-cliente_actividad_economica">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <th class="text-center">Tipo de Cliente</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Actividad Económica</th>
                            <th class="text-center">Usuario de Captura</th>
                            <th class="text-center">Fecha de Captura</th>
                            <th class="text-center">Usuario de Actualización</th>
                            <th class="text-center">Fecha de Actualización</th>
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


<?= $this->endSection(); ?>

<?= $this->section('FooterContent'); ?>
<script src="<?= base_url(); ?>Assets/js/functions_cliente_actividad_economica.js"></script>
<?= $this->endSection(); ?>