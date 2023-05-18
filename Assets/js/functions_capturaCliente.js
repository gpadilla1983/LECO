$(document).ready(function () {
  ObtenerChecksSelecionados();
  $("#tbx_curp_cliente").prop("disabled", true);
  $("#tbx_rfc_cliente").prop("disabled", true);
  $("#tbx_razon_social").prop("disabled", true);
  $("#div_identificacionCliente").hide();
});

$("#div_domicilioFiscal").hide();
$("#div_datosGenerales").hide();
$("#div_clientesRegistrados").hide();
$("#div_socios").hide();
$("#div_captura_socios").hide();
$("#div_estatus").hide();
$("#div_Responsable").hide();
$("#divActividad").hide();
$("#divRegimenFiscal").hide();
$("#div_captura_responsable").hide();
$("#div_estatus_resp").hide();
$("#divTablaSocios").hide();
$("#divTablaResponsable").hide();
$("#div_capturarActividad").hide();
$("#div_capturarRegimen").hide();
$("#div_clientesRegistradosFisica").hide();
$("#btn_ActualizarDatosGenerales").hide();
$("#btn_guardarDatosGenerales").hide();

function limpia_campos() {
  tbx_rfc_cliente.classList.remove("ok");
  resultado.classList.remove("ok");
  resultado.innerText = "";
  tbx_curp_cliente.classList.remove("ok");
  resultadoCURP.classList.remove("ok");
  resultadoCURP.innerText = "";

  tbx_mail.classList.remove("ok");
  resultadoEmailCliente.classList.remove("ok");
  resultadoEmailCliente.innerText = "";

  tbx_mailS.classList.remove("ok");
  resultadoEmailSocio.classList.remove("ok");
  resultadoEmailSocio.innerText = "";

  document.getElementById("id_cliente").value = "";
  document.getElementById("ddl_tipoCliente").value = 0;
  document.getElementById("tbx_rfc_cliente").value = "";
  document.getElementById("tbx_curp_cliente").value = "";
  document.getElementById("tbx_razon_social").value = "";
  document.getElementById("tbx_calle").value = "";
  document.getElementById("tbx_no_exterior").value = "";
  document.getElementById("tbx_no_interior").value = "";
  document.getElementById("tbx_colonia").value = "";
  document.getElementById("tbx_entre_calle").value = "";
  document.getElementById("tbx_y_calle").value = "";
  document.getElementById("ddl_pais").value = 0;
  document.getElementById("ddl_entidad").value = 0;
  document.getElementById("ddl_municipio").value = 0;
  document.getElementById("tbx_cp").value = "";
  document.getElementById("tbx_mail").value = "";
  document.getElementById("tbx_telefono").value = "";
  document.getElementById("ddl_notaria").value = 0;
  document.getElementById("tbx_no_escritura").value = "";
  document.getElementById("tbx_fecha_escritura").value = "";
  document.getElementById("tbx_folio_mercantil").value = "";
  document.getElementById("tbx_fecha_registro").value = "";
}

function nuevoCliente() {
  limpia_campos();
  limpiarDatatableSocios();
  $("#div_datosGenerales").show();
  $("#div_domicilioFiscal").hide();
  $("#div_clientesRegistrados").hide();
  $("#div_busqueda").hide();
  $("#tbx_id_cliente").val(0);
  $("#div_socios").hide();
  $("#div_Responsable").hide();
  $("#tbx_curp_cliente").prop("disabled", true);
  $("#tbx_rfc_cliente").prop("disabled", true);
  $("#tbx_razon_social").prop("disabled", true);
  $("#btn_ActualizarDatosGenerales").hide();
  $("#btn_guardarDatosGenerales").show();
}

function limpiarDatatableSocios() {
  var table = $("#table-socios").DataTable();

  table.clear().draw();
}

function DatosGenerales() {
  $("#div_datosGenerales").show();
  $("#div_domicilioFiscal").hide();
}

function DomicilioFiscal() {
  // if($("#ddl_tipoCliente").val() == 0 && $("#tbx_rfc_cliente").val() == "" && $("#tbx_curp_cliente").val()==""){
  //     // swal("Error", "Lo sentimos no has registrado ningun cliente", "error");
  // }else{
  // }
}

async function ObtenerEntidad(ddl_pais) {
  var ddl_pais = $("#ddl_pais").val();
  if (ddl_pais != null) {
    await $.ajax({
      type: "GET",
      url: base_url + "catalogos/ObtenerEntidad/" + ddl_pais,
      dataType: "json",
      beforeSend: function () {},
      success: function (respuesta) {
        var datos = respuesta;
        var opciones = '<option value = "0" selected>Seleccione...</option>';
        datos.forEach((element) => {
          var cadena =
            "<option value=" +
            element.id_entidad_federativa +
            "> " +
            element.desc_larga +
            "</option>";
          opciones = opciones + cadena;
        });

        $("#ddl_entidad").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "0" selected>Seleccione...</option>';
    $("#ddl_entidad").html(opciones);
  }
}

async function Obtenermunicipio(ddl_entidad) {
  var ddl_entidad = $("#ddl_entidad").val();
  if (ddl_entidad != null) {
    await $.ajax({
      type: "GET",
      url: base_url + "catalogos/ObtenerMunicipios/" + ddl_entidad,
      dataType: "json",
      beforeSend: function () {},
      success: function (respuesta) {
        var datos = respuesta;
        var opciones = '<option value = "0">Seleccione...</option>';
        datos.forEach((element) => {
          var cadena =
            "<option value=" +
            element.id_alcaldia_municipio +
            "> " +
            element.desc_larga +
            "</option>";
          opciones = opciones + cadena;
        });

        $("#ddl_municipio").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "0" selected>Seleccione...</option>';
    $("#ddl_municipio").html(opciones);
  }
}

function quesigue() {
  var id_tipoCliente = $("#ddl_tipoCliente").val();

  if (id_tipoCliente == 1) {
    alert("lleva a regimen fiscal");
  } else {
    alert("lleva a socios");
  }
}

async function AgregarActualizarDatosGenerales() {
  var tipo_cliente = $("#ddl_tipoCliente").val();
  IdentificacionCliente();

  await $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "clientes/AgregarActualizarDatosGenerales",
    data: $("#formDatosGenerales").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});

      if (respuesta > 0) {
        swal("Puede continuar capturando Domicilio Fiscal", "", "success");
        $("#div_datosGenerales").hide();
        $("#div_domicilioFiscal").show();
        $("#id_cliente").val(respuesta);
        $("#id_clienteD").val(respuesta);
        $("#tipo_cliente").val(tipo_cliente);
      } else {
        if (respuesta == -1) {
          swal(
            "La información fue actualiza con éxito, puede seguir capturando",
            "",
            "success"
          );
          $("#div_datosGenerales").hide();
          $("#div_domicilioFiscal").show();
          $("#tipo_cliente").val(tipo_cliente);
        } else {
          if (respuesta == 0) {
            swal("Error", "No se ha podido enviar información", "error");
          } else {
            swal("Error", respuesta, "error");
          }
        }
      }
    },
  });

  return false;
}

function ActualizarDomicilio() {
  var tipo_cliente = $("#ddl_tipoCliente").val();

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "clientes/ActualizarDomicilio",
    data: $("#formDomicilioFiscal").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});

      if (respuesta > 0) {
        $("#div_datosGenerales").hide();
        $("#div_domicilioFiscal").hide();
        if (tipo_cliente == 1) {
          //$("#div_Responsable").hide();
          $("#divActividad").show(); //Hay que cambiar y redireccionar hacia donde va la persona fisica
          $("#id_cliente").val(respuesta);
          $("#id_clienteD").val(respuesta);
          $("#id_clienteS").val(respuesta);
          obtenerActividades();
          swal("Puede continuar capturando Actividad Económica", "", "success");
        } else {
          if (tipo_cliente == 2) {
            $("#div_socios").show();
            $("#id_cliente").val(respuesta);
            $("#id_clienteD").val(respuesta);
            $("#id_clienteS").val(respuesta);
            swal("Puede continuar capturando Socios", "", "success");
            obtenerSocios();
          }
        }
      } else {
        if (respuesta == 0) {
          swal("Error", "No se ha podido enviar información", "error");
        } else {
          swal("Error", respuesta, "error");
        }
      }
    },
  });

  return false;
}

