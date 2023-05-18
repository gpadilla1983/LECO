<div id="modalDatosJuzgado" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalJuzgado" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarJuzgado(<?php echo $id_juzgado ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Juzgado
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_num_juzgado">Número del Juzgado:</label>
                            <input type="text" id="tbx_num_juzgado" name="tbx_num_juzgado" class="form-control"
                                required="required" tabindex="1" autocomplete="off" maxlength="4">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_desc_larga">Datos del Juzgado:</label>
                            <input type="text" id="tbx_desc_larga" name="tbx_desc_larga"
                                class="form-control" required="required" tabindex="2" autocomplete="off" maxlength="450">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">País:</label>
                        <select class="form-control" id="ddl_pais" name="ddl_pais" tabindex="3" onchange="ObtenerEntidad(this)">
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
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">Estado:</label>
                        <select class="form-control" id="ddl_entidad" name="ddl_entidad" onchange="Obtenermunicipio(this)"
                        tabindex="4">
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
                        <label class="control-label">Cuidad:</label>
                        <select class="form-control" id="ddl_municipio" name="ddl_municipio" 
                        tabindex="5">
                        <option value="0" selected>
                                            Seleccione...
                                </option>
                                <?php foreach ($Municipio as $M) { ?>
                                    <option value="<?php echo $M->id_alcaldia_municipio; ?>">
                                        <?php echo $M->desc_larga ?>
                                    </option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_juzgado">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_juzgado" id="ddl_estatus_juzgado"
                                tabindex="6">
                                <?php foreach ($EstadoLogico as $EdoLog) { ?>
                                    <option value="<?php echo $EdoLog->id_estado_logico; ?>">
                                        <?php echo $EdoLog->desc_larga; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary pull-right" type="submit">
                    <?= $accion ?>
                </button>
            </div>
        </form>
    </div>
</div>

