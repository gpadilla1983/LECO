<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Relación Cliente Régimen Fiscal<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>
<div class="app-title">
    <div>
        <h1><i class="fas fa-file-alt"></i>    Relación Cliente Régimen Fiscal</h1>
        <br />
        <br />
        <!--button class="btn btn-primary" type="button" id="btn_agregar_cliente_regimen_fiscal"><i class="fas fa-plus-circle"></i> Nuevo</button-->
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Relación Cliente Régimen Fiscal</a></li>
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
                <label class="control-label">Régimen Fiscal:</label>
                <select class="form-control" name="ddl_regimen_fiscal" id="ddl_regimen_fiscal" required="required">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($RegimenFiscal as $RegFisc) { ?>
                        <option value="<?php echo $RegFisc->id_regimen_fiscal; ?>">
                            <?php echo $RegFisc->desc_larga; ?>
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
                <table class="table table-hover table-bordered" id="table-cliente_regimen_fiscal">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <th class="text-center">Tipo de Cliente</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Régimen Fiscal</th>
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
<script src="<?= base_url(); ?>Assets/js/functions_cliente_regimen_fiscal.js"></script>
<?= $this->endSection(); ?>