//funciones de socios

function limpia_camposSocios() {
  tbx_rfc_socio.classList.remove("ok");
  resultadoRFCSocio.classList.remove("ok");
  resultadoRFCSocio.innerText = "";
  tbx_curp_socio.classList.remove("ok");
  resultadoCURPSocio.classList.remove("ok");
  resultadoCURPSocio.innerText = "";

  tbx_mailS.classList.remove("ok");
  resultadoEmailSocio.classList.remove("ok");
  resultadoEmailSocio.innerText = "";

  $("#id_socioS").val("");
  $("#tbx_rfc_socio").val("");
  $("#tbx_nombre_socio").val("");
  $("#tbx_primer_apellido").val("");
  $("#tbx_segundo_apellido").val("");
  $("#tbx_curp_socio").val("");
  $("#tbx_mailS").val("");
  $("#ddl_estatus_socio").val(1);
}

$("#btn_agregar_socio").bind("click", async (e) => {
  limpia_camposSocios();
  $("#btn-agregarclientes").hide();
  $("#btn_agregar_socio").hide();
  $("#divTablaSocios").hide();
  $("#div_estatus").hide();
  $("#div_btnContinuarResponsable").hide();
  $("#div_estatus_resp").hide();
  $("#div_captura_socios").show();
  $("#lbl_titulo_socios").text("Agregar socio");
  $("#id_cliente_socio").val(0);
});

function Cerrar() {
  $("#divTablaSocios").show();
  $("#btn-agregarclientes").show();
  $("#btn_agregar_socio").show();
  $("#divTablaSocios").show();
  $("#div_btnContinuarResponsable").show();
  $("#div_captura_socios").hide();
  $("#lbl_titulo_socios").text("");
  $("#btn_continuarResponsables").show();
}

function guardarSocios() {
  var idClienteS = $("#id_clienteS").val();
  var idSocioCliente = $("#id_cliente_socio").val();
  var idSocioS = $("#id_socioS").val();
  var RFC = $("#tbx_rfc_socio").val();
  var Nombre = $("#tbx_nombre_socio").val();
  var PrimerAp = $("#tbx_primer_apellido").val();
  var SegundoAp = $("#tbx_segundo_apellido").val();
  var Curp = $("#tbx_curp_socio").val();
  var Email = $("#tbx_mailS").val();
  var Estatus = $("#ddl_estatus_socio").val();

  var formData = new FormData();

  formData.append("idClienteS", idClienteS);
  formData.append("idSocioS", idSocioS);
  formData.append("RFC", RFC);
  formData.append("Nombre", Nombre);
  formData.append("PrimerAp", PrimerAp);
  formData.append("SegundoAp", SegundoAp);
  formData.append("Curp", Curp);
  formData.append("Email", Email);
  formData.append("Estatus", Estatus);
  formData.append("IdSocioCliente", idSocioCliente);

  $.ajax({
    url: base_url + "Clientes/AgregarSocio",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    success: function (respuesta) {
      if (respuesta > 0) {
        Cerrar();
        obtenerSocios();
        $("#btn_continuarResponsables").show();
        swal(
          "Información capturada",
          "Socio asociado correctamente",
          "success"
        );
      } else {
        if (respuesta == 0) {
          swal(
            "Error",
            "Hubo un error o el Socio ya se encuentra asociado al Cliente",
            "error"
          );
        } else {
          swal("Error", respuesta, "error");
        }
      }
      $("body").dynamicSpinnerDestroy({});
    },
  });
  return false;
}

function buscarRFC() {
  var rfc = $("#tbx_rfc_socio").val();
  $.ajax({
    type: "GET",
    url: base_url + "clientes/BuscarRFC/" + rfc,
    dataType: "json",
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});

      var datos = respuesta;

      if (datos.length > 0) {
        $("#id_socioS").val(datos[0].id_socio);
        $("#tbx_nombre_socio").val(datos[0].nombre);
        $("#tbx_primer_apellido").val(datos[0].primer_apellido);
        $("#tbx_segundo_apellido").val(datos[0].segundo_apellido);
        $("#tbx_curp_socio").val(datos[0].curp);
        validarCURPSocio(datos[0].curp);
        $("#tbx_mailS").val(datos[0].e_mail);
        validarEmail(datos[0].e_mail,'tbx_mailS');
      }
    },
    error: function (data) {
      $("body").dynamicSpinnerDestroy({});
      //console.log(data);
    },
  });
}

function obtenerSocios() {
  $("#divTablaSocios").show();
  var ArrayPOST = {
    IdCliente: $("#id_clienteS").val(),
  };

  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "Clientes/ObtenerUsuarios",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-socios").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "rfc", className: "text-center" },
            { data: "curp", className: "text-center" },
            { data: "nombre_completo", className: "text-center" },
            { data: "estado_logico", className: "text-center" },
            { data: "acciones", className: "text-center" },
          ],
          dom: "Bfrtip",
          buttons: [
            //{
            //  "extend": "copyHtml5",
            //  "text": "<span class='material-icons'>copy_all</span> Copiar",
            //  "titleAttr":"Copiar",
            //  "className": "btn btn-secondary"
            //},
            {
              extend: "excelHtml5",
              text: "<span class='far fa-file-excel'></span>",
              titleAttr: "Exportar a Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<span class='far fa-file-pdf'></span>",
              titleAttr: "Exportar a PDF",
              className: "btn btn-success",
            },
            {
              extend: "csvHtml5",
              text: "<span class='far fa-file'></span>",
              titleAttr: "Exportar a CSV",
              className: "btn btn-success",
            },
          ],
          //dom: "lBfrtip",
          //responsive: "true",
          //bDestroy: true,
          //iDisplayLength: 10,
          //order: [[0, "asc"]]
        });
        $("body").dynamicSpinnerDestroy({});
        $("#div_resultados").show("swing");
        swal("Información cargada correctamente.", "", "success");
      } else {
        $("#table-socios").DataTable({
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          buttons: [
            //{
            //  "extend": "copyHtml5",
            //  "text": "<span class='material-icons'>copy_all</span> Copiar",
            //  "titleAttr":"Copiar",
            //  "className": "btn btn-secondary"
            //},
            {
              extend: "excelHtml5",
              text: "<span class='far fa-file-excel'></span>",
              titleAttr: "Exportar a Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<span class='far fa-file-pdf'></span>",
              titleAttr: "Exportar a PDF",
              className: "btn btn-success",
            },
            {
              extend: "csvHtml5",
              text: "<span class='far fa-file'></span>",
              titleAttr: "Exportar a CSV",
              className: "btn btn-success",
            },
          ],
          //dom: "lBfrtip",
          //responsive: "true",
          //bDestroy: true,
          //iDisplayLength: 10,
          //order: [[0, "asc"]]
        });
        $("body").dynamicSpinnerDestroy({});
        $("#div_resultados").hide("swing");
      }

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function EditarSocio(IdSocioCliente, idSocio) {
  $("#btn_agregar_socio").hide();
  $("#divTablaSocios").hide();
  $("#div_estatus").show();
  $("#div_estatus_resp").hide();
  $("#div_captura_socios").show();
  $("#lbl_titulo_socios").text("Editar socio");
  $("#id_cliente_socio").val(IdSocioCliente);
  $("#id_socioS").val(idSocio);
  $("#btn_continuarResponsables").hide();

  var ArrayPOST = {
    IdSocioCliente: IdSocioCliente,
  };

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "Clientes/ObtenerUsuariosbysocio",
    data: ArrayPOST,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);

      if (datos.length > 0) {
        $("#id_socioS").val(idSocio);
        $("#id_cliente_socio").val(IdSocioCliente);
        $("#tbx_rfc_socio").val(datos[0].rfc);
        validarRFCSocio(datos[0].rfc);
        $("#tbx_nombre_socio").val(datos[0].nombre);
        $("#tbx_primer_apellido").val(datos[0].primer_apellido);
        $("#tbx_segundo_apellido").val(datos[0].segundo_apellido);
        $("#tbx_curp_socio").val(datos[0].curp);
        validarCURPSocio(datos[0].curp);
        $("#tbx_mailS").val(datos[0].e_mail);
        validarEmail(datos[0].e_mail,'tbx_mailS');
        $("#ddl_estatus_socio").val(datos[0].Estatus);
      }
    },
  });
}

