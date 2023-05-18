<div id="modalDatosClienteTResponsable" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalClienteTResponsable" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarClienteTResponsable(<?php echo $id_cliente_tresponsable ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Relación Cliente Responsable
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_cliente">Cliente:</label>
                            <textarea id="tbx_cliente" name="tbx_cliente" class="form-control" required="required"
                                tabindex="1" autocomplete="off" maxlength="300" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_responsable">Responsable:</label>
                            <textarea id="tbx_responsable" name="tbx_responsable" class="form-control" required="required"
                                tabindex="2" autocomplete="off" maxlength="300" readonly></textarea>

                        </div>
                    </div>

                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_cliente_tresponsable">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_cliente_tresponsable" id="ddl_estatus_cliente_tresponsable"
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
