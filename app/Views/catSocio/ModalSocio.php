<style>
    #tbx_rfc_socio {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_rfc_socio.ok {
        background-color: #EAFAF1;
    }

    #resultadoRFCSocio {
        color: red;
        font-weight: bold;
    }
    #resultadoRFCSocio.ok {
        color: green;
        font-weight: bold;
    }


    #tbx_curp_socio {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_curp_socio.ok {
        background-color: #EAFAF1;
    }

    #resultadoCurpSocio {
        color: red;
        font-weight: bold;
    }
    #resultadoCurpSocio.ok {
        color: green;
        font-weight: bold;
    }

    #tbx_email_socio {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_email_socio.ok {
        background-color: #EAFAF1;
    }

    #resultadoMailSocio{
        color: red;
        font-weight: bold;
    }
    #resultadoMailSocio.ok {
        color: green;
        font-weight: bold;
    }

</style>

<div id="modalDatosSocio" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalSocio" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarSocio(<?php echo $id_socio ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Socio
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_nombre_socio">Nombre:</label>
                            <input type="text" id="tbx_nombre_socio" name="tbx_nombre_socio" class="form-control"
                                required="required" tabindex="1" autocomplete="off" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_primer_apellido">Primer Apellido:</label>
                            <input type="text" id="tbx_primer_apellido" name="tbx_primer_apellido"
                                class="form-control" required="required" tabindex="2" autocomplete="off" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_segundo_apellido">Segundo Apellido:</label>
                            <input type="text" id="tbx_segundo_apellido" name="tbx_segundo_apellido"
                                class="form-control" required="required" tabindex="3" autocomplete="off" maxlength="150">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_rfc_socio">RFC:</label>
                            <input type="text" id="tbx_rfc_socio" name="tbx_rfc_socio" class="form-control" oninput="validarRFCSocio(this.value)"
                                required="required" tabindex="4" autocomplete="off" maxlength="15"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                <pre id="resultadoRFCSocio"></pre>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_curp_socio">CURP:</label>
                            <input type="text" id="tbx_curp_socio" name="tbx_curp_socio"
                                class="form-control" required="required" tabindex="5" autocomplete="off" maxlength="25" oninput="validarCURPSocio(this.value)" 
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                <pre id="resultadoCurpSocio"></pre>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Correo electrónico:</label>
                            <input class="form-control" required="required" tabindex="6" type="text" id="tbx_email_socio" name="tbx_email_socio"  oninput="validarEmail(this.value,'tbx_email_socio')" 
                            autocomplete="off">
                            <pre id="resultadoMailSocio"></pre>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_socio">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_socio" id="ddl_estatus_socio"
                                tabindex="7">
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