//funciones de responsable

function limpia_camposResponsable() {
  tbx_rfc_responsable.classList.remove("ok");
  resultadoRFCResponsable.classList.remove("ok");
  resultadoRFCResponsable.innerText = "";
  tbx_curp_responsable.classList.remove("ok");
  resultadoCURPResponsable.classList.remove("ok");
  resultadoCURPResponsable.innerText = "";

  tbx_mail_responsable.classList.remove("ok");
  resultadoMailResponsable.classList.remove("ok");
  resultadoMailResponsable.innerText = "";

  $("#id_responsableS").val("");
  $("#tbx_rfc_responsable").val("");
  $("#tbx_nombre_responsable").val("");
  $("#tbx_primer_apellido_responsable").val("");
  $("#tbx_segundo_apellido_responsable").val("");
  $("#tbx_curp_responsable").val("");
  $("#tbx_mail_responsable").val("");
  $("#ddl_tipo_responsable").val(0);
}

$("#btn_agregar_responsable").bind("click", async (e) => {
  limpia_camposResponsable();
  $("#div_estatus_resp").hide();
  $("#btn_agregar_responsable").hide();
  $("#divTablaResponsable").hide();
  $("#div_estatus_responsable").hide();
  $("#div_captura_responsable").show();
  $("#lbl_titulo_responsable").text("Agregar responsable");
  $("#id_cliente_responsable").val(0);
  $("#btn-continuarActividad").hide();
});

function CerrarResponsable() {
  $("#divTablaResponsable").show();
  $("#btn-agregarclientes").show();
  $("#btn_agregar_responsable").show();
  //$("#div_btnContinuarResponsable").show();
  $("#div_captura_responsable").hide();
  $("#lbl_titulo_responsable").text("");
  $("#btn-continuarActividad").show();
}

function GuardarResponsable() {
  var idClienteS = $("#id_clienteS").val();
  var idResponsableCliente = $("#id_cliente_responsable").val();
  var idResponsableS = $("#id_responsableS").val();
  var RFC = $("#tbx_rfc_responsable").val();
  var Nombre = $("#tbx_nombre_responsable").val();
  var PrimerAp = $("#tbx_primer_apellido_responsable").val();
  var SegundoAp = $("#tbx_segundo_apellido_responsable").val();
  var Curp = $("#tbx_curp_responsable").val();
  var Email = $("#tbx_mail_responsable").val();
  var Estatus = $("#ddl_estatus_responsable").val();
  var IdTipoResponsable = $("#ddl_tipo_responsable").val();

  var formData = new FormData();

  formData.append("idClienteS", idClienteS);
  formData.append("idResponsableS", idResponsableS);
  formData.append("RFC", RFC);
  formData.append("Nombre", Nombre);
  formData.append("PrimerAp", PrimerAp);
  formData.append("SegundoAp", SegundoAp);
  formData.append("Curp", Curp);
  formData.append("Email", Email);
  formData.append("Estatus", Estatus);
  formData.append("idResponsableCliente", idResponsableCliente);
  formData.append("idTipoResponsable", IdTipoResponsable);

  $.ajax({
    url: base_url + "Clientes/AgregarResponsable",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    success: function (respuesta) {
      if (respuesta > 0) {
        CerrarResponsable();
        obtenerResponsable();
        $("#btn-continuarActividad").show();
        swal(
          "Información capturada",
          "Responsable asociado correctamente",
          "success"
        );
      } else {
        if (respuesta == 0) {
          swal(
            "Error",
            "Hubo un error o el Responsable ya se encuentra asociado al Cliente",
            "error"
          );
        } else {
          swal("Error", respuesta, "error");
        }
      }
      $("body").dynamicSpinnerDestroy({});
    },
  });
  return false;
}

function buscarRFCResponsable() {
  var rfc = $("#tbx_rfc_responsable").val();
  $.ajax({
    type: "GET",
    url: base_url + "clientes/buscarRFCResponsable/" + rfc,
    dataType: "json",
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});

      var datos = respuesta;

      if (datos.length > 0) {
        $("#id_responsableS").val(datos[0].id_responsable);
        $("#tbx_nombre_responsable").val(datos[0].nombre);
        $("#tbx_primer_apellido_responsable").val(datos[0].primer_apellido);
        $("#tbx_segundo_apellido_responsable").val(datos[0].segundo_apellido);
        $("#tbx_curp_responsable").val(datos[0].curp);
        validarCURPResponsable(datos[0].curp);
        $("#tbx_mail_responsable").val(datos[0].e_mail);
        validarEmail(datos[0].e_mail,'tbx_mail_responsable');
      }
    },
    error: function (data) {
      $("body").dynamicSpinnerDestroy({});
      console.log(data);
    },
  });
}

function obtenerResponsable() {
  $("#divTablaResponsable").show();
  var ArrayPOST = {
    IdCliente: $("#id_clienteS").val(),
  };

  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "Clientes/ObtenerResponsable",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-Responsable").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "rfc", className: "text-center" },
            { data: "curp", className: "text-center" },
            { data: "nombre_completo", className: "text-center" },
            { data: "tipo_responsable", className: "text-center" },
            { data: "estado_logico", className: "text-center" },
            { data: "acciones", className: "text-center" },
          ],
          dom: "Bfrtip",
          buttons: [
            //{
            //  "extend": "copyHtml5",
            //  "text": "<span class='material-icons'>copy_all</span> Copiar",
            //  "titleAttr":"Copiar",
            //  "className": "btn btn-secondary"
            //},
            {
              extend: "excelHtml5",
              text: "<span class='far fa-file-excel'></span>",
              titleAttr: "Exportar a Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<span class='far fa-file-pdf'></span>",
              titleAttr: "Exportar a PDF",
              className: "btn btn-success",
            },
            {
              extend: "csvHtml5",
              text: "<span class='far fa-file'></span>",
              titleAttr: "Exportar a CSV",
              className: "btn btn-success",
            },
          ],
          //dom: "lBfrtip",
          //responsive: "true",
          //bDestroy: true,
          //iDisplayLength: 10,
          //order: [[0, "asc"]]
        });
        $("body").dynamicSpinnerDestroy({});
        //$("#div_resultados").show("swing");
        swal("Información cargada correctamente.", "", "success");
      } else {
        $("#table-Responsable").DataTable({
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          buttons: [
            //{
            //  "extend": "copyHtml5",
            //  "text": "<span class='material-icons'>copy_all</span> Copiar",
            //  "titleAttr":"Copiar",
            //  "className": "btn btn-secondary"
            //},
            {
              extend: "excelHtml5",
              text: "<span class='far fa-file-excel'></span>",
              titleAttr: "Exportar a Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<span class='far fa-file-pdf'></span>",
              titleAttr: "Exportar a PDF",
              className: "btn btn-success",
            },
            {
              extend: "csvHtml5",
              text: "<span class='far fa-file'></span>",
              titleAttr: "Exportar a CSV",
              className: "btn btn-success",
            },
          ],
          //dom: "lBfrtip",
          //responsive: "true",
          //bDestroy: true,
          //iDisplayLength: 10,
          //order: [[0, "asc"]]
        });
        $("body").dynamicSpinnerDestroy({});
        $("#div_resultados").hide("swing");
      }

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function EditarResponsable(IdResponsableCliente, idResponsable) {
  $("#btn_agregar_responsable").hide();
  $("#btn-continuarActividad").hide();
  $("#divTablaResponsable").hide();
  $("#div_estatus_resp").show();
  $("#div_captura_responsable").show();
  $("#lbl_titulo_responsable").text("Editar responsable");
  $("#id_cliente_responsable").val(IdResponsableCliente);
  $("#id_responsableS").val(idResponsable);

  var ArrayPOST = {
    IdResponsableCliente: IdResponsableCliente,
  };

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "Clientes/ObtenerClientebyResponsable",
    data: ArrayPOST,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);

      if (datos.length > 0) {
        //$("#id_responsableS").val(IdResponsable);
        //$("#id_cliente_responsable").val(IdResponsableCliente);
        $("#ddl_tipo_responsable").val(datos[0].id_tipo_responsable);
        $("#tbx_rfc_responsable").val(datos[0].rfc);
        validarRFCResponsable(datos[0].rfc);
        $("#tbx_nombre_responsable").val(datos[0].nombre);
        $("#tbx_primer_apellido_responsable").val(datos[0].primer_apellido);
        $("#tbx_segundo_apellido_responsable").val(datos[0].segundo_apellido);
        $("#tbx_curp_responsable").val(datos[0].curp);
        validarCURPResponsable(datos[0].curp);
        $("#tbx_mail_responsable").val(datos[0].e_mail);
        validarEmail(datos[0].e_mail,'tbx_mail_responsable');
        $("#ddl_estatus_responsable").val(datos[0].Estatus);
      }
    },
  });
}

