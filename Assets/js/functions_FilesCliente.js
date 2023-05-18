$("#div_resultados").hide();
$("#divCapturaExp").hide();
var Archivo ="";

$('#table-expediente').DataTable({
    responsive: true
});

function  buscarExpedientePrincipal(){
    $("#div_buscar_Exp").show();
    $("#divCapturaExp").hide();
    $("#div_resultados").hide();
    $("#tbx_numExpdiente").val("");
    $("#tbx_asunto").val("");
}


function  CapturaExpediente(){
    $("#div_buscar_Exp").hide();
    $("#divCapturaExp").show();
    $("#div_resultados").hide();
    $("#tbx_numExpdienteCap").val("");
    $("#tbx_asuntoCap").val("");
    input=document.getElementById("file_expediente");
        input.value = ''
   
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
        swal(
            "Lo sentimos",
            "El campo Archivo es obligatorio",
            "error"
          );
    }
   
}



function guardarExpediente(Archivo) {

    var ArrayPOST = {
        NumeroExpediente: $("#tbx_numExpdienteCap").val(),
        Asunto: $("#tbx_asuntoCap").val(),
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
                
               buscarExpediente();
                swal("¡Éxito!", "Expediente cargado satisfactoriamente", "success");
                $("#tbx_numExpdienteCap").val("");
                $("#tbx_asuntoCap").val("");
                input=document.getElementById("file_expediente");
                    input.value = ''
                //AquiCargariamos la tabla
              } else {
                if (respuesta == 0) {
                  swal("Error", "Lo sentimos el archivo no se ha podido cargar correctamente", "error");
                } else {
                  swal("Error", respuesta, "error");
                }
              }
            },
          });
        
          return false;
   
}


function buscarExpediente()
{
    var ArrayPOST = {
        NumeroExpediente: $("#tbx_numExpdiente").val(),
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
            //   responsive: true,
            bAutoWidth: false,
            destroy: true,
              language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
              },
              columns: [
                { data: "row", className: "text-center" },
                { data: "file_expediente", className: "text-center" },
                { data: "file_asunto", className: "text-center" },
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

function Verdocumento(id_file_cliente){

   
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
          console.log(datos.file_content);
          $('#modalVisor').modal('show');
          $("#TitleModal").html("Archivo");
          var file = datos.file_content;
          document.getElementById("iframe_visor").src = file;
        },
      });
}


function EliminarDocumento(id_file_cliente){
    var ArrayPOST = {
        idFileCliente : id_file_cliente
      };
   
  
        $.ajax({
            type: "POST",
            async: true,
            beforeSend: function () {
              $("body").dynamicSpinner({
                loadingText: "Cargando...",
              });
            },
        
            url: base_url + "FilesCliente/EliminarArchivo",
            data: ArrayPOST,
            success: function (respuesta) {
              $("body").dynamicSpinnerDestroy({});
             
              if (respuesta == 1) {
                
               buscarExpediente();
                swal("¡Éxito!", "Expediente actualizado satisfactoriamente", "success");
                $("#tbx_numExpdienteCap").val("");
                $("#tbx_asuntoCap").val("");
                input=document.getElementById("file_expediente");
                    input.value = ''
                //AquiCargariamos la tabla
              } else {
                if (respuesta == 0) {
                  swal("Error", "Lo sentimos el archivo no se ha podido actualizar correctamente", "error");
                } else {
                  swal("Error", respuesta, "error");
                }
              }
            },
          });
        
          return false;
}


function ActivarDocumento(id_file_cliente){
    var ArrayPOST = {
        idFileCliente : id_file_cliente
      };
   
  
        $.ajax({
            type: "POST",
            async: true,
            beforeSend: function () {
              $("body").dynamicSpinner({
                loadingText: "Cargando...",
              });
            },
        
            url: base_url + "FilesCliente/ActivarArchivo",
            data: ArrayPOST,
            success: function (respuesta) {
              $("body").dynamicSpinnerDestroy({});
             
              if (respuesta == 1) {
                
               buscarExpediente();
                swal("¡Éxito!", "Expediente actualizado satisfactoriamente", "success");
                $("#tbx_numExpdienteCap").val("");
                $("#tbx_asuntoCap").val("");
                input=document.getElementById("file_expediente");
                    input.value = ''
                //AquiCargariamos la tabla
              } else {
                if (respuesta == 0) {
                  swal("Error", "Lo sentimos el archivo no se ha podido actualizar correctamente", "error");
                } else {
                  swal("Error", respuesta, "error");
                }
              }
            },
          });
        
          return false;
}



