btn_consultarClick();

$('#table-cliente_usuario_int').DataTable({
    responsive: true
});

function clienteSinUsuarioInt() {  
  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "sistClienteUsuarioInt/ObtenerClienteSinUsuarioInt",
    data: {},
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-cliente_sin_usuario_int").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            //{ data: "id_usuario_cliente", className: "text-center" },
            { data: "rfc", className: "text-center" },
            { data: "curp", className: "text-center" },
            { data: "razon_social", className: "text-center" },
            { data: "f_captura", className: "text-center" },
            { data: "estado_logico", className: "text-center" },
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
        $("#div_resultados_sin_usuario_int").show("swing");
        swal("Información cargada correctamente.", "", "success");
      } else {
        $("body").dynamicSpinnerDestroy({});
        $("#div_resultados_sin_usuario_int").hide("swing");
        swal(
          "No se encontraron resultados de acuerdo a sus parametros de busqueda.", "", "error");
      }

      $('[data-toggle="tooltip"]').tooltip();
    },
  });

}

function btn_consultarClick() {

  var ArrayPOST = {
    ddl_estatus: $("#ddl_estatus").val(),
    ddl_clienteb: $("#ddl_clienteb").val(),
    ddl_usuariob: $("#ddl_usuariob").val(),
    ddl_usuario_auxb: $("#ddl_usuario_auxb").val(),
  };

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "sistClienteUsuarioInt/ObtenerClienteUsuarioInt",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-cliente_usuario_int").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            //{ data: "id_usuario_cliente", className: "text-center" },
            { data: "razon_social", className: "text-center" },
            { data: "usuario", className: "text-center" },
            { data: "usuario_aux", className: "text-center" },
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
  clienteSinUsuarioInt();
}

$("#btn_agregar_cliente_usuario_int").bind("click", async (e) => {
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
    url: base_url + "ModalClienteUsuarioInt/0",
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

  $("#modalDatosClienteUsuarioInt").modal("show");
});

async function EditarClienteUsuarioInt(id_usuario_cliente) {
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

    url: base_url + "ModalClienteUsuarioInt/" + id_usuario_cliente,
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "sistClienteUsuarioInt/getClienteUsuarioInt/" + id_usuario_cliente,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);
        
        if(datos.id_usuario_auxiliar == null){
            datos.id_usuario_auxiliar = "0";
        }
       
        $("#ddl_estatus_cliente_usuario_int").val(datos.id_estado_logico);
        $("#ddl_cliente").val(datos.id_cliente);
        $("#ddl_usuario").val(datos.id_usuario);
        $("#ddl_usuario_aux").val(datos.id_usuario_auxiliar);
        $("#div_estatus").show();
        $("#modalDatosClienteUsuarioInt").modal("show");
    },
  });
}

function AgregarActualizarClienteUsuarioInt(id_usuario_cliente) {
//debugger;
  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "sistClienteUsuarioInt/AgregarActualizarClienteUsuarioInt/" + id_usuario_cliente,
    data: $("#formModalClienteUsuarioInt").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      $("#modalDatosClienteUsuarioInt").modal("hide");  
      if (respuesta == 1) {
        
        swal("Relacion Cliente - Usuario Asignado/Auxiliar, agregada o actualizada con éxito", "", "success");
        btn_consultarClick();
      } else {
        if (respuesta == 0) {
          swal("Error", "La Relación Cliente - Usuario Asignado, se encuentra registrada, favor de validar", "error");
        } else {
          swal("Error", respuesta, "error");
        }
      }
    },
  });

  return false;
}