function IdentificacionCliente() {
  $("#div_identificacionCliente").show();
  var lblRFC = $("#tbx_rfc_cliente").val();
  var lblRazonSocial = $("#tbx_razon_social").val();
  $("#lbl_rfc").html("<b>" + lblRFC + "</b>");
  $("#lbl_razonSocial").html("<b>" + lblRazonSocial + "</b>");
}

function ContinuarResponsables() {
  $("#div_datosGenerales").hide();
  $("#div_domicilioFiscal").hide();
  $("#div_socios").hide();
  $("#div_Responsable").show();
  $("#divRegimen").hide();
  obtenerResponsable();
}

function buscarRFCResponsable() {
  var rfcResp = $("#tbx_rfc_responsable").val();
  $.ajax({
    type: "GET",
    url: base_url + "clientes/BuscarRFCResponsable/" + rfcResp,
    dataType: "json",
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});

      var datos = respuesta;

      if (datos.length > 0) {
        console.log(datos);
        $("#id_responsableS").val(datos[0].id_responsable);
        if (datos[0].id_tipo_responsable != null) {
          $("#ddl_tipo_responsable").val(datos[0].id_tipo_responsable);
        } else {
          $("#ddl_tipo_responsable").val(0);
        }
        $("#tbx_nombre_responsable").val(datos[0].nombre);
        $("#tbx_primer_apellido_responsable").val(datos[0].primer_apellido);
        $("#tbx_segundo_apellido_responsable").val(datos[0].segundo_apellido);
        $("#tbx_curp_responsable").val(datos[0].curp);
        validarCURPResponsable(datos[0].curp);
        $("#tbx_mail_responsable").val(datos[0].e_mail);
        validarEmail(datos[0].e_mail,'tbx_mail_responsable');
      }
    },
    error: function (data) {
      $("body").dynamicSpinnerDestroy({});
      //console.log(data);
    },
  });
}

function ContinuarActividad() {
  $("#div_datosGenerales").hide();
  $("#div_domicilioFiscal").hide();
  $("#div_socios").hide();
  $("#div_Responsable").hide();
  $("#divActividad").show();
  $("#divRegimen").hide();
  obtenerActividades();
}

$("#btn_agregar_actividad").bind("click", async (e) => {
  $("#btn_agregar_actividad").hide();
  $("#btn-agregarclientes").hide();
  $("#divTablaActividad").hide();
  $("#div_btnEditarActividad").hide();
  $("#div_capturarActividad").show();
  $("#lbl_titulo_Actividad").text("Actividades Económicas");
  $("#btn-continuarRegimen").hide();
  RecuperaCheckSeleccionado();
});

function ObtenerChecksSelecionados() {
  $('[name="checks[]"]').click(function () {
    $("#chbx_ninguno").prop("checked", false);
    var arr = $('[name="checks[]"]:checked')
      .map(function () {
        return this.value;
      })
      .get();

    var str = arr.join(",");

    $("#arr").text(JSON.stringify(arr));

    $("#str").text(str);
  });
}

