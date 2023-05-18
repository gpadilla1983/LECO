habilitaInicio();

var Archivo ="";

$('#table-expediente').DataTable({
    responsive: true
});

function limpia_campos() {
    document.getElementById("ddl_tipoCasoLegal").value = 0;
    document.getElementById("ddl_Cliente").value = 0;
    document.getElementById("ddl_juzgado").value = 0;
    document.getElementById("ddl_pais").value = 0;
    document.getElementById("ddl_entidad_federativa").value = 0;
    document.getElementById("ddl_alcaldia_municipio").value = 0;
    document.getElementById("ddl_estatus_cliente_caso_legal").value = 0;
    document.getElementById("tbx_f_inicio").value = "";
    document.getElementById("tbx_f_termino").value = "";
    document.getElementById("tbx_contraparte").value = "";
    document.getElementById("tbx_desc_larga").value = "";
    document.getElementById("tbx_no_expediente").value = "";
    document.getElementById("tbx_numExpdiente").value = ""; 
    document.getElementById("tbx_id_cliente2").value = "";
    document.getElementById("tbx_asunto").value = "";
    document.getElementById("ddl_estatus_caso_legal").value = 0;
    document.getElementById("tbx_f_docto").value = "";
    document.getElementById("tbx_f_seguimiento").value = "";
    document.getElementById("tbx_asuntoCap").value = "";
    document.getElementById("ddl_tipo_archivo").value = 0;
    document.getElementById("ddl_estatus_archivo").value = 0;
    document.getElementById("id_cliente_caso_legal").value = "";
    document.getElementById("tbx_id_file_cliente").value = "";
    document.getElementById("tbx_id_cliente_caso_legal").value = "";
    document.getElementById("tbx_razonSocial").value = "";
}

