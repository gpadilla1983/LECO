<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Usuarios<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>

<div class="app-title">
    <div>
        <h1><i class="fas fa-user-cog"></i>    Usuarios del sistema</h1>
        <br />
        <br />
        <button class="btn btn-primary" type="button" id="btn_agregar_usuario"><i class="fas fa-plus-circle"></i> Nuevo</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
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
                <label class="control-label">Perfil:</label>
                <select class="form-control" name="ddl_perfil" id="ddl_perfil">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($Perfiles as $per) { ?>
                        <option value="<?php echo $per->id_perfil; ?>">
                            <?php echo $per->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Pais:</label>
                <select class="form-control" name="ddl_paisb" id="ddl_paisb" onchange="ObtenerEntidadB(this)">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($Pais as $pa) { ?>
                        <option value="<?php echo $pa->id_pais; ?>">
                            <?php echo $pa->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Estado:</label>
                <select class="form-control" name="ddl_entidad_federativab" id="ddl_entidad_federativab" onchange="ObtenermunicipioB(this)">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($EntidadFederativa as $EF) { ?>
                        <option value="<?php echo $EF->id_entidad_federativa; ?>">
                            <?php echo $EF->desc_larga; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Ciudad:</label>
                <select class="form-control" name="ddl_alcaldia_municipiob" id="ddl_alcaldia_municipiob">
                    <option value="-1" selected>
                        Todos
                    </option>
                    <?php foreach ($Municipio as $M) { ?>
                        <option value="<?php echo $M->id_alcaldia_municipio; ?>">
                            <?php echo $M->desc_larga; ?>
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
                <table class="table table-hover table-bordered" id="table-usuarios">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Num.</th>
                            <th class="text-center">Nombre Completo</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Correo Electrónico</th>
                            <th class="text-center">Perfil</th>
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
<script src="<?= base_url(); ?>Assets/js/functions_usuarios.js"></script>
<?= $this->endSection(); ?>