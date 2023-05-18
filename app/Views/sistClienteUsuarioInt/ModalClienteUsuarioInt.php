<div id="modalDatosClienteUsuarioInt" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalClienteUsuarioInt" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarClienteUsuarioInt(<?php echo $id_usuario_cliente ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Relación Cliente - Usuario Interno
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
                        <label class="control-label">Usuario Asignado:</label>
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
                    <div class="col-md-4">
                        <label class="control-label">Usuario Auxiliar:</label>
                        <select class="form-control" id="ddl_usuario_aux" name="ddl_usuario_aux" 
                        tabindex="3">
                                <option value="0" selected>
                                            No aplica...
                                </option>
                                <?php foreach ($UsuarioAux as $UA) {?>
                                    <option value="<?php echo $UA->id_usuario; ?>">
                                        <?php echo $UA->nombre . ' ' . $UA->primer_apellido . ' ' . $UA->segundo_apellido?>
                                    </option>
                                <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_cliente_usuario_int">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_cliente_usuario_int" id="ddl_estatus_cliente_usuario_int"
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

