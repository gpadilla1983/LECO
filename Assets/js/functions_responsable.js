btn_consultarClick();

$('#table-responsable').DataTable({
    responsive: true
});

function btn_consultarClick() {
  var ArrayPOST = {
    ddl_estatus: $("#ddl_estatus").val(),
  };

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "responsable/ObtenerResponsable",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-responsable").DataTable({
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
            { data: "captura", className: "text-center" },
            { data: "f_captura", className: "text-center" },
            { data: "actualiza", className: "text-center" },
            { data: "f_actualiza", className: "text-center" },
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
        $("body").dynamicSpinnerDestroy({});
        $("#div_resultados").hide("swing");
        swal(
          "No se encontraron resultados de acuerdo a sus parametros de busqueda.",
          "",
          "error"
        );
      }

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

$("#btn_agregar_responsable").bind("click", async (e) => {
  if ($("#ajax-content").length) {
    $("#ajax-content").remove();
  }

  var ajaxcontent = document.createElement("div");

  ajaxcontent.setAttribute("id", "ajax-content");

  var html = await $.ajax({
    type: "GET",
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "ModalResponsable/0",
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  /*    $(function () {
        var $ddl = $("select[name$=ddl_ur_usuario]");
        $ddl.select2();
        $ddl.focus();
    }); */

  $("body").dynamicSpinnerDestroy({});
  $("#div_estatus").hide();

  $("#modalDatosResponsable").modal("show");
});

async function EditarResponsable(id_responsable) {
  if ($("#ajax-content").length) {
    $("#ajax-content").remove();
  }

  var ajaxcontent = document.createElement("div");

  ajaxcontent.setAttribute("id", "ajax-content");

  
  var html = await $.ajax({
    type: "GET",
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "ModalResponsable/" + id_responsable,
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "responsable/getResponsable/" + id_responsable,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);
        //console.log(datos);
        $("#tbx_nombre_responsable").val(datos.nombre);
        $("#tbx_primer_apellido").val(datos.primer_apellido);
        $("#tbx_segundo_apellido").val(datos.segundo_apellido);
        $("#tbx_rfc_responsable").val(datos.rfc);
        validarRFCResponsable(datos.rfc);
        $("#tbx_curp_responsable").val(datos.curp);
        validarCURPResponsable(datos.curp);
        $("#tbx_email_responsable").val(datos.e_mail);
        validarEmail(datos.e_mail,'tbx_email_responsable');
        $("#ddl_estatus_responsable").val(datos.id_estado_logico);
        $("#div_estatus").show();
        $("#modalDatosResponsable").modal("show");
    },
  });
}


function AgregarActualizarResponsable(id_responsable) {

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "responsable/AgregarActualizarResponsable/" + id_responsable,
    data: $("#formModalResponsable").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      $("#modalDatosResponsable").modal("hide");  
      if (respuesta == 1) {
        
        swal("Responsable agregado o actualizado con éxito", "", "success");
        btn_consultarClick();
      } else {
        if (respuesta == 0) {
          swal("Error", "El RFC o CURP del Responsable, se encuentran registrados, favor de validar", "error");
        } else {
          swal("Error", respuesta, "error");
        }
      }
    },
  });

  return false;
}


function validarRFCResponsable(input) {
  var rfc = input.trim().toUpperCase(),
  resultadoRFCResponsable = document.getElementById("resultadoRFCResponsable"),
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

function validarCURPResponsable(input) {
  var curp = input.toUpperCase(),
  resultadoCurpResponsable = document.getElementById("resultadoCurpResponsable"),
    valido = "No válido";

  if (curpValida(curp)) {
    // ⬅️ Acá se comprueba
    valido = "Válido";
    tbx_curp_responsable.classList.add("ok");
    resultadoCurpResponsable.classList.add("ok");
  } else {
    tbx_curp_responsable.classList.remove("ok");
    resultadoCurpResponsable.classList.remove("ok");
  }

  resultadoCurpResponsable.innerText = "Formato: " + valido;
}

function validarEmail(valor, id) {
  var texto = valor;
 
  var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
  valido = "No válido";

  if (id == "tbx_email_responsable") {
    if (!regex.test(texto)) {
      (resultadoMailSocio = document.getElementById("resultadoMailResponsable")),
      tbx_email_responsable.classList.remove("ok");
      resultadoMailResponsable.classList.remove("ok");
    } else {
      (resultadoMailResponsable = document.getElementById("resultadoMailResponsable")),
        (valido = "Válido");
        tbx_email_responsable.classList.add("ok");
        resultadoMailResponsable.classList.add("ok");
    }
    resultadoMailResponsable.innerText = "Formato: " + valido;
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

function curpValida(curp) {
  var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
      validado = curp.match(re);

  if (!validado)  //Coincide con el formato general?
    return false;
  
  //Validar que coincida el dígito verificador
  function digitoVerificador(curp17) {
      //Fuente https://consultas.curp.gob.mx/CurpSP/
      var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
          lngSuma      = 0.0,
          lngDigito    = 0.0;
      for(var i=0; i<17; i++)
          lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
      lngDigito = 10 - lngSuma % 10;
      if (lngDigito == 10) return 0;
      return lngDigito;
  }

  if (validado[2] != digitoVerificador(validado[1])) 
    return false;
      
  return true; //Validado
}



