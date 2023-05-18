<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Seguimiento Caso Legal<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>

<div class="app-title">
    <div>
        <h1><i class="fas fa-swatchbook"></i>    Seguimiento Caso Legal</h1>
        <br />
        <br />
        <button class="btn btn-primary" type="button" id="btn_agregar_estado_caso_legal"><i class="fas fa-plus-circle"></i> Nuevo</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Seguimiento Caso Legal</a></li>
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
        <div class="form-group col-md-4 align-self-end">
            <button class="btn btn-primary" type="button" onclick="btn_consultarClick()" id="btn_buscar"><i class="fa fa-fw fa-lg fa fa-search"></i>Buscar</button>
        </div>
    </div>
</div>


<div class="tile" id="div_resultados" >
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-estado_caso_legal">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Num.</th>
                            <th class="text-center">Descripción Corta</th>
                            <th class="text-center">Descripción Larga</th>
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
<script src="<?= base_url(); ?>Assets/js/functions_estado_caso_legal.js"></script>
<?= $this->endSection(); ?>