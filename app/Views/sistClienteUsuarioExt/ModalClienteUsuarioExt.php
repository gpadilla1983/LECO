<div id="modalDatosClienteUsuarioExt" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalClienteUsuarioExt" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarClienteUsuarioExt(<?php echo $id_usuario_externo_cliente ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Relación Cliente - Usuario Externo
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">Cliente:</label>
                        <select class="form-control" id="ddl_cliente" name="ddl_cliente"
                        tabindex="1">
                                <option value="0" selected>
                                            Seleccione...
                                </option>
                                <?php foreach ($Cliente as $Cli) { ?>
                                    <option value="<?php echo $Cli->id_cliente; ?>">
                                        <?php echo $Cli->razon_social ?>
                                    </option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Usuario Externo Asignado:</label>
                        <select class="form-control" id="ddl_usuario" name="ddl_usuario" 
                        tabindex="2">
                        <option value="0" selected>
                                            Seleccione...
                                </option>
                                <?php foreach ($Usuario as $U) { ?>
                                    <option value="<?php echo $U->id_usuario; ?>">
                                        <?php echo $U->nombre . ' ' . $U->primer_apellido . ' ' . $U->segundo_apellido ?>
                                    </option>
                                <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_cliente_usuario_ext">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_cliente_usuario_ext" id="ddl_estatus_cliente_usuario_ext"
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

