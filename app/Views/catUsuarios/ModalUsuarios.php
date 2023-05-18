<div id="modalDatosUsuario" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalUsuario" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarUsuario(<?php echo $id_usuario ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Usuario
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_nombre_usuario">Nombre:</label>
                            <input type="text" id="tbx_nombre_usuario" name="tbx_nombre_usuario" class="form-control"
                                required="required" tabindex="1" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_apellidop_usuario">Primer apellido:</label>
                            <input type="text" id="tbx_apellidop_usuario" name="tbx_apellidop_usuario"
                                class="form-control" required="required" tabindex="2" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_apellidom_usuario">Segundo apellido:</label>
                            <input type="text" id="tbx_apellidom_usuario" name="tbx_apellidom_usuario"
                                class="form-control" required="required" tabindex="3" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_email_usuario">Correo electrónico:</label>
                            <input type="email" id="tbx_email_usuario" name="tbx_email_usuario" class="form-control"
                                required="required" tabindex="4" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_usuario">Usuario:</label>
                            <input type="text" id="tbx_usuario" name="tbx_usuario" class="form-control"
                                required="required" tabindex="5" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4" id="div_contrasena">
                        <div class="form-group">
                            <label class="control-label" for="tbx_contrasena">Contraseña:</label>
                            <input type="password" id="tbx_contrasena" name="tbx_contrasena" class="form-control"
                                 tabindex="6" autocomplete="off">
                           
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_rfc">RFC:</label>
                            <input type="text" id="tbx_rfc" name="tbx_rfc" class="form-control" required="required"
                                tabindex="7" autocomplete="off" maxlength="15" 
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                <input type="hidden" id="valor_check" name="valor_check">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_curp">CURP:</label>
                            <input type="text" id="tbx_curp" name="tbx_curp" class="form-control" required="required"
                                tabindex="8" autocomplete="off" maxlength="25"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_puesto">Puesto:</label>
                            <textarea id="tbx_puesto" name="tbx_puesto" class="form-control"
                                required="required" tabindex="9" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_tel_fijo">Teléfono Fijo:</label>
                            <input type="text" id="tbx_tel_fijo" name="tbx_tel_fijo" class="form-control" required="required"
                                tabindex="18" autocomplete="off" 
                                onkeypress="return event.charCode>=48 && event.charCode<=57"maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_movil">Celular:</label>
                            <input type="text" id="tbx_movil" name="tbx_movil" class="form-control" required="required"
                                tabindex="10" autocomplete="off"
                                onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_fec_nac">Fecha de nacimiento:</label>
                            <input type="date" id="tbx_fec_nac" name="tbx_fec_nac" class="form-control"
                                required="required" tabindex="11" autocomplete="off">
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_calle">Calle:</label>
                            <textarea type="text" id="tbx_calle" name="tbx_calle" class="form-control" required="required"
                                tabindex="13" autocomplete="off" maxlength="200"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_no_exterior">No. Exterior:</label>
                            <input type="text" id="tbx_no_exterior" name="tbx_no_exterior" class="form-control" required="required"
                                tabindex="14" autocomplete="off" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_no_interior">No. Interior:</label>
                            <input type="text" id="tbx_no_interior" name="tbx_no_interior" class="form-control" required="required"
                                tabindex="15" autocomplete="off" maxlength="15">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_colonia">Colonia:</label>
                            <textarea id="tbx_colonia" name="tbx_colonia" class="form-control" required="required"
                                tabindex="16" autocomplete="off" maxlength="200"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_codigo_postal">Código Postal:</label>
                            <input type="text" id="tbx_codigo_postal" name="tbx_codigo_postal" class="form-control" required="required"
                                tabindex="17" autocomplete="off" maxlength="5">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="ddl_pais">Pais:</label>
                            <select class="form-control" name="ddl_pais" id="ddl_pais" tabindex="19" onchange="ObtenerEntidad(this)">
                                <option value="0" selected="true" disabled="disabled"> -- Seleccione --</option>
                                <?php foreach ($Pais as $pa) { ?>
                                    <option value="<?php echo $pa->id_pais; ?>">
                                        <?php echo $pa->desc_larga; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="ddl_entidad_federativa">Estado:</label>
                            <select class="form-control" name="ddl_entidad_federativa" id="ddl_entidad_federativa" tabindex="20" onchange="Obtenermunicipio(this)">
                                <option value="0" selected="true" disabled="disabled"> -- Seleccione --</option>
                                <?php foreach ($EntidadFederativa as $EF) { ?>
                                    <option value="<?php echo $EF->id_entidad_federativa; ?>">
                                        <?php echo $EF->desc_larga; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="ddl_alcaldia_municipio">Ciudad:</label>
                            <select class="form-control" name="ddl_alcaldia_municipio" id="ddl_alcaldia_municipio" tabindex="21">
                                <option value="0" selected="true" disabled="disabled"> -- Seleccione --</option>
                                <?php foreach ($Municipio as $M) { ?>
                                    <option value="<?php echo $M->id_alcaldia_municipio; ?>">
                                        <?php echo $M->desc_larga; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="ddl_role">Perfil:</label>
                            <select class="form-control" name="ddl_role" id="ddl_role" tabindex="22">
                                <option value="0" selected="true" disabled="disabled"> -- Seleccione --</option>
                                <?php foreach ($Perfiles as $per) { ?>
                                    <option value="<?php echo $per->id_perfil; ?>">
                                        <?php echo $per->desc_larga; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_fec_ingreso">Fecha de ingreso:</label>
                            <input type="date" id="tbx_fec_ingreso" name="tbx_fec_ingreso" class="form-control"
                                required="required" tabindex="12" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_usuario">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_usuario" id="ddl_estatus_usuario"
                                tabindex="23">
                                <?php foreach ($EstadoLogico as $EdoLog) { ?>
                                    <option value="<?php echo $EdoLog->id_estado_logico; ?>">
                                        <?php echo $EdoLog->desc_larga; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row" id="div_checkbox">
                    <div class="col-md-4">
                        <input type="checkbox" id="chbx_restablecer" value="si"><label for="chbx_restablecer"
                            class="control-label"> &nbsp;&nbsp;Reestablecer contraseña</label>
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

