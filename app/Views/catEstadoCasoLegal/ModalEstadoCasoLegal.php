<div id="modalDatosEstadoCasoLegal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalEstadoCasoLegal" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarEstadoCasoLegal(<?php echo $id_estado_caso_legal ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Seguimiento Caso Legal
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_desc_corta">Descripción Corta:</label>
                            <input type="text" id="tbx_desc_corta" name="tbx_desc_corta" class="form-control"
                                required="required" tabindex="1" autocomplete="off" maxlength="40">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_desc_larga">Descripción Larga:</label>
                            <textarea id="tbx_desc_larga" name="tbx_desc_larga"
                                class="form-control" required="required" tabindex="2" autocomplete="off" maxlength="90"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_estado_caso_legal">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_estado_caso_legal" id="ddl_estatus_estado_caso_legal"
                                tabindex="3">
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