function BuscarCasoLegal() 
{
    var ArrayPOST = {
      ddl_tipoCasoLegalB: $("#ddl_tipoCasoLegalB").val(),
      ddl_paisB: $("#ddl_paisB").val(),
      ddl_entidad_federativaB: $("#ddl_entidad_federativaB").val(),
      ddl_alcaldia_municipioB: $("#ddl_alcaldia_municipioB").val(),
      ddl_juzgadoB: $("#ddl_juzgadoB").val(),
      ddl_estatus_cliente_caso_legalB: $("#ddl_estatus_cliente_caso_legalB").val(),
      no_expedienteB: $("#tbx_no_expedienteB").val(),

    };

    limpia_campos();
    $.ajax({
      type: "POST",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      url: base_url + "CasoLegal/ObtenerCasoLegal",
      data: ArrayPOST,
      success: function (data) {
        respuesta = JSON.parse(data);
  
        if(respuesta.length>0){
            if (respuesta.length > 0) {
              $("#table-casos_legales").DataTable({
                data: respuesta,
                responsive: "true",
                bAutoWidth: false,
                destroy: true,
                language: {
                  url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
                },
                columns: [
                  { data: "row", className: "text-center" },
                  //{ data: "id_cliente_caso_legal", className: "text-center" },
                  { data: "tipo_caso_legal", className: "text-center" },
                  { data: "no_expediente", className: "text-center" },
                  { data: "razon_social", className: "text-center" },
                  { data: "desc_larga", className: "text-center" },  
                  { data: "ubicacion", className: "text-center"},              
                  { data: "f_inicio", className: "text-center" },
                  { data: "f_termino", className: "text-center" },
                  { data: "juzgado", className: "text-center" },
                  { data: "contraparte", className: "text-center" },
                  { data: "estado_logico", className: "text-center" },
                  { data: "acciones", className: "text-center" },
                ],
                dom: "Bfrtip",
                buttons: [
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
                
              });
              $("body").dynamicSpinnerDestroy({});
                swal("Información cargada correctamente.", "", "success");             
            } else {
              $("body").dynamicSpinnerDestroy({});
            }
            $('[data-toggle="tooltip"]').tooltip();
        }else{
          $("body").dynamicSpinnerDestroy({});
            swal("No se encontraron resultados de acuerdo a sus parametros de busqueda.", "", "error");
        }
      },
    });
}

function habilitaCapturaCasoLegal()
{
    $("#div_datosGenerales").show(); 
    $("#div_busqueda").hide();    
    $("#div_CasosLegalesRegistrados").hide();   
    $("#div_archivos").hide(); 
    $("#div_resultados").hide();
    $("#btn_verArchivo").hide(); 
    $("#btn_irExpedientes").hide(); 
    $("#div_botonesArchivos").hide(); 
    $("#div_encabezado").hide(); 
    $("#btn-agregarcasolegal").hide();
}


function habilitaVistaCapturaCasoLegal()
{
  $("#div_datosGenerales").show(); 
  $("#div_busqueda").hide();    
  $("#div_CasosLegalesRegistrados").hide();   
  $("#div_archivos").hide(); 
  $("#div_resultados").hide();
  $("#btn_verArchivo").hide(); 
  $("#btn_irExpedientes").show(); 
  $("#div_botonesArchivos").hide(); 
  $("#div_encabezado").hide(); 
  $("#btn-agregarcasolegal").hide();
}

function habilitaCapturaExpediente()
{
    $("#div_datosGenerales").hide(); 
    $("#div_busqueda").hide();    
    $("#div_CasosLegalesRegistrados").hide();   
    $("#div_archivos").show(); 
    $("#div_resultados").show();
    $("#btn_verArchivo").hide();  
    $("#btn_irExpedientes").hide();  
    $("#div_botonesArchivos").show(); 
    $("#div_encabezado").show(); 
    $("#btn-agregarcasolegal").hide();
}

function habilitaInicio()
{
    $("#div_busqueda").show();    
    $("#div_CasosLegalesRegistrados").show();   
    $("#div_datosGenerales").hide(); 
    $("#div_archivos").hide(); 
    $("#div_resultados").hide();
    $("#btn_verArchivo").hide();   
    $("#btn_irExpedientes").hide();  
    $("#div_botonesArchivos").hide(); 
    $("#div_encabezado").hide(); 
    BuscarCasoLegal();  
    $("#btn-agregarcasolegal").show();
}

function nuevoCasoLegal() 
{
    limpia_campos();
    habilitaCapturaCasoLegal();   
}

async function ObtenerEntidad(ddl_pais) 
{
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
  
async function Obtenermunicipio(ddl_entidad_federativa) 
{
    var ddl_entidad_federativa = $("#ddl_entidad_federativa").val();
    if (ddl_entidad_federativa != null) {
      await $.ajax({
        type: "GET",
        url: base_url + "catalogos/ObtenerMunicipios/" + ddl_entidad_federativa,
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
  
          $("#ddl_alcaldia_municipio").html(opciones);
        },
        error: function (data) {
          console.log(data);
        },
      });
    } else {
      var opciones = '<option value = "0" selected>Seleccione...</option>';
      $("#ddl_alcaldia_municipio").html(opciones);
    }
}




async function ObtenerEntidadB(ddl_pais) 
{
    var ddl_pais = $("#ddl_paisB").val();
    if (ddl_pais != null) {
      await $.ajax({
        type: "GET",
        url: base_url + "catalogos/ObtenerEntidad/" + ddl_pais,
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
  
          $("#ddl_entidad_federativaB").html(opciones);
        },
        error: function (data) {
          console.log(data);
        },
      });
    } else {
      var opciones = '<option value = "-1" selected>Todos</option>';
      $("#ddl_entidad_federativaB").html(opciones);
    }
}
  
