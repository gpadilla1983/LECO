<div id="modalDatosTipoResponsable" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalTipoResponsable" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarTipoResponsable(<?php echo $id_tipo_responsable ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Tipo Responsable
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
                            <label class="control-label" for="ddl_estatus_tipo_responsable">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_tipo_responsable" id="ddl_estatus_tipo_responsable"
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

