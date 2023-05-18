btn_consultarClick();

$('#table-cartera_cliente').DataTable({
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
    url: base_url + "CarteraClientes/ObtenerCarteraCliente",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-cartera_cliente").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            //{ data: "id_cliente", className: "text-center" },
            { data: "tipo_cliente", className: "text-center" },
            { data: "rfc", className: "text-center" },
            { data: "curp", className: "text-center" },
            { data: "razon_social", className: "text-center" },
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


async function ActivarCliente(id_cliente) {
  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

     url: base_url + "CarteraClientes/ActivarCliente/" + id_cliente,
     success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      if (respuesta == 1) {
   
        swal("Cliente Activado con éxito", "", "success");
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

async function DesactivarCliente(id_cliente) {
  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

     url: base_url + "CarteraClientes/DesactivarCliente/" + id_cliente,
     success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      if (respuesta == 1) {
   
        swal("Cliente Inactivado con éxito", "", "success");
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

