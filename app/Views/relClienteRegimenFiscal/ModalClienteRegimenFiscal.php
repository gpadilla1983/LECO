<div id="modalDatosClienteRegimenFiscal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalClienteRegimenFiscal" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarClienteRegimenFiscal(<?php echo $id_cliente_regimen_fiscal ?>)" enctype="multipart/form-data">
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
                            <label class="control-label" for="tbx_regimen_fiscal">Régimen Fiscal:</label>
                            <textarea id="tbx_regimen_fiscal" name="tbx_regimen_fiscal" class="form-control" required="required"
                                tabindex="3" autocomplete="off" maxlength="300" readonly></textarea>

                        </div>
                    </div>

                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_cliente_regimen_fiscal">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_cliente_regimen_fiscal" id="ddl_estatus_cliente_regimen_fiscal"
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
