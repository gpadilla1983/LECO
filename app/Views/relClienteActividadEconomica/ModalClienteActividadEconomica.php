<div id="modalDatosClienteActividadEconomica" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalClienteActividadEconomica" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarClienteActividadEconomica(<?php echo $id_cliente_actividad_economica ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Relación Cliente Regimen Fiscal
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_tipo_cliente">Tipo de Cliente:</label>
                            <textarea id="tbx_tipo_cliente" name="tbx_tipo_cliente" class="form-control" required="required"
                                tabindex="1" autocomplete="off" maxlength="300" readonly></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_cliente">Cliente:</label>
                            <textarea id="tbx_cliente" name="tbx_cliente" class="form-control" required="required"
                                tabindex="2" autocomplete="off" maxlength="300" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_actividad_economica">Actividad Economica:</label>
                            <textarea id="tbx_actividad_economica" name="tbx_actividad_economica" class="form-control" required="required"
                                tabindex="3" autocomplete="off" maxlength="300" readonly></textarea>

                        </div>
                    </div>

                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_cliente_actividad_economica">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_cliente_actividad_economica" id="ddl_estatus_cliente_actividad_economica"
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
