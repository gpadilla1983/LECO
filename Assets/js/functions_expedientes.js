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
    document.getElementById("id_cliente_caso_legal").value = "";
    document.getElementById("tbx_id_file_cliente").value = "";
    document.getElementById("tbx_id_cliente_caso_legal").value = "";
    document.getElementById("tbx_razonSocial").value = "";
}

function BuscarCasoLegal() 
{
    limpia_campos();
    $.ajax({
      type: "POST",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      url: base_url + "Expedientes/ObtenerCasoLegal",
      data: {},
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

function habilitaInicio()
{
    $("#div_busqueda").show();    
    $("#div_CasosLegalesRegistrados").show();   
    $("#div_datosGenerales").hide(); 
    $("#div_resultados").hide();
    $("#div_botonesArchivos").hide(); 
    $("#div_encabezado").hide(); 
    BuscarCasoLegal();  
}

function VerCasoLegal(id_cliente_caso_legal)
{
    $.ajax({
      type: "GET",
      async: true,
      beforeSend: function () {
        $("body").dynamicSpinner({
          loadingText: "Cargando...",
        });
      },
      
      url: base_url + "Expedientes/getClienteCasoLegal/" + id_cliente_caso_legal,
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
        $("#tbx_numExpdiente").html("<b>" + respuesta.no_expediente + "</b>");

        var campo = document.getElementById("ddl_Cliente");
        var cliente = campo.options[campo.selectedIndex].text;
        $("#tbx_razonSocial").html("<b>" + cliente + "</b>");

        $("body").dynamicSpinnerDestroy({});

        habilitaVistaCapturaCasoLegal();
      },
    });
}


function habilitaVistaCapturaCasoLegal()
{
  $("#div_datosGenerales").show(); 
  $("#div_CasosLegalesRegistrados").hide();   
  $("#div_resultados").show();
  $("#div_encabezado").show(); 
  $("#div_botonesArchivos").show();
  buscarExpediente();

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
        url: base_url + "FilesClientes/ObtenerExpedientesExternos",
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
                        //{ data: "Estatus", className: "text-center" },
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
                swal("No se encontraron registros de Asunto del Seguimiento/Documento", "", "error");
            }
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
}

function text_change(id_elemento) {
    $('#modalVisor').modal('show')
    $("#TitleModal").html("Archivo");
    var file = URL.createObjectURL(id_elemento.files[0]);
    document.getElementById("iframe_visor").src = file;
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


