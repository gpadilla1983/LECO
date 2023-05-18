<style>
    #tbx_rfc_responsable {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_rfc_responsable.ok {
        background-color: #EAFAF1;
    }

    #resultadoRFCResponsable {
        color: red;
        font-weight: bold;
    }
    #resultadoRFCResponsable.ok {
        color: green;
        font-weight: bold;
    }


    #tbx_curp_responsable{
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_curp_responsable.ok {
        background-color: #EAFAF1;
    }

    #resultadoCurpResponsable {
        color: red;
        font-weight: bold;
    }
    #resultadoCurpResponsable.ok {
        color: green;
        font-weight: bold;
    }

    #tbx_email_responsable {
        background-color: #FADBD8;
        color: black;
        font-weight: bold;
    }
    #tbx_email_responsable.ok {
        background-color: #EAFAF1;
    }

    #resultadoMailResponsable{
        color: red;
        font-weight: bold;
    }
    #resultadoMailResponsable.ok {
        color: green;
        font-weight: bold;
    }

</style>

<div id="modalDatosResponsable" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formModalResponsable" class="modal-content" method="POST"
            onsubmit="return AgregarActualizarResponsable(<?php echo $id_responsable ?>)" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $accion ?> Responsable
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_nombre_responsable">Nombre:</label>
                            <input type="text" id="tbx_nombre_responsable" name="tbx_nombre_responsable" class="form-control"
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
                            <label class="control-label" for="tbx_rfc_responsable">RFC:</label>
                            <input type="text" id="tbx_rfc_responsable" name="tbx_rfc_responsable" class="form-control" oninput="validarRFCResponsable(this.value)"
                                required="required" tabindex="4" autocomplete="off" maxlength="15"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                <pre id="resultadoRFCResponsable"></pre>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_curp_responsable">CURP:</label>
                            <input type="text" id="tbx_curp_responsable" name="tbx_curp_responsable"
                                class="form-control" required="required" tabindex="5" autocomplete="off" maxlength="25" oninput="validarCURPResponsable(this.value)"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                <pre id="resultadoCurpResponsable"></pre>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="tbx_email_responsable">Correo electrónico:</label>
                            <input type="email" id="tbx_email_responsable" name="tbx_email_responsable" oninput="validarEmail(this.value,'tbx_email_responsable')"
                                class="form-control" required="required" tabindex="6" autocomplete="off">
                                <pre id="resultadoMailResponsable"></pre>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" id="div_estatus">
                        <div class="form-group">
                            <label class="control-label" for="ddl_estatus_responsable">Estatus:</label>
                            <select class="form-control" name="ddl_estatus_responsable" id="ddl_estatus_responsable"
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