async function ObtenermunicipioB(ddl_entidad_federativa) 
{
    var ddl_entidad_federativa = $("#ddl_entidad_federativaB").val();
    if (ddl_entidad_federativa != null) {
      await $.ajax({
        type: "GET",
        url: base_url + "catalogos/ObtenerMunicipios/" + ddl_entidad_federativa,
        dataType: "json",
        beforeSend: function () {},
        success: function (respuesta) {
          var datos = respuesta;
          var opciones = '<option value = "-1">Todos</option>';
          datos.forEach((element) => {
            var cadena =
              "<option value=" +
              element.id_alcaldia_municipio +
              "> " +
              element.desc_larga +
              "</option>";
            opciones = opciones + cadena;
            
          });
  
          $("#ddl_alcaldia_municipioB").html(opciones);
        },
        error: function (data) {
          console.log(data);
        },
      });
    } else {
      var opciones = '<option value = "-1" selected>Todos</option>';
      $("#ddl_alcaldia_municipioB").html(opciones);
    }
}



async function AgregarActualizarDatosGenerales() 
{ 
    await $.ajax({
        type: "POST",
        async: true,
        beforeSend: function () {
        $("body").dynamicSpinner({
            loadingText: "Cargando...",
        });
        },

        url: base_url + "CasoLegal/AgregarActualizarDatosGenerales",
        data: $("#formDatosGenerales").serialize(),
        success: function (respuesta) {
        $("body").dynamicSpinnerDestroy({});
      
        if (respuesta > 0) {
            EditarCasoLegal(respuesta); 
            swal("Caso Legal Agregado o Actualizado con éxito", "", "success");
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

function EditarCasoLegal(id_cliente_caso_legal)
{
    $.ajax({
      type: "GET",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      
      url: base_url + "CasoLegal/getClienteCasoLegal/" + id_cliente_caso_legal,
      data: {}, 
      success: function (data) {
        var respuesta = JSON.parse(data);
        
        $("#id_cliente_caso_legal").val(respuesta.id_cliente_caso_legal);
        $("#tbx_no_expediente").val(respuesta.no_expediente);
        $("#tbx_desc_larga").val(respuesta.desc_larga);
        $("#ddl_Cliente").val(respuesta.id_cliente);
        $("#tbx_f_inicio").val(respuesta.f_inicio);
        $("#tbx_f_termino").val(respuesta.f_termino);
        $("#ddl_juzgado").val(respuesta.id_juzgado);
        $("#tbx_contraparte").val(respuesta.contraparte);
        $("#ddl_pais").val(respuesta.id_pais);
        $("#ddl_entidad_federativa").val(respuesta.id_entidad_federativa);
        $("#ddl_alcaldia_municipio").val(respuesta.id_alcaldia_municipio);    
        $("#ddl_estatus_cliente_caso_legal").val(respuesta.id_estado_logico);
        $("#ddl_tipoCasoLegal").val(respuesta.id_tipo_caso_legal);

        $("#tbx_id_cliente_caso_legal").val(respuesta.id_cliente_caso_legal);
        $("#tbx_id_cliente2").val(respuesta.id_cliente);
        $("#tbx_numExpdiente").html(respuesta.no_expediente);

        var campo = document.getElementById("ddl_Cliente");
        var cliente = campo.options[campo.selectedIndex].text;
        $("#tbx_razonSocial").html(cliente);

        $("body").dynamicSpinnerDestroy({});

        habilitaVistaCapturaCasoLegal();
      },
    });
}

function Cancelar()
{
    habilitaInicio();
    limpia_campos();
    BuscarCasoLegal();
}

function visualizarArchivos()
{
    $("#div_botonesArchivos").show(); 
    $("#div_encabezado").show(); 
    $("#div_archivos").hide(); 
    $("#div_busqueda").hide();    
    $("#div_CasosLegalesRegistrados").hide();   
    $("#div_datosGenerales").hide(); 
    $("#div_resultados").hide();
    $("#btn_verArchivo").hide();   
    $("#btn_irExpedientes").hide();  
}

function buscarExpediente()
{
  debugger;
    var ArrayPOST = {
        id_cliente_caso_legal: $("#tbx_id_cliente_caso_legal").val(),
        Asunto: $("#tbx_asunto").val(),
    };
    
    $.ajax({
        type: "POST",
        async: true,
        beforeSend: function () {
          $("body").dynamicSpinner({
            loadingText: "Cargando...",
          });
        },
        url: base_url + "FilesClientes/ObtenerExpedientes",
        data: ArrayPOST,
        success: function (data) {
            respuesta = JSON.parse(data);
            if (respuesta.length > 0) {
                $("#table-expediente").DataTable({
                    data: respuesta,
                    bAutoWidth: false,
                    destroy: true,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
                    },
                    columns: [
                        { data: "row", className: "text-center" },
                        { data: "file_asunto", className: "text-center" },
                        //{ data: "id_cliente", className: "text-center" },
                        //{ data: "id_cliente_caso_legal", className: "text-center" },
                        //{ data: "id_estado_caso_legal", className: "text-center" },
                        { data: "estado_caso_legal", className: "text-center" },
                        { data: "f_seguimiento", className: "text-center" },
                        { data: "id_tipo_documento", className: "text-center" },
                        { data: "f_docto", className: "text-center" },
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
                $("#div_resultados").show("swing");
                swal("Información cargada correctamente.", "", "success");
            } else {
                $("body").dynamicSpinnerDestroy({});
                $("#div_resultados").hide("swing");
                swal("No se encontraron resultados de acuerdo a sus parametros de busqueda.", "", "error");
            }
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
}

function limpia_camposArchivos(){
    document.getElementById("ddl_estatus_caso_legal").value = 0;
    document.getElementById("tbx_f_docto").value = "";
    document.getElementById("tbx_f_seguimiento").value = "";
    document.getElementById("tbx_asuntoCap").value = "";
    document.getElementById("ddl_tipo_archivo").value = 0;
    document.getElementById("ddl_estatus_archivo").value = 0;
}
  
function capturaNuevoExpediente(){
    $("#div_archivos").show();
    $("#div_botonesArchivos").hide(); 
    $("#div_encabezado").show(); 
    $("#div_busqueda").hide();    
    $("#div_CasosLegalesRegistrados").hide();   
    $("#div_datosGenerales").hide(); 
    $("#div_resultados").hide();
    $("#btn_verArchivo").hide();   
    $("#btn_irExpedientes").hide();  
    input=document.getElementById("file_expediente");
        input.value = ''
    limpia_camposArchivos();
}

function text_change(id_elemento) {
    $('#modalVisor').modal('show')
    $("#TitleModal").html("Archivo");
    var file = URL.createObjectURL(id_elemento.files[0]);
    document.getElementById("iframe_visor").src = file;
}

function SubirArchivo(){
    //Read File
    var selectedFile = document.getElementById("file_expediente").files;

    //Check File is not Empty
    if (selectedFile.length > 0) {
        // Select the very first file from list
        var fileToLoad = selectedFile[0];
        // FileReader function for read the file.
        var fileReader = new FileReader();
        var base64;
        // Onload of file read the file content
        fileReader.onload = function(fileLoadedEvent) {
            base64 = fileLoadedEvent.target.result;
            // Print data in console
            Archivo = base64;
           guardarExpediente(Archivo);
        };
        // Convert data to base64
        fileReader.readAsDataURL(fileToLoad);    
    }else{
        swal("Error","El campo Archivo es obligatorio","error");
    }
}

function ObtenerIdFileCliente ()
{
    id_file = $("#tbx_id_file_cliente").val(),
    Verdocumento(id_file);
}

function Verdocumento(id_file_cliente)
{
  $.ajax({
    type: "GET",
    async: true,
    beforeSend: function () {
      $("body").dynamicSpinner({
        loadingText: "Cargando...",
      });
    },
    url: base_url + "FilesClientes/ObtenerFileContent/" + id_file_cliente,
    success: function (respuesta) {
      $("body").dynamicSpinnerDestroy({});
      var datos = JSON.parse(respuesta);
      //console.log(datos.file_content);
      $('#modalVisor').modal('show');
      $("#TitleModal").html("Archivo");
      var file = datos.file_content;
      document.getElementById("iframe_visor").src = file;
    },
  });
}

function habilitarEditarArchivo(){
  $("#div_archivos").show();
  $("#btn_verArchivo").show();  
  $("#div_resultados").hide();
  $("#div_botonesArchivos").hide(); 
  $("#div_encabezado").show(); 
}

function EditarDocumento(id_file_cliente){
  habilitarEditarArchivo();

  $.ajax({
      type: "GET",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      url: base_url + "FilesClientes/ObtenerDocumento/" + id_file_cliente,
      data: {},
      success: function (data) {
        var respuesta = JSON.parse(data);
        
        $("#tbx_id_file_cliente").val(respuesta.id_file_cliente);
        $("#tbx_asuntoCap").val(respuesta.file_asunto);
        $("#tbx_id_cliente2").val(respuesta.id_cliente);
        $("#id_cliente_caso_legal").val(respuesta.id_cliente_caso_legal);
        $("#tbx_f_docto").val(respuesta.f_docto);
        $("#tbx_f_seguimiento").val(respuesta.f_seguimiento);
        $("#ddl_estatus_archivo").val(respuesta.id_estado_logico);
        $("#ddl_estatus_caso_legal").val(respuesta.id_estado_caso_legal);
        $("#ddl_tipo_archivo").val(respuesta.id_tipo_documento);

        $("body").dynamicSpinnerDestroy({});
      },
  });
}

function CancelarArchivos(){
    $("#div_botonesArchivos").show();
    $("#div_encabezado").show(); 
    $("#div_archivos").hide();
    $("#btn_verArchivo").hide();
    document.getElementById("tbx_id_file_cliente").value = "";  
    buscarExpediente();
}

function guardarExpediente(Archivo){
  var ArrayPOST = {
    id_estado_logico: $("#ddl_estatus_archivo").val(),
    id_file_cliente: $("#tbx_id_file_cliente").val(),
    Asunto: $("#tbx_asuntoCap").val(),
    id_cliente: $("#tbx_id_cliente2").val(),
    id_cliente_caso_legal: $("#id_cliente_caso_legal").val(),
    f_docto: $("#tbx_f_docto").val(),
    f_seguimiento: $("#tbx_f_seguimiento").val(),
    id_estado_caso_legal: $("#ddl_estatus_caso_legal").val(),
    id_tipo_documento: $("#ddl_tipo_archivo").val(),
    Archivo: Archivo,
  };
   
  $.ajax({
      type: "POST",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
  
      url: base_url + "FilesCliente/GuardarExpediente",
      data: ArrayPOST,
      success: function (respuesta) {
        $("body").dynamicSpinnerDestroy({});
        
        if (respuesta == 1) {
          swal("¡Éxito!", "Expediente cargado satisfactoriamente", "success");
          input=document.getElementById("file_expediente");
              input.value = ''
              CancelarArchivos();
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

function ActualizarExpedienteSinArchivo() {

  var ArrayPOST = {
    id_estado_logico: $("#ddl_estatus_archivo").val(),
    id_file_cliente: $("#tbx_id_file_cliente").val(),
    Asunto: $("#tbx_asuntoCap").val(),
    id_cliente: $("#tbx_id_cliente2").val(),
    id_cliente_caso_legal: $("#id_cliente_caso_legal").val(),
    f_docto: $("#tbx_f_docto").val(),
    f_seguimiento: $("#tbx_f_seguimiento").val(),
    id_estado_caso_legal: $("#ddl_estatus_caso_legal").val(),
    id_tipo_documento: $("#ddl_tipo_archivo").val(),
  };
 
  $.ajax({
      type: "POST",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
  
      url: base_url + "FilesCliente/ActualizarExpedienteSinArchivo",
      data: ArrayPOST,
      success: function (respuesta) {
        $("body").dynamicSpinnerDestroy({});
        
        if (respuesta == 1) {
          swal("¡Éxito!", "Expediente cargado satisfactoriamente", "success");
          CancelarArchivos();
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