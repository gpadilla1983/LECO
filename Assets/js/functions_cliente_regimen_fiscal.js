btn_consultarClick();

$('#table-cliente_regimen_fiscal').DataTable({
    responsive: true
});

function btn_consultarClick() {
  var ArrayPOST = {
    ddl_estatus: $("#ddl_estatus").val(),
    ddl_tipo_cliente: $("#ddl_tipo_cliente").val(),
    ddl_regimen_fiscal: $("#ddl_regimen_fiscal").val(),
  };

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "relClienteRegimenFiscal/ObtenerClienteRegimenFiscal",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-cliente_regimen_fiscal").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "tipo_cliente", className: "text-center" },
            { data: "datos_cliente", className: "text-center" },
            { data: "datos_regimen_fiscal", className: "text-center" },
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

$("#btn_agregar_cliente_regimen_fiscal").bind("click", async (e) => {
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
    url: base_url + "ModalClienteRegimenFiscal/0",
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

  $("#modalDatosClienteRegimenFiscal").modal("show");
});

async function EditarClienteRegimenFiscal(id_cliente_regimen_fiscal) {
  if ($("#ajax-content").length) {
    $("#ajax-content").remove();
  }

 //debugger;

  var ajaxcontent = document.createElement("div");

  ajaxcontent.setAttribute("id", "ajax-content");

  
  var html = await $.ajax({
    type: "GET",
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "ModalClienteRegimenFiscal/" + id_cliente_regimen_fiscal,
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "relClienteRegimenFiscal/getClienteRegimenFiscal/" + id_cliente_regimen_fiscal,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);


        //console.log(datos.id_cliente);
        //console.log(datos.id_regimen_fiscal);
        //console.log(datos.id_estado_logico);
        $("#tbx_tipo_cliente").val(datos.tipo_cliente);
        $("#tbx_cliente").val(datos.datos_cliente);
        $("#tbx_regimen_fiscal").val(datos.datos_regimen_fiscal);
        $("#ddl_estatus_cliente_regimen_fiscal").val(datos.id_estado_logico);
        $("#div_estatus").show();
        $("#modalDatosClienteRegimenFiscal").modal("show");
    },
  });
}


function AgregarActualizarClienteRegimenFiscal(id_cliente_regimen_fiscal) {

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    
    url: base_url + "relClienteRegimenFiscal/AgregarActualizarClienteRegimenFiscal/" + id_cliente_regimen_fiscal,
    data: $("#formModalClienteRegimenFiscal").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      $("#modalDatosClienteRegimenFiscal").modal("hide");  
      if (respuesta == 1) {
        swal("Relación Cliente - Régimen Fiscal actualizada con éxito", "", "success");
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

