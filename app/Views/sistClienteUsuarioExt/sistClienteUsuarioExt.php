<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Relación Cliente - Usuario Externo<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>

<div class="app-title">
    <div>
        <h1><i class="fas fa-user-secret"></i>    Relación Cliente - Usuario Externo</h1>
        <br />
        <br />
        <button class="btn btn-primary" type="button" id="btn_agregar_cliente_usuario_ext"><i class="fas fa-plus-circle"></i> Nuevo</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Relación Cliente - Usuario Externo</a></li>
    </ul>
</div>

<div class="tile">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Estatus:</label>
                <select class="form-control" name="ddl_estatus" id="ddl_estatus" tabindex="1" required="required">
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
            <label class="control-label">Cliente:</label>
            <select class="form-control" id="ddl_clienteb" name="ddl_clienteb"
            tabindex="2" required="required">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($Cliente as $Cli) { ?>
                        <option value="<?php echo $Cli->id_cliente; ?>">
                            <?php echo $Cli->razon_social ?>
                        </option>
                    <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="control-label">Usuario Externo Asignado:</label>
            <select class="form-control" id="ddl_usuariob" name="ddl_usuariob" 
            tabindex="3" required="required">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($Usuario as $U) { ?>
                        <option value="<?php echo $U->id_usuario; ?>">
                            <?php echo $U->nombre . ' ' . $U->primer_apellido . ' ' . $U->segundo_apellido ?>
                        </option>
                    <?php } ?>
            </select>
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
                <table class="table table-hover table-bordered" id="table-cliente_usuario_ext">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Núm.</th>
                            <!--th class="text-center">Id_usuario_externo_cliente</th-->
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Usuario Externo Asignado</th>
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
<script src="<?= base_url(); ?>Assets/js/functions_cliente_usuario_ext.js"></script>
<?= $this->endSection(); ?>