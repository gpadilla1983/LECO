btn_consultarClick();

$('#table-juzgado').DataTable({
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
    url: base_url + "catJuzgado/ObtenerJuzgado",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-juzgado").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "no_juzgado", className: "text-center" },
            { data: "desc_larga", className: "text-center" },
            { data: "pais", className: "text-center" },
            { data: "entidad_federativa", className: "text-center" },
            { data: "alcaldia_municipio", className: "text-center" },
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

$("#btn_agregar_juzgado").bind("click", async (e) => {
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
    url: base_url + "ModalJuzgado/0",
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

  $("#modalDatosJuzgado").modal("show");
});

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
        var opciones = '<option value = "0" selected>Seleccione...</option>';
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




async function EditarJuzgado(id_juzgado) {
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

    url: base_url + "ModalJuzgado/" + id_juzgado,
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "catJuzgado/getJuzgado/" + id_juzgado,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);
        
        $("#tbx_num_juzgado").val(datos.no_juzgado);
        $("#tbx_desc_larga").val(datos.desc_larga);
        $("#ddl_estatus_juzgado").val(datos.id_estado_logico);
        $("#ddl_pais").val(datos.id_pais);
        $("#ddl_entidad").val(datos.id_entidad_federativa);
        $("#ddl_municipio").val(datos.id_alcaldia_municipio);
        $("#div_estatus").show();
        $("#modalDatosJuzgado").modal("show");
    },
  });
}

function AgregarActualizarJuzgado(id_juzgado) {

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "catJuzgado/AgregarActualizarJuzgado/" + id_juzgado,
    data: $("#formModalJuzgado").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      $("#modalDatosJuzgado").modal("hide");  
      if (respuesta == 1) {
        
        swal("Juzgado agregado o actualizado con éxito", "", "success");
        btn_consultarClick();
      } else {
        if (respuesta == 0) {
          swal("Error", "Ha ocurrido un error", "error");
        } else {
          swal("Error", respuesta, "error");
        }
      }
    },
  });

  return false;
}

