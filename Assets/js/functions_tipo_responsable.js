btn_consultarClick();

$('#table-tipo_responsable').DataTable({
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
    url: base_url + "tiporesponsable/ObtenerTipoResponsable",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-tipo_responsable").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "desc_corta", className: "text-center" },
            { data: "desc_larga", className: "text-center" },
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

$("#btn_agregar_tipo_responsable").bind("click", async (e) => {
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
    url: base_url + "ModalTipoResponsable/0",
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

  $("#modalDatosTipoResponsable").modal("show");
});

async function EditarTipoResponsable(id_tipo_responsable) {
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

    url: base_url + "ModalTipoResponsable/" + id_tipo_responsable,
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "tiporesponsable/getTipoResponsable/" + id_tipo_responsable,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);
        //console.log(datos);
        $("#tbx_desc_corta").val(datos.desc_corta);
        $("#tbx_desc_larga").val(datos.desc_larga);
        $("#ddl_estatus_tipo_responsable").val(datos.id_estado_logico);
        $("#div_estatus").show();
        $("#modalDatosTipoResponsable").modal("show");
    },
  });
}

function AgregarActualizarTipoResponsable(id_tipo_responsable) {

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "tiporesponsable/AgregarActualizarTipoResponsable/" + id_tipo_responsable,
    data: $("#formModalTipoResponsable").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      $("#modalDatosTipoResponsable").modal("hide");  
      if (respuesta == 1) {
        
        swal("Tipo Responsable agregado o actualizado con éxito", "", "success");
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