function Activar_ninguno() {
  LimpiarCheckbox();
  $("#chbx_ninguno").prop("checked", true);
  var arr = $('[name="checks[]"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  var str = arr.join(",");

  $("#arr").text(JSON.stringify(arr));

  $("#str").text(str);
}

function LimpiarCheckbox() {
  $("input[type=checkbox]").prop("checked", false);
  $("#arr").text("");

  $("#str").text("");
}

// function GuardarActividad() {
//   var model = new FormData();
//   var cadena = $("#str").text();
//   var res = cadena.split(",");

//   var IdCliente = $("#id_clienteS").val();

//   for (i = 0; i < res.length; i++) {
//     if (res[i] >= 0) {
//       try {
//         var dattos = new FormData();

//         dattos.append("IdCliente", IdCliente);
//         dattos.append("IdActividad", res[i]);
//         /*MuestraCargando();*/
//         //alert(IdDoc + "," + IdGrupo);
//         $.ajax({
//           url: base_url + "clientes/ActualizaActividadEconomica", //"../CatUsuarios/ActualizaUsuarioRoles",
//           data: dattos,
//           dataType: "json",
//           cache: false,
//           type: "POST",
//           contentType: false,
//           processData: false, // esta propiedad es importante para poder pasar el archivo al controlador
//           error: function (e, errStatus, errorThrown) {
//             $("body").dynamicSpinnerDestroy({});
//             swal(
//               "¡Error!",
//               "Error al actualizar la información.",
//               "error"
//             );
//           },
//           success: function (respuesta) {
//             $("body").dynamicSpinnerDestroy({});
//             if (respuesta > 0) {
//               swal(
//                 "Éxito",
//                 "La información se actualizó satisfactoriamente",
//                 "success"
//               );

//               $("#btn_agregar_actividad").show();
//               $("#btn-agregarclientes").show();
//               $("#divTablaActividad").show();
//               $("#div_capturarActividad").hide();

//               // obtenerActividades();
//             }
//           },
//         });
//       } catch (e) {
//         swal("¡Error!", e.message, "error");
//       }
//     } else {
//       swal(
//         "Actualización exitosa",
//         "La información se actualizó correctamente.",
//         "success"
//       );
//     }
//     /*console.log("IdGrupo: " + res[i] + " IdDoc: " + IdDoc);*/
//   }
// }

function GuardaCheck($valor) {
  var IdCliente = $("#id_clienteS").val();

  try {
    var dattos = new FormData();

    dattos.append("IdCliente", IdCliente);
    dattos.append("IdActividad", $valor);
    $("body").dynamicSpinner({
      loadingText: "Cargando...",
    });
    $.ajax({
      url: base_url + "clientes/ActualizaActividadEconomica",
      data: dattos,
      dataType: "json",
      cache: false,
      type: "POST",
      contentType: false,
      processData: false, // esta propiedad es importante para poder pasar el archivo al controlador
      error: function (e, errStatus, errorThrown) {
        $("body").dynamicSpinnerDestroy({});
        swal("¡Error!", "Error al actualizar la información.", "error");
      },
      success: function (respuesta) {
        $("body").dynamicSpinnerDestroy({});
        if (respuesta > 0) {
          swal(
            "Éxito",
            "La información se actualizó satisfactoriamente",
            "success"
          );
        }
      },
    });
  } catch (e) {
    swal("¡Error!", e.message, "error");
  }
}

function CerrarActividad() {
  $("#btn_agregar_actividad").show();
  $("#btn-agregarclientes").show();
  $("#divTablaActividad").show();
  $("#div_capturarActividad").hide();
  $("#btn-continuarRegimen").show();
  obtenerActividades();
}

function obtenerActividades() {
  $("#divTablaActividad").show();
  var ArrayPOST = {
    IdCliente: $("#id_clienteS").val(),
  };

  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "Clientes/obtenerActividades",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-Actividad").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "ActividadEconomica", className: "text-center" },
            { data: "Estatus", className: "text-center" },
          ],
          dom: "Bfrtip",
          buttons: [
            //{
            //  "extend": "copyHtml5",
            //  "text": "<span class='material-icons'>copy_all</span> Copiar",
            //  "titleAttr":"Copiar",
            //  "className": "btn btn-secondary"
            //},
            {
              extend: "excelHtml5",
              text: "<span class='far fa-file-excel'></span>",
              titleAttr: "Exportar a Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<span class='far fa-file-pdf'></span>",
              titleAttr: "Exportar a PDF",
              className: "btn btn-success",
            },
            {
              extend: "csvHtml5",
              text: "<span class='far fa-file'></span>",
              titleAttr: "Exportar a CSV",
              className: "btn btn-success",
            },
          ],
          //dom: "lBfrtip",
          //responsive: "true",
          //bDestroy: true,
          //iDisplayLength: 10,
          //order: [[0, "asc"]]
        });
        $("body").dynamicSpinnerDestroy({});
        //$("#div_resultados").show("swing");
        swal("Información cargada correctamente.", "", "success");
      } else {
        $("body").dynamicSpinnerDestroy({});
        // $("#div_resultados").hide("swing");
      }

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function RecuperaCheckSeleccionado() {
  var ArrayPOST = {
    IdCliente: $("#id_clienteS").val(),
  };

  try {
    $.ajax({
      url: base_url + "Clientes/obtenerActividades",
      data: ArrayPOST,
      cache: false,
      type: "GET",
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      dataType: "json",
      error: function (e, errStatus, errorThrown) {
        $("body").dynamicSpinnerDestroy({});
        swal("¡Error!", "Error al recuperar el listado.", "error");
      },
      success: function (result) {
        console.log(result);
        $("body").dynamicSpinnerDestroy({});

        if (result.length > 0) {
          for (i = 0; i < result.length; i++) {
            if (result[i].id_estado_logico == 1) {
              //aqui selecciono dinamicamente el chbx del id dinamico
              $("#chbx_" + result[i].id_actividad_economica).prop(
                "checked",
                true
              );

              //Aqui meto en el arr y en str los checkbox que fueron seleccionados
              var arr = $('[name="checks[]"]:checked')
                .map(function () {
                  return this.value;
                })
                .get();

              var str = arr.join(",");

              $("#arr").text(JSON.stringify(arr));

              $("#str").text(str);
            } else {
              $("#chbx_" + result.id_actividad_economica).prop(
                "checked",
                false
              );

              //Aqui meto en el arr y en str los checkbox que fueron seleccionados
              var arr = $('[name="checks[]"]:checked')
                .map(function () {
                  return this.value;
                })
                .get();

              var str = arr.join(",");

              $("#arr").text(JSON.stringify(arr));

              $("#str").text(str);
            }
          }
        } else {
          swal(
            "Información",
            "No se encontrarón actividades relacionadas con el cliente",
            "info"
          );
        }
      },
    });
  } catch (e) {
    swal("¡Error!", e.message, "eeror");
  }
}

function ContinuarRegimen() {
  $("#div_datosGenerales").hide();
  $("#div_domicilioFiscal").hide();
  $("#div_socios").hide();
  $("#div_Responsable").hide();
  $("#divActividad").hide();
  $("#divRegimenFiscal").show();
  ObtenerRegimenFiscal();
}

$("#btn_agregar_regimen").bind("click", async (e) => {
  $("#btn_agregar_regimen").hide();
  $("#btn-agregarclientes").hide();
  $("#divTablaRegimen").hide();
  $("#div_capturarRegimen").show();
  $("#lbl_titulo_Regimen").text("Regimen Fiscal");
  $("#btn_fianalizar_captura").hide();
  RecuperaCheckSeleccionadoRegimen();
});

function RecuperaCheckSeleccionadoRegimen() {
  var ArrayPOST = {
    IdCliente: $("#id_clienteS").val(),
  };

  try {
    $.ajax({
      url: base_url + "clientes/ObtenerRegimenFiscal",
      data: ArrayPOST,
      cache: false,
      type: "GET",
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      dataType: "json",
      error: function (e, errStatus, errorThrown) {
        $("body").dynamicSpinnerDestroy({});
        swal("¡Error!", "Error al recuperar el listado.", "error");
      },
      success: function (result) {
        console.log(result);
        $("body").dynamicSpinnerDestroy({});

        if (result.length > 0) {
          for (i = 0; i < result.length; i++) {
            if (result[i].id_estado_logico == 1) {
              //aqui selecciono dinamicamente el chbx del id dinamico
              $("#chbxR_" + result[i].id_regimen_fiscal).prop("checked", true);

              //Aqui meto en el arr y en str los checkbox que fueron seleccionados
              var arr = $('[name="checks[]"]:checked')
                .map(function () {
                  return this.value;
                })
                .get();

              var str = arr.join(",");

              $("#arr").text(JSON.stringify(arr));

              $("#str").text(str);
            } else {
              $("#chbxR_" + result.id_regimen_fiscal).prop("checked", false);

              //Aqui meto en el arr y en str los checkbox que fueron seleccionados
              var arr = $('[name="checks[]"]:checked')
                .map(function () {
                  return this.value;
                })
                .get();

              var str = arr.join(",");

              $("#arr").text(JSON.stringify(arr));

              $("#str").text(str);
            }
          }
        } else {
          swal(
            "Información",
            "No se encontrarón actividades relacionadas con el cliente",
            "info"
          );
        }
      },
    });
  } catch (e) {
    swal("¡Error!", e.message, "eeror");
  }
}

function GuardaCheckRegimen($valor) {
  var IdCliente = $("#id_clienteS").val();

  try {
    var dattos = new FormData();

    dattos.append("IdCliente", IdCliente);
    dattos.append("IdRegimen", $valor);
    $("body").dynamicSpinner({
      loadingText: "Cargando...",
    });
    $.ajax({
      url: base_url + "clientes/ActualizaRegimenFiscal",
      data: dattos,
      dataType: "json",
      cache: false,
      type: "POST",
      contentType: false,
      processData: false, // esta propiedad es importante para poder pasar el archivo al controlador
      error: function (e, errStatus, errorThrown) {
        $("body").dynamicSpinnerDestroy({});
        swal("¡Error!", "Error al actualizar la información.", "error");
      },
      success: function (respuesta) {
        $("body").dynamicSpinnerDestroy({});
        if (respuesta > 0) {
          swal(
            "Éxito",
            "La información se actualizó satisfactoriamente",
            "success"
          );
        }
      },
    });
  } catch (e) {
    swal("¡Error!", e.message, "error");
  }
}

function CerrarRegimen() {
  $("#btn_agregar_regimen").show();
  $("#btn-agregarclientes").show();
  $("#divTablaRegimen").show();
  $("#div_capturarRegimen").hide();
  $("#btn_fianalizar_captura").show();
  ObtenerRegimenFiscal();
}

