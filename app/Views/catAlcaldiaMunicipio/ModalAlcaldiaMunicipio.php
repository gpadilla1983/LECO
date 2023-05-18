<div id="modalDatosAlcaldiaMun" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalAlcaldiaMun" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarAlcaldiaMun(<?php echo $id_alcaldia_municipio ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Ciudad
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">Estado:</label>
                        <select class="form-control" id="ddl_entidad" name="ddl_entidad" tabindex="1">
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
                        <div class="form-group">
                            <label class="control-label" for="tbx_desc_corta">Descripción Corta:</label>
                            <input type="text" id="tbx_desc_corta" name="tbx_desc_corta" class="form-control"
                                required="required" tabindex="2" onkeypress="return event.charCode>=48 && event.charCode<=57" 
                                autocomplete="off" maxlength="4">
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
                            <label class="control-label" for="ddl_estatus_alcaldia_municipio">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_alcaldia_municipio" id="ddl_estatus_alcaldia_municipio"
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

