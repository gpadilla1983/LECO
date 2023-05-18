btn_consultarClick();

$('#table-usuarios').DataTable({
    responsive: true
});

function btn_consultarClick() {
  var ArrayPOST = {
    ddl_perfil: $("#ddl_perfil").val(),
    ddl_estatus: $("#ddl_estatus").val(),
    ddl_paisb: $("#ddl_paisb").val(),
    ddl_entidad_federativab: $("#ddl_entidad_federativab").val(),
    ddl_alcaldia_municipiob: $("#ddl_alcaldia_municipiob").val(),

  };

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "usuarios/ObtenerUsuarios",
    data: ArrayPOST,
    success: function (data) {
      respuesta = JSON.parse(data);
      if (respuesta.length > 0) {
        $("#table-usuarios").DataTable({
          data: respuesta,
          responsive: "true",
          bAutoWidth: false,
          destroy: true,
          language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
          },
          columns: [
            { data: "row", className: "text-center" },
            { data: "nombre_completo", className: "text-center" },
            { data: "usuario", className: "text-center" },
            { data: "e_mail", className: "text-center" },
            { data: "perfil", className: "text-center" },
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

$("#btn_agregar_usuario").bind("click", async (e) => {
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
    url: base_url + "ModalUsuarios/0",
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
  $("#div_checkbox").hide();

  $("#modalDatosUsuario").modal("show");
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

        $("#ddl_entidad_federativa").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "0" selected>Seleccione...</option>';
    $("#ddl_entidad_federativa").html(opciones);
  }
}

async function Obtenermunicipio(ddl_entidad_federativa) {
  var ddl_entidad_federativa = $("#ddl_entidad_federativa").val();
  if (ddl_entidad_federativa != null) {
    await $.ajax({
      type: "GET",
      url: base_url + "catalogos/ObtenerMunicipios/" + ddl_entidad_federativa,
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

        $("#ddl_alcaldia_municipio").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "0" selected>Seleccione...</option>';
    $("#alcaldia_municipio").html(opciones);
  }
}

async function ObtenerEntidadB(ddl_paisb) {
  var ddl_paisb = $("#ddl_paisb").val();
  if (ddl_paisb != null) {
    await $.ajax({
      type: "GET",
      url: base_url + "catalogos/ObtenerEntidad/" + ddl_paisb,
      dataType: "json",
      beforeSend: function () {},
      success: function (respuesta) {
        var datos = respuesta;
        var opciones = '<option value = "-1" selected>Todos</option>';
        datos.forEach((element) => {
          var cadena =
            "<option value=" +
            element.id_entidad_federativa +
            "> " +
            element.desc_larga +
            "</option>";
          opciones = opciones + cadena;
        });

        $("#ddl_entidad_federativab").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "-1" selected>Todos</option>';
    $("#ddl_entidad_federativab").html(opciones);
  }
}

async function ObtenermunicipioB(ddl_entidad_federativab) {
  var ddl_entidad_federativab = $("#ddl_entidad_federativab").val();
  if (ddl_entidad_federativab != null) {
    await $.ajax({
      type: "GET",
      url: base_url + "catalogos/ObtenerMunicipios/" + ddl_entidad_federativab,
      dataType: "json",
      beforeSend: function () {},
      success: function (respuesta) {
        var datos = respuesta;
        var opciones = '<option value = "-1" selected>Todos</option>';
        datos.forEach((element) => {
          var cadena =
            "<option value=" +
            element.id_alcaldia_municipio +
            "> " +
            element.desc_larga +
            "</option>";
          opciones = opciones + cadena;
        });

        $("#ddl_alcaldia_municipiob").html(opciones);
      },
      error: function (data) {
        console.log(data);
      },
    });
  } else {
    var opciones = '<option value = "-1" selected>Todos</option>';
    $("#alcaldia_municipiob").html(opciones);
  }
}




async function EditarUsuario(id_usuario) {
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

    url: base_url + "ModalUsuarios/" + id_usuario,
  });

  ajaxcontent.innerHTML += html;

  $("#cuerpo-content").append(ajaxcontent);

  $.ajax({
    type: "GET",
    async: true,
    url: base_url + "usuarios/getUsuario/" + id_usuario,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);
        //console.log(datos);
        checkeado();
        $("#div_checkbox").show();
        $("#div_contrasena").hide();
        $("#tbx_nombre_usuario").val(datos.nombre);
        $("#tbx_apellidop_usuario").val(datos.primer_apellido);
        $("#tbx_apellidom_usuario").val(datos.segundo_apellido);
        $("#tbx_email_usuario").val(datos.e_mail);
        $("#tbx_puesto").val(datos.puesto);
        $("#tbx_movil").val(datos.celular);
        $("#tbx_rfc").val(datos.rfc);
        $("#tbx_curp").val(datos.curp);
        $("#tbx_fec_nac").val(datos.f_nacimiento);
        $("#tbx_fec_ingreso").val(datos.f_ingreso);
        $("#tbx_usuario").val(datos.usuario);
        $("#tbx_contrasena").val(datos.contrasena);
        $("#ddl_role").val(datos.id_perfil);


        $("#tbx_calle").val(datos.calle);
        $("#tbx_no_exterior").val(datos.no_exterior);
        $("#tbx_no_interior").val(datos.no_interior);
        $("#tbx_colonia").val(datos.colonia);
        $("#ddl_alcaldia_municipio").val(datos.id_alcaldia_municipio);
        $("#ddl_entidad_federativa").val(datos.id_entidad_federativa);
        $("#ddl_pais").val(datos.id_pais);
        $("#tbx_codigo_postal").val(datos.codigo_postal);
        $("#tbx_tel_fijo").val(datos.tel_fijo);



        $("#ddl_estatus_usuario").val(datos.id_estado_logico);
        $("#div_estatus").show();
        $("#modalDatosUsuario").modal("show");

    },
  });
}

function AgregarActualizarUsuario(id_usuario) {

  $.ajax({
    type: "POST",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },

    url: base_url + "usuarios/AgregarActualizarUsuario/" + id_usuario,
    data: $("#formModalUsuario").serialize(),
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      $("#modalDatosUsuario").modal("hide");
      if (respuesta == 1) {
        swal("Usuario agregado o actualizado con éxito", "", "success");
        btn_consultarClick();
      } else {
        if (respuesta == 0) {
          swal("Error", "Lo sentimos ha ocurrido un error", "error");
        } else {
          swal("Error", respuesta, "error");
        }
      }
    },
  });

  return false;
}


function checkeado (){
    $(document).on('change','input[type="checkbox"]' ,function(e) {
        
            if(this.checked) 
            {
            $('#div_contrasena').show();
            $("#tbx_contrasena").val("");
            $("#valor_check").val(this.value);
            }
            else
            { 
            $('#div_contrasena').hide();
            $("#valor_check").val(0);
            }
       
       
    });
}