function ObtenerRegimenFiscal() {
  $("#divTablaRegimen").show();
  var ArrayPOST = {
    IdCliente: $("#id_clienteS").val(),
  };

  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "clientes/ObtenerRegimenFiscal",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-Regimen").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "RegimenFiscal", className: "text-center" },
            { data: "Estatus", className: "text-center" },
          ],
          dom: "Bfrtip",
          buttons: [
            //{
            //  "extend": "copyHtml5",
            //  "text": "<span class='material-icons'>copy_all</span> Copiar",
            //  "titleAttr":"Copiar",
            //  "className": "btn btn-secondary"
            //},
            {
              extend: "excelHtml5",
              text: "<span class='far fa-file-excel'></span>",
              titleAttr: "Exportar a Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<span class='far fa-file-pdf'></span>",
              titleAttr: "Exportar a PDF",
              className: "btn btn-success",
            },
            {
              extend: "csvHtml5",
              text: "<span class='far fa-file'></span>",
              titleAttr: "Exportar a CSV",
              className: "btn btn-success",
            },
          ],
          //dom: "lBfrtip",
          //responsive: "true",
          //bDestroy: true,
          //iDisplayLength: 10,
          //order: [[0, "asc"]]
        });
        $("body").dynamicSpinnerDestroy({});
        //$("#div_resultados").show("swing");
        swal("Información cargada correctamente.", "", "success");
      } else {
        $("body").dynamicSpinnerDestroy({});
        // $("#div_resultados").hide("swing");
      }

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function FinalizarCaptura() {
  window.location = base_url + "capturacliente";
}

function tipoCliente(id_tipoCliente) {
  if (id_tipoCliente == 2) {
    $("#tbx_rfc_cliente").prop("disabled", false);
    $("#tbx_razon_social").prop("disabled", false);
    $("#tbx_curp_cliente").prop("disabled", true);
    $("#tbx_curp_cliente").val("");
  } else {
    $("#tbx_rfc_cliente").prop("disabled", false);
    $("#tbx_razon_social").prop("disabled", false);
    $("#tbx_curp_cliente").prop("disabled", false);
  }
}

async function validarRFC(RFC) {
  validarInputCaptura(RFC);
  var ArrayPOST = {
    RFC: RFC,
  };

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "clientes/ValidarRFC",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);

      if (respuesta == 1) {
        $("body").dynamicSpinnerDestroy({});
        $("#btn_guardarDatosGenerales").prop("disabled", true);
        swal("Lo sentimos", "Este RFC ya ha sido registrado", "warning");
      } else {
        $("body").dynamicSpinnerDestroy({});
        $("#btn_guardarDatosGenerales").prop("disabled", false);
      }
    },
  });
}

function curpValida(curp) {
  var re =
      /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
    validado = curp.match(re);

  if (!validado)
    //Coincide con el formato general?
    return false;

  //Validar que coincida el dígito verificador
  function digitoVerificador(curp17) {
    //Fuente https://consultas.curp.gob.mx/CurpSP/
    var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
      lngSuma = 0.0,
      lngDigito = 0.0;
    for (var i = 0; i < 17; i++)
      lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
    lngDigito = 10 - (lngSuma % 10);
    if (lngDigito == 10) return 0;
    return lngDigito;
  }

  if (validado[2] != digitoVerificador(validado[1])) return false;

  return true; //Validado
}

async function validarCURP(CURP) {
  validarInput(CURP);

  var ArrayPOST = {
    CURP: CURP,
  };

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "clientes/ValidarCURP",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);

      if (respuesta == 1) {
        $("body").dynamicSpinnerDestroy({});
        $("#btn_guardarDatosGenerales").prop("disabled", true);
        swal("Lo sentimos", "Este CURP ya ha sido registrado", "warning");
      } else {
        $("body").dynamicSpinnerDestroy({});
        $("#btn_guardarDatosGenerales").prop("disabled", false);
      }
    },
  });
}

function BuscarRFCCliente() {
  var RFC = $("#busqueda_rfc").val();
  var Nombre = $("#tbx_razon_socialB").val();

  if (RFC == "" && Nombre == "") {
    swal(
      "Error",
      "Debe proporcionar al menos un criterio de búsqueda",
      "error"
    );
    return;
  }
  var ArrayPOST = {
    RFC: $("#busqueda_rfc").val(),
    Nombre: $("#tbx_razon_socialB").val(),
  };

  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "clientes/GetClientebyRFC",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);

      if (respuesta.length > 0) {
        if (respuesta[0].id_tipo_cliente == 2) {
          if (respuesta.length > 0) {
            $("#div_clientesRegistrados").show();
            $("#div_clientesRegistradosFisica").hide();
            $("#table-clientes").DataTable({
              data: respuesta,
              responsive: "true",
              bAutoWidth: false,
              destroy: true,
              language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
              },
              columns: [
                { data: "row", className: "text-center" },
                { data: "TipoCliente", className: "text-center" },
                { data: "RFC", className: "text-center" },
                { data: "NOmbreRS", className: "text-center" },
                { data: "Estatus", className: "text-center" },
                { data: "acciones", className: "text-center" },
              ],
              dom: "Bfrtip",
              buttons: [
                //{
                //  "extend": "copyHtml5",
                //  "text": "<span class='material-icons'>copy_all</span> Copiar",
                //  "titleAttr":"Copiar",
                //  "className": "btn btn-secondary"
                //},
                {
                  extend: "excelHtml5",
                  text: "<span class='far fa-file-excel'></span>",
                  titleAttr: "Exportar a Excel",
                  className: "btn btn-success",
                },
                {
                  extend: "pdfHtml5",
                  text: "<span class='far fa-file-pdf'></span>",
                  titleAttr: "Exportar a PDF",
                  className: "btn btn-success",
                },
                {
                  extend: "csvHtml5",
                  text: "<span class='far fa-file'></span>",
                  titleAttr: "Exportar a CSV",
                  className: "btn btn-success",
                },
              ],
              //dom: "lBfrtip",
              //responsive: "true",
              //bDestroy: true,
              //iDisplayLength: 10,
              //order: [[0, "asc"]]
            });
            $("body").dynamicSpinnerDestroy({});
            //$("#div_resultados").show("swing");
            swal("Información cargada correctamente.", "", "success");
          } else {
            $("body").dynamicSpinnerDestroy({});
            // $("#div_resultados").hide("swing");
          }

          $('[data-toggle="tooltip"]').tooltip();
        } else {
          if (respuesta.length > 0) {
            $("#div_clientesRegistradosFisica").show();
            $("#div_clientesRegistrados").hide();
            $("#table-clientesFisica").DataTable({
              data: respuesta,
              responsive: "true",
              bAutoWidth: false,
              destroy: true,
              language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
              },
              columns: [
                { data: "row", className: "text-center" },
                { data: "TipoCliente", className: "text-center" },
                { data: "RFC", className: "text-center" },
                { data: "CURP", className: "text-center" },
                { data: "NOmbreRS", className: "text-center" },
                { data: "Estatus", className: "text-center" },
                { data: "acciones", className: "text-center" },
              ],
              dom: "Bfrtip",
              buttons: [
                //{
                //  "extend": "copyHtml5",
                //  "text": "<span class='material-icons'>copy_all</span> Copiar",
                //  "titleAttr":"Copiar",
                //  "className": "btn btn-secondary"
                //},
                {
                  extend: "excelHtml5",
                  text: "<span class='far fa-file-excel'></span>",
                  titleAttr: "Exportar a Excel",
                  className: "btn btn-success",
                },
                {
                  extend: "pdfHtml5",
                  text: "<span class='far fa-file-pdf'></span>",
                  titleAttr: "Exportar a PDF",
                  className: "btn btn-success",
                },
                {
                  extend: "csvHtml5",
                  text: "<span class='far fa-file'></span>",
                  titleAttr: "Exportar a CSV",
                  className: "btn btn-success",
                },
              ],
              //dom: "lBfrtip",
              //responsive: "true",
              //bDestroy: true,
              //iDisplayLength: 10,
              //order: [[0, "asc"]]
            });
            $("body").dynamicSpinnerDestroy({});
            //$("#div_resultados").show("swing");
            swal("Información cargada correctamente.", "", "success");
          } else {
            $("body").dynamicSpinnerDestroy({});
            // $("#div_resultados").hide("swing");
          }
        }
      } else {
        $("body").dynamicSpinnerDestroy({});
        swal("Error", "No se localizó la información del cliente", "error");
      }
    },
  });
}

