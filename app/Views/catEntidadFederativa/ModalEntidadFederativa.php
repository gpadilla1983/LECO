<div id="modalDatosEntidadFed" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalEntidadFed" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarEntidadFed(<?php echo $id_entidad_federativa ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Estado
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">País:</label>
                        <select class="form-control" id="ddl_pais" name="ddl_pais" tabindex="1">
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
                        <div class="form-group">
                            <label class="control-label" for="tbx_desc_corta">Descripción Corta:</label>
                            <input type="text" id="tbx_desc_corta" name="tbx_desc_corta" class="form-control"
                                required="required" tabindex="2" autocomplete="off" maxlength="4">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_desc_larga">Descripción Larga:</label>
                            <input type="text" id="tbx_desc_larga" name="tbx_desc_larga"
                                class="form-control" required="required" tabindex="3" autocomplete="off" maxlength="450">
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_entidad_federativa">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_entidad_federativa" id="ddl_estatus_entidad_federativa"
                                tabindex="4">
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