function EditarCliente(id_cliente) {
  $("#div_datosGenerales").show();
  $("#div_domicilioFiscal").hide();
  $("#div_clientesRegistrados").hide();
  $("#div_clientesRegistradosFisica").hide();
  $("#div_busqueda").hide();
  $("#tbx_id_cliente").val(0);
  $("#div_socios").hide();
  $("#div_Responsable").hide();
  $("#tbx_curp_cliente").prop("disabled", true);
  $("#tbx_rfc_cliente").prop("disabled", true);
  $("#tbx_razon_social").prop("disabled", true);
  $("#btn_ActualizarDatosGenerales").show();
  $("#btn_guardarDatosGenerales").hide();
  $("#id_clienteD").val(id_cliente);

  var ArrayPOST = {
    IdCliente: id_cliente,
  };

  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "clientes/GetClientebyIdCliente",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);

      if (respuesta[0].id_tipo_cliente == 1) {
        $("#ddl_tipoCliente").val(respuesta[0].id_tipo_cliente);
        $("#id_cliente").val(id_cliente);
        $("#tbx_rfc_cliente").val(respuesta[0].rfc);
        validarInputCaptura(respuesta[0].rfc);
        $("#tbx_curp_cliente").val(respuesta[0].curp);
        validarInput(respuesta[0].curp);
        $("#tbx_razon_social").val(respuesta[0].razon_social);
        $("#tbx_rfc_cliente").prop("disabled", false);
        $("#tbx_curp_cliente").prop("disabled", false);
        $("#tbx_razon_social").prop("disabled", false);

        $("#tbx_calle").val(respuesta[0].calle);
        $("#tbx_no_exterior").val(respuesta[0].no_exterior);
        $("#tbx_no_interior").val(respuesta[0].no_interior);
        $("#tbx_colonia").val(respuesta[0].colonia);
        $("#tbx_entre_calle").val(respuesta[0].entre_calle);
        $("#tbx_y_calle").val(respuesta[0].y_calle);
        $("#ddl_pais").val(respuesta[0].id_pais);
        $("#ddl_entidad").val(respuesta[0].id_entidad_federativa);
        ObtenermunicipioG(
          respuesta[0].id_entidad_federativa,
          respuesta[0].id_alcaldia_municipio
        );

        //$('#ddl_municipio').selectpicker('render', id_municipio);

        $("#tbx_cp").val(respuesta[0].codigo_postal);
        $("#tbx_mail").val(respuesta[0].e_mail);
        validarEmail(respuesta[0].e_mail,'tbx_mail');
        $("#tbx_telefono").val(respuesta[0].telefono);
        $("#ddl_notaria").val(respuesta[0].id_notaria_publica);
        $("#tbx_no_escritura").val(respuesta[0].no_escritura);
        $("#tbx_fecha_escritura").val(respuesta[0].f_escritura);
        $("#tbx_folio_mercantil").val(respuesta[0].folio_mercantil);
        $("#tbx_fecha_registro").val(respuesta[0].f_registro);
      } else {
        $("#ddl_tipoCliente").val(respuesta[0].id_tipo_cliente);
        $("#id_cliente").val(id_cliente);
        $("#tbx_rfc_cliente").val(respuesta[0].rfc);
        validarInputCaptura(respuesta[0].rfc);
        $("#tbx_razon_social").val(respuesta[0].razon_social);
        $("#tbx_rfc_cliente").prop("disabled", false);
        $("#tbx_curp_cliente").prop("disabled", true);
        $("#tbx_razon_social").prop("disabled", false);
      }

      $("#tbx_calle").val(respuesta[0].calle);
      $("#tbx_no_exterior").val(respuesta[0].no_exterior);
      $("#tbx_no_interior").val(respuesta[0].no_interior);
      $("#tbx_colonia").val(respuesta[0].colonia);
      $("#tbx_entre_calle").val(respuesta[0].entre_calle);
      $("#tbx_y_calle").val(respuesta[0].y_calle);
      $("#ddl_pais").val(respuesta[0].id_pais);
      $("#ddl_entidad").val(respuesta[0].id_entidad_federativa);
      ObtenermunicipioG(
        respuesta[0].id_entidad_federativa,
        respuesta[0].id_alcaldia_municipio
      );

      //$('#ddl_municipio').selectpicker('render', id_municipio);

      $("#tbx_cp").val(respuesta[0].codigo_postal);
      $("#tbx_mail").val(respuesta[0].e_mail);
      validarEmail(respuesta[0].e_mail,'tbx_mail');
      $("#tbx_telefono").val(respuesta[0].telefono);
      $("#ddl_notaria").val(respuesta[0].id_notaria_publica);
      $("#tbx_no_escritura").val(respuesta[0].no_escritura);
      $("#tbx_fecha_escritura").val(respuesta[0].f_escritura);
      $("#tbx_folio_mercantil").val(respuesta[0].folio_mercantil);
      $("#tbx_fecha_registro").val(respuesta[0].f_registro);

      $("body").dynamicSpinnerDestroy({});
    },
  });
}

async function ObtenermunicipioG(ddl_entidad, id_alcaldia_municipio) {
  var ddl_entidad = $("#ddl_entidad").val();
  if (ddl_entidad != null) {
    await $.ajax({
      type: "GET",
      url: base_url + "catalogos/ObtenerMunicipios/" + ddl_entidad,
      dataType: "json",
      beforeSend: function () {},
      success: function (respuesta) {
        var datos = respuesta;
        var opciones = '<option value = "0">Seleccione...</option>';
        datos.forEach((element) => {
          if (element.id_alcaldia_municipio == id_alcaldia_municipio) {
            var cadena =
              "<option value=" +
              element.id_alcaldia_municipio +
              " selected> " +
              element.desc_larga +
              "</option>";
            opciones = opciones + cadena;
          } else {
            var cadena =
              "<option value=" +
              element.id_alcaldia_municipio +
              "> " +
              element.desc_larga +
              "</option>";
            opciones = opciones + cadena;
          }
        });

        $("#ddl_municipio").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "0" selected>Seleccione...</option>';
    $("#ddl_municipio").html(opciones);
  }
}

async function ActualizarDatosGenerales() {
  var tipo_cliente = $("#ddl_tipoCliente").val();
  IdentificacionCliente();

  await $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "clientes/ActualizarDatosGenerales",
    data: $("#formDatosGenerales").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});

      if (respuesta > 0) {
        swal("Puede continuar capturando Domicilio Fiscal", "", "success");
        $("#div_datosGenerales").hide();
        $("#div_domicilioFiscal").show();
        $("#tipo_cliente").val(tipo_cliente);
      } else {
        if (respuesta == -1) {
          swal(
            "La información fue actualizada con éxito, puede seguir capturando",
            "",
            "success"
          );
          $("#div_datosGenerales").hide();
          $("#div_domicilioFiscal").show();
          $("#tipo_cliente").val(tipo_cliente);
        } else {
          if (respuesta == 0) {
            swal("Error", "No se ha podido enviar información", "error");
          } else {
            swal("Error", respuesta, "error");
          }
        }
      }
    },
  });

  return false;
}

function BusquedaCliente() {
  busqueda_rfc.classList.remove("ok");
  resultadoRFCBusqueda.classList.remove("ok");
  resultadoRFCBusqueda.innerText = "";
  $("#div_datosGenerales").hide();
  $("#div_domicilioFiscal").hide();
  $("#div_clientesRegistrados").hide();
  $("#div_clientesRegistradosFisica").hide();
  $("#div_busqueda").show();
  $("#tbx_id_cliente").val(0);
  $("#div_socios").hide();
  $("#div_Responsable").hide();
  $("#tbx_curp_cliente").prop("disabled", true);
  $("#tbx_rfc_cliente").prop("disabled", true);
  $("#tbx_razon_social").prop("disabled", true);
  $("#btn_ActualizarDatosGenerales").hide();
  $("#btn_guardarDatosGenerales").hide();
  $("#busqueda_rfc").val("");
}

function validarInputCaptura(input) {
  var rfc = input.trim().toUpperCase(),
    resultado = document.getElementById("resultado"),
    valido;

  var rfcCorrecto = rfcValido(rfc); // ⬅️ Acá se comprueba

  if (rfcCorrecto) {
    valido = "Válido";
    tbx_rfc_cliente.classList.add("ok");
    resultado.classList.add("ok");
  } else {
    valido = "No válido";
    tbx_rfc_cliente.classList.remove("ok");
    resultado.classList.remove("ok");
  }

  resultado.innerText = "Formato: " + valido;
}

function validarRFCBusqueda(input) {
  var rfc = input.trim().toUpperCase(),
    resultadoRFCBusqueda = document.getElementById("resultadoRFCBusqueda"),
    valido;

  var rfcCorrecto = rfcValido(rfc); // ⬅️ Acá se comprueba

  if (rfcCorrecto) {
    valido = "Válido";
    busqueda_rfc.classList.add("ok");
    resultadoRFCBusqueda.classList.add("ok");
  } else {
    valido = "No válido";
    busqueda_rfc.classList.remove("ok");
    resultadoRFCBusqueda.classList.remove("ok");
  }

  resultadoRFCBusqueda.innerText = "Formato: " + valido;
}

function validarRFCSocio(input) {
  var rfc = input.trim().toUpperCase(),
    resultadoRFCSocio = document.getElementById("resultadoRFCSocio"),
    valido;

  var rfcCorrecto = rfcValido(rfc); // ⬅️ Acá se comprueba

  if (rfcCorrecto) {
    valido = "Válido";
    tbx_rfc_socio.classList.add("ok");
    resultadoRFCSocio.classList.add("ok");
  } else {
    valido = "No válido";
    tbx_rfc_socio.classList.remove("ok");
    resultadoRFCSocio.classList.remove("ok");
  }

  resultadoRFCSocio.innerText = "Formato: " + valido;
}

function validarRFCResponsable(input) {
  var rfc = input.trim().toUpperCase(),
    resultadoRFCResponsable = document.getElementById(
      "resultadoRFCResponsable"
    ),
    valido;

  var rfcCorrecto = rfcValido(rfc); // ⬅️ Acá se comprueba

  if (rfcCorrecto) {
    valido = "Válido";
    tbx_rfc_responsable.classList.add("ok");
    resultadoRFCResponsable.classList.add("ok");
  } else {
    valido = "No válido";
    tbx_rfc_responsable.classList.remove("ok");
    resultadoRFCResponsable.classList.remove("ok");
  }

  resultadoRFCResponsable.innerText = "Formato: " + valido;
}

//Handler para el evento cuando cambia el input
//Lleva la CURP a mayúsculas para validarlo
function validarInput(input) {
  var curp = input.toUpperCase(),
    resultadoCURP = document.getElementById("resultadoCURP"),
    valido = "No válido";

  if (curpValida(curp)) {
    // ⬅️ Acá se comprueba
    valido = "Válido";
    tbx_curp_cliente.classList.add("ok");
    resultadoCURP.classList.add("ok");
  } else {
    tbx_curp_cliente.classList.remove("ok");
    resultadoCURP.classList.remove("ok");
  }

  resultadoCURP.innerText = "Formato: " + valido;
}

function validarCURPSocio(input) {
  var curp = input.toUpperCase(),
    resultadoCURPSocio = document.getElementById("resultadoCURPSocio"),
    valido = "No válido";

  if (curpValida(curp)) {
    // ⬅️ Acá se comprueba
    valido = "Válido";
    tbx_curp_socio.classList.add("ok");
    resultadoCURPSocio.classList.add("ok");
  } else {
    tbx_curp_socio.classList.remove("ok");
    resultadoCURPSocio.classList.remove("ok");
  }

  resultadoCURPSocio.innerText = "Formato: " + valido;
}

function validarCURPResponsable(input) {
  var curp = input.toUpperCase(),
    resultadoCURPResponsable = document.getElementById(
      "resultadoCURPResponsable"
    ),
    valido = "No válido";

  if (curpValida(curp)) {
    // ⬅️ Acá se comprueba
    valido = "Válido";
    tbx_curp_responsable.classList.add("ok");
    resultadoCURPResponsable.classList.add("ok");
  } else {
    tbx_curp_responsable.classList.remove("ok");
    resultadoCURPResponsable.classList.remove("ok");
  }

  resultadoCURPResponsable.innerText = "Formato: " + valido;
}

function validarEmail(valor, id) {
  var texto = valor;
  //var dominio = texto.split("@")[1];
  //var dominiosAceptados = ["cfe.mx"];
  var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
  valido ="No válido";
  if (id == "tbx_mail") {
    if (!regex.test(texto)) {
      resultadoEmailCliente = document.getElementById("resultadoEmailCliente"),
      tbx_mail.classList.remove("ok");
      resultadoEmailCliente.classList.remove("ok");
     
    } else {
      resultadoEmailCliente = document.getElementById("resultadoEmailCliente"),
      valido = "Válido";
      tbx_mail.classList.add("ok");
      resultadoEmailCliente.classList.add("ok"); 
      
    }
    resultadoEmailCliente.innerText = "Formato: " + valido;
    
  }else{
    if (id == "tbx_mailS") {
      if (!regex.test(texto)) {
        resultadoEmailSocio = document.getElementById("resultadoEmailSocio"),
        tbx_mailS.classList.remove("ok");
        resultadoEmailSocio.classList.remove("ok");
       
      } else {
        resultadoEmailSocio = document.getElementById("resultadoEmailSocio"),
        valido = "Válido";
        tbx_mailS.classList.add("ok");
        resultadoEmailSocio.classList.add("ok"); 
        
      }
      resultadoEmailSocio.innerText = "Formato: " + valido;
      
    }else{
      if (id == "tbx_mail_responsable") {
        if (!regex.test(texto)) {
          resultadoMailResponsable = document.getElementById("resultadoMailResponsable"),
          tbx_mail_responsable.classList.remove("ok");
          resultadoMailResponsable.classList.remove("ok");
         
        } else {
          resultadoMailResponsable = document.getElementById("resultadoMailResponsable"),
          valido = "Válido";
          tbx_mail_responsable.classList.add("ok");
          resultadoMailResponsable.classList.add("ok"); 
          
        }
        resultadoMailResponsable.innerText = "Formato: " + valido;
        
      }
    }
  }

 
  
}


function rfcValido(rfc, aceptarGenerico = true) {
  const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
  var   validado = rfc.match(re);

  if (!validado)  //Coincide con el formato general del regex?
      return false;

  //Separar el dígito verificador del resto del RFC
  const digitoVerificador = validado.pop(),
        rfcSinDigito      = validado.slice(1).join(''),
        len               = rfcSinDigito.length,

  //Obtener el digito esperado
        diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
        indice            = len + 1;
  var   suma,
        digitoEsperado;

  if (len == 12) suma = 0
  else suma = 481; //Ajuste para persona moral

  for(var i=0; i<len; i++)
      suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
  digitoEsperado = 11 - suma % 11;
  if (digitoEsperado == 11) digitoEsperado = 0;
  else if (digitoEsperado == 10) digitoEsperado = "A";

  //El dígito verificador coincide con el esperado?
  // o es un RFC Genérico (ventas a público general)?
  if ((digitoVerificador != digitoEsperado)
   && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
      return false;
  else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
      return false;
  return rfcSinDigito + digitoVerificador;
}
