//#region Credits
/**
* dynamics.js v1.0.0 by @cibarra
* Copyright 2015 Code Retailers.
* Regions works with Web Essentials
* http://www.apache.org/licenses/LICENSE-2.0
*/
//#endregion

var timerClose = null;
function startTimer() {
    timerClose = window.setTimeout(function () {
        $("#btnClose").click();
    }, 20000);
}
//#region Dynamic Spinner
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔═╗┌─┐┬┌┐┌┌┐┌┌─┐┬─┐
*   ║║└┬┘│││├─┤│││││  └─┐  ╚═╗├─┘│││││││├┤ ├┬┘
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ╚═╝┴  ┴┘└┘┘└┘└─┘┴└─ 
* Función utilizada para cargar el spinner de Dynamics.
* Parametros: 
* elementID - El ID del div donde se empotrara el Spinner.
* loaderText - Texto descriptivo que se mostrara con el loader.
*/
(function ($) {
    $.fn.dynamicSpinner = function (options) {
        var settings = $.extend({
            // These are the defaults.
            loadingText: "Cargando...",
            elementID: $("body")
        }, options);
        $('<div id="screenBlock"></div>').appendTo(settings.elementID);
        $('#screenBlock').css({ opacity: 0, width: $(settings.elementID).width() * 1.1, height: $(settings.elementID).height() * 10000 });
        $('#screenBlock').addClass('blockDiv');
        $('#screenBlock').animate({ opacity: 0.7 }, 200);
        $('body').addClass('stop-scrolling');
        var html = "<div class='spinner'><img src='"+ base_url +"/Assets/images/spinner.gif' />";
        html += "<h2>" + settings.loadingText + "</h2></div>";
        var width = ($(settings.elementID).width() / 2.18);
        var height = '380px';//($(settings.elementID).height() / 3.5);//ori 3.5
        $(html).appendTo('#screenBlock');
        $(".spinner").css({ "margin-left": width });
        $(".spinner").css({ "margin-top": height });
    };
}(jQuery));
(function ($) {
    $.fn.dynamicSpinnerDestroy = function (options) {
        $('body').removeClass('stop-scrolling');
        $('#screenBlock').animate({ opacity: 0 }, 200, function () {
            //$('#screenBlock').remove();
            $("div[id=screenBlock]").remove();
        });
    };
}(jQuery));
//#endregion

//#region Dynamic Panels
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔═╗┌─┐┌┐┌┌─┐┬  ┌─┐
*   ║║└┬┘│││├─┤│││││  └─┐  ╠═╝├─┤│││├┤ │  └─┐
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ╩  ┴ ┴┘└┘└─┘┴─┘└─┘
* Función utilizada para generar los Paneles Dynamics.
* Parametros tomados de los atritubutos de los divs: 
* titulo - El ID del div donde se empotrara el Spinner.
* icono - Texto descriptivo que se mostrara con el loader.
*/
(function ($) {
    $.fn.dynamicPanels = function (options) {
        var html = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
        $(this).each(function (key, value) {
            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading" role="tab" id="' + $(value).attr("id") + 'Titulo">';
            html += '<h4 class="panel-title">';
            //html += '<i class="fa fa-' + $(value).attr("icono") + '"></i>';
            html += '<span class="icon-' + $(value).attr("icono") + '" aria-hidden="true"></span>';
            if (key == 0)
                html += '<a data-toggle="collapse" data-parent="#accordion" href="#' + $(value).attr("id") + '" aria-expanded="true" aria-controls="' + $(value).attr("id") + '" id="lnk' + $(value).attr("id") + '">';
            else
                html += '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#' + $(value).attr("id") + '" aria-expanded="false" aria-controls="' + $(value).attr("id") + '">';
            html += $(value).attr("titulo")
            html += '</a></h4></div>';
            if (key == 0)
                html += ' <div id="' + $(value).attr("id") + '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="' + $(value).attr("id") + 'Titulo">';
            else
                html += ' <div id="' + $(value).attr("id") + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="' + $(value).attr("id") + 'Titulo">';
            html += '<div class="panel-body"></div></div></div>'
        });
        html += '</div>';
        $("#contenido").html(html);
        //var randomColor = Math.random().toString(16).substring(2, 8);
        //$(".panel-body").css("border-right", "4px solid #" + randomColor);
        //$(".panel-body").css("border-bottom", "4px solid #" + randomColor);
    };
}(jQuery));
//#endregion

//#region Dynamic DropDown
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔╦╗┬─┐┌─┐┌─┐╔╦╗┌─┐┬ ┬┌┐┌
*   ║║└┬┘│││├─┤│││││  └─┐   ║║├┬┘│ │├─┘ ║║│ │││││││
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ═╩╝┴└─└─┘┴  ═╩╝└─┘└┴┘┘└┘
* Función utilizada para generar los DropDown Dynamics (Seleccion simple o múltiple).
* Parametros tomados de los atritubutos de los divs: 
* titulo - El ID del div donde se empotrara el Spinner.
* icono - Texto descriptivo que se mostrara con el loader.
*/
(function ($) {
    $.fn.dynamicDropDown = function (options) {
        var id = this.selector;
        var settings = $.extend({
            // These are the defaults.
            placeholder: "-Seleccionar-",
            id: "catalogoID",
            desc: "catalogoDescripcion",
            width: "90%"
        }, options);
        $(id).append("<option value='0'></option>")
        $(settings.data).each(function (key, value) {
            $(id).append('<option value=' + value[settings.id] + '>' + value[settings.desc] + '</option>')
        });
        $(id).chosen({
            no_results_text: "¡No se encontraron coincidencias!",
            allow_single_deselect: true,
            width: settings.width
        })
        $(id).parent().height("58px");
    };
}(jQuery));

(function ($) {
    $.fn.dynamicDropDownDestroy = function (options) {
        var id = this.selector;
        $(id).empty();
        $(id).chosen('destroy');
    };
}(jQuery));
//#endregion

//#region Dynamic Table
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔╦╗┌─┐┌┐ ┬  ┌─┐
*   ║║└┬┘│││├─┤│││││  └─┐   ║ ├─┤├┴┐│  ├┤ 
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘   ╩ ┴ ┴└─┘┴─┘└─┘
* Función utilizada para cargar la tabla de Dynamics.
* Parametros: 
* elementID - El ID del div donde se empotrara el Spinner.
* loaderText - Texto descriptivo que se mostrara con el loader.
*/
(function ($) {
    $.fn.dynamicTable = function (options) {
        var id = this.selector;
        var settings = $.extend({
            // These are the defaults.
            emptyText: "No se obtubieron resultados"
        }, options);

        $("body").dynamicSpinner({
            loadingText: "Cargando datos..."
        });

        //Se agregan los botonoes a la lista
        var html = "<div class='col-lg-12'    style='padding-bottom: 25px;' ><div class='btn-group' role='group'>";
        $(settings.data.iconosGrid).each(function (key, value) {
            html += " <button type='button' class='btn btn-info icon-grid' onclick='" + String(value["callback"]) + "($(this))' ";
            if (!value["enabled"])
                html += " disabled "
            html += " data-toggle='tooltip' data-placement='bottom' title='" + value["tooltip"] + "' ";
            html += " accion= '" + value["accion"] + "' " + "defaultEnabled=" + value["enabled"];
            //html += "><i class='fa fa-" + value["icono"] + "'></i></button>"
            html += "><span class='glyphicon glyphicon-" + value["icono"] + " 'aria-hidden='true'></span></button>";
        });
        html += "</div></div>"
        //Se crean los encabezados de la tabla
        html += "<table id='" + id.substring(1) + "Table' class='table table-striped table-hover table-condensed' border ='1'><thead><tr>";
        $(settings.data.encabezados).each(function (key, value) {
            html += "<th>" + value + "</th>";
        });
        html += "</tr></thead><tbody>";
        //Se crean las columnas de la tabbla
        $(settings.data.datos).each(function (key, value) {
            html += "<tr value='" + value[settings.data.columnaID] + "'>";
            $(settings.data.columnas).each(function (key2, value2) {
                html += '<td>' + value[value2] + '</td>';
            });
            html += "</tr>";
        });
        html += "</tbody></table>"
        $(id).html(html);
        $($(id + "Table").selector).DataTable({
            "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
            "bSort": false,
            "oLanguage": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No existen registros para mostrar",
                "sEmptyTable": "No existen registros para mostrar",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
        $(id + " tbody").on('click', 'tr', function () {
            $("tbody tr").removeClass("rowActive");
            $(this).addClass("rowActive");
            if ($(".rowActive").attr('value') != undefined) {
                $("button").removeAttr("disabled");
                var html = '';
                if (settings.data.datos[0].acciones != null) {
                    var selected = jQuery.grep(settings.data.datos, function (obj) {
                        return obj[settings.data.columnaID] == $(".rowActive").attr('value');
                    });
                    $(selected[0].acciones).each(function (key, value) {
                        html += " <button type='button' class='btn btn-info icon-grid' onclick='" + String(value["callback"]) + "($(this))' ";
                        if (!value["enabled"])
                            html += " disabled "
                        html += " data-toggle='tooltip' data-placement='bottom' title='" + value["tooltip"] + "' ";
                        html += " accion= '" + value["accion"] + "' " + "defaultEnabled=" + value["enabled"];
                        html += "><span class='glyphicon glyphicon-" + value["icono"] + "' aria-hidden='true'></span></button>";
                        //html += "><i class='fa fa-" + value["icono"] + "'></i></button>"
                    });
                    $(this).parent().parent().parent().parent().find('.btn-group').html(html);
                }
            }
            $('[data-toggle="tooltip"]').tooltip();
        });

        //se comenta debido a que esta afectando la carga de a pantalla
        //$('[data-toggle="tooltip"]').tooltip();

        $(id).on('page.dt', function () {
            $($("button")).each(function (key, value) {
                if (!$(value).attr("defaultEnabled"))
                    $("button").attr("disabled", "disabled");
            });
            $("tbody tr").removeClass("rowActive");

        });

        $("body").dynamicSpinnerDestroy({});
    };
}(jQuery));
//#endregion

//#region Dynamic Calendar
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔═╗┌─┐┬  ┌─┐┌┐┌┌┬┐┌─┐┬─┐
*   ║║└┬┘│││├─┤│││││  └─┐  ║  ├─┤│  ├┤ │││ ││├─┤├┬┘
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ╚═╝┴ ┴┴─┘└─┘┘└┘─┴┘┴ ┴┴└─
* Función utilizada para cargar los calendarios de Dynamics.
* Parametros: 
* elementID - El ID del div donde se empotrara el Spinner.
* loaderText - Texto descriptivo que se mostrara con el loader.
*/
(function ($) {
    $.fn.dynamicCalendar = function (options) {
        var id = this.selector;
        var settings = $.extend({
            // These are the defaults.
            textoCalendario: "Seleccionar una Fecha",
            minDate: true,
            maxDate: true,
            onSelect: true
        }, options);
        $(id).datepicker({
            //showOn: "button",
            //buttonImage: "../Image/calendar.png",
            //buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            showAnim: "slideDown",
            //buttonText: settings.textoCalendario
        });
        if (settings.maxDate != true) {
            $(id).datepicker("option", "maxDate", settings.maxDate);
        }
        if (settings.minDate != true) {
            $(id).datepicker("option", "minDate", settings.minDate);
        }
        if (settings.onSelect != true) {
            $(id).datepicker("option", "onSelect", settings.onSelect);
        }
        /* Inicialización en español para la extensión 'UI date picker' para jQuery. */
        /* Traducido por Vester (xvester@gmail.com). */
        (function (factory) {
            if (typeof define === "function" && define.amd) {

                // AMD. Register as an anonymous module.
                define(["../datepicker"], factory);
            } else {

                // Browser globals
                factory(jQuery.datepicker);
            }
        }(function (datepicker) {

            datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '&#x3C;Ant',
                nextText: 'Sig&#x3E;',
                currentText: 'Hoy',
                monthNames: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
                monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                dayNames: ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
                dayNamesShort: ['dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb'],
                dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            datepicker.setDefaults(datepicker.regional['es']);

            return datepicker.regional['es'];

        }));
    };
}(jQuery));
//#endregion

//#region Dynamic Lock
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╦  ┌─┐┌─┐┬┌─
*   ║║└┬┘│││├─┤│││││  └─┐  ║  │ ││  ├┴┐
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ╩═╝└─┘└─┘┴ ┴
* Función utilizada para bloquear todos los elementos de un Form Seleccionado.
*/
(function ($) {
    $.fn.dynamicLock = function (options) {
        //Deshabilita Inputs 
        var id = this.selector;
        $('input, select, button, textarea ', id).each(function (key, value) {
            var elemento = this;
            $(this).attr("disabled", "disabled");
            $(this).datepicker('disable');
            $(this).trigger("chosen:updated");
        });
    };
    $.fn.dynamicLockDestroy = function (options) {
        //Deshabilita Inputs 
        var id = this.selector;
        $('input, select, button ', id).each(function (key, value) {
            var elemento = this;
            $(this).prop("disabled", false);
            $(this).datepicker("option", "disabled", false);
            $(this).trigger("chosen:updated");
        });
    };
}(jQuery));
//#endregion*

//#region Dynamic Modal
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔╦╗┌─┐┌┬┐┌─┐┬  
*   ║║└┬┘│││├─┤│││││  └─┐  ║║║│ │ ││├─┤│  
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ╩ ╩└─┘─┴┘┴ ┴┴─┘
* Función utilizada para cargar el modal Dynamic.
* Parametros: 
* elementID - El ID del div donde se empotrara el Spinner.
* loaderText - Texto descriptivo que se mostrara con el loader.
*/
(function ($) {
    $.fn.dynamicModal = function (options) {
        var id = this.selector;
        var settings = $.extend({
            // These are the defaults.
            titulo: "Seleccionar:"
        }, options);
        //Se agregan los botonoes a la lista
        var html = "<!-- Modal --><div class='modal fade' id='" + id.substring(1) + "Modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' data-backdrop='static' data-keyboard='false' aria-hidden='true'>";
        html += "<div class='modal-dialog modal-lg' style='position:static; width:70%;'><div class='modal-content'><div class='modal-header'>";
        html += "<h4 class='modal-title'>" + settings.titulo + "</h4></div></div></div></div>";
        $(id).html(html);
        $.ajax({
            url: settings.url,
            type: 'POST',
            data: settings.data,
            //Mostrar Dynamic Loader
            beforeSend: function () {
                $("body").dynamicSpinner({
                    loadingText: "Cargando..."
                });
            },
            error: function (request, error) {
                $("body").dynamicSpinnerDestroy({});
                MostrarMensaje("¡Ocurrió un error al cargar la información, por favor intente más tarde!");
                $(id + "Modal").modal('hide');
            },
            success: function (result) {
                //Remover Dynamic Loader
                $("body").dynamicSpinnerDestroy({});
                $(id + "Modal .modal-content").append(result);
            }
        });
        $(id + "Modal").modal('show');
        //$(".navMap").detach().appendTo(".modal-header");
    };
}(jQuery));
//#endregion

//#region jQuery Masked Input Plugin (digitalbush.com)
/**
*  ╔╦╗┌─┐┌─┐┬┌─┌─┐┌┬┐  ╦┌┐┌┌─┐┬ ┬┌┬┐
*  ║║║├─┤└─┐├┴┐├┤  ││  ║│││├─┘│ │ │ 
*  ╩ ╩┴ ┴└─┘┴ ┴└─┘─┴┘  ╩┘└┘┴  └─┘ ┴ 
/*
    jQuery Masked Input Plugin
    Copyright (c) 2007 - 2014 Josh Bush (digitalbush.com)
    Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
    Version: 1.4.0
*/
!function (factory) {
    "function" == typeof define && define.amd ? define(["jquery"], factory) : factory("object" == typeof exports ? require("jquery") : jQuery);
}(function ($) {
    var caretTimeoutId, ua = navigator.userAgent, iPhone = /iphone/i.test(ua), chrome = /chrome/i.test(ua), android = /android/i.test(ua);
    $.mask = {
        definitions: {
            "9": "[0-9]",
            a: "[A-Za-z]",
            "*": "[A-Za-z0-9]"
        },
        autoclear: !0,
        dataName: "rawMaskFn",
        placeholder: "_"
    }, $.fn.extend({
        caret: function (begin, end) {
            var range;
            if (0 !== this.length && !this.is(":hidden")) return "number" == typeof begin ? (end = "number" == typeof end ? end : begin,
            this.each(function () {
                this.setSelectionRange ? this.setSelectionRange(begin, end) : this.createTextRange && (range = this.createTextRange(),
                range.collapse(!0), range.moveEnd("character", end), range.moveStart("character", begin),
                range.select());
            })) : (this[0].setSelectionRange ? (begin = this[0].selectionStart, end = this[0].selectionEnd) : document.selection && document.selection.createRange && (range = document.selection.createRange(),
            begin = 0 - range.duplicate().moveStart("character", -1e5), end = begin + range.text.length),
            {
                begin: begin,
                end: end
            });
        },
        unmask: function () {
            return this.trigger("unmask");
        },
        mask: function (mask, settings) {
            var input, defs, tests, partialPosition, firstNonMaskPos, lastRequiredNonMaskPos, len, oldVal;
            if (!mask && this.length > 0) {
                input = $(this[0]);
                var fn = input.data($.mask.dataName);
                return fn ? fn() : void 0;
            }
            return settings = $.extend({
                autoclear: $.mask.autoclear,
                placeholder: $.mask.placeholder,
                completed: null
            }, settings), defs = $.mask.definitions, tests = [], partialPosition = len = mask.length,
            firstNonMaskPos = null, $.each(mask.split(""), function (i, c) {
                "?" == c ? (len--, partialPosition = i) : defs[c] ? (tests.push(new RegExp(defs[c])),
                null === firstNonMaskPos && (firstNonMaskPos = tests.length - 1), partialPosition > i && (lastRequiredNonMaskPos = tests.length - 1)) : tests.push(null);
            }), this.trigger("unmask").each(function () {
                function tryFireCompleted() {
                    if (settings.completed) {
                        for (var i = firstNonMaskPos; lastRequiredNonMaskPos >= i; i++) if (tests[i] && buffer[i] === getPlaceholder(i)) return;
                        settings.completed.call(input);
                    }
                }
                function getPlaceholder(i) {
                    return settings.placeholder.charAt(i < settings.placeholder.length ? i : 0);
                }
                function seekNext(pos) {
                    for (; ++pos < len && !tests[pos];);
                    return pos;
                }
                function seekPrev(pos) {
                    for (; --pos >= 0 && !tests[pos];);
                    return pos;
                }
                function shiftL(begin, end) {
                    var i, j;
                    if (!(0 > begin)) {
                        for (i = begin, j = seekNext(end) ; len > i; i++) if (tests[i]) {
                            if (!(len > j && tests[i].test(buffer[j]))) break;
                            buffer[i] = buffer[j], buffer[j] = getPlaceholder(j), j = seekNext(j);
                        }
                        writeBuffer(), input.caret(Math.max(firstNonMaskPos, begin));
                    }
                }
                function shiftR(pos) {
                    var i, c, j, t;
                    for (i = pos, c = getPlaceholder(pos) ; len > i; i++) if (tests[i]) {
                        if (j = seekNext(i), t = buffer[i], buffer[i] = c, !(len > j && tests[j].test(t))) break;
                        c = t;
                    }
                }
                function androidInputEvent() {
                    var curVal = input.val(), pos = input.caret();
                    if (curVal.length < oldVal.length) {
                        for (checkVal(!0) ; pos.begin > 0 && !tests[pos.begin - 1];) pos.begin--;
                        if (0 === pos.begin) for (; pos.begin < firstNonMaskPos && !tests[pos.begin];) pos.begin++;
                        input.caret(pos.begin, pos.begin);
                    } else {
                        for (checkVal(!0) ; pos.begin < len && !tests[pos.begin];) pos.begin++;
                        input.caret(pos.begin, pos.begin);
                    }
                    tryFireCompleted();
                }
                function blurEvent() {
                    checkVal(), input.val() != focusText && input.change();
                }
                function keydownEvent(e) {
                    if (!input.prop("readonly")) {
                        var pos, begin, end, k = e.which || e.keyCode;
                        oldVal = input.val(), 8 === k || 46 === k || iPhone && 127 === k ? (pos = input.caret(),
                        begin = pos.begin, end = pos.end, end - begin === 0 && (begin = 46 !== k ? seekPrev(begin) : end = seekNext(begin - 1),
                        end = 46 === k ? seekNext(end) : end), clearBuffer(begin, end), shiftL(begin, end - 1),
                        e.preventDefault()) : 13 === k ? blurEvent.call(this, e) : 27 === k && (input.val(focusText),
                        input.caret(0, checkVal()), e.preventDefault());
                    }
                }
                function keypressEvent(e) {
                    if (!input.prop("readonly")) {
                        var p, c, next, k = e.which || e.keyCode, pos = input.caret();
                        if (!(e.ctrlKey || e.altKey || e.metaKey || 32 > k) && k && 13 !== k) {
                            if (pos.end - pos.begin !== 0 && (clearBuffer(pos.begin, pos.end), shiftL(pos.begin, pos.end - 1)),
                            p = seekNext(pos.begin - 1), len > p && (c = String.fromCharCode(k), tests[p].test(c))) {
                                if (shiftR(p), buffer[p] = c, writeBuffer(), next = seekNext(p), android) {
                                    var proxy = function () {
                                        $.proxy($.fn.caret, input, next)();
                                    };
                                    setTimeout(proxy, 0);
                                } else input.caret(next);
                                pos.begin <= lastRequiredNonMaskPos && tryFireCompleted();
                            }
                            e.preventDefault();
                        }
                    }
                }
                function clearBuffer(start, end) {
                    var i;
                    for (i = start; end > i && len > i; i++) tests[i] && (buffer[i] = getPlaceholder(i));
                }
                function writeBuffer() {
                    input.val(buffer.join(""));
                }
                function checkVal(allow) {
                    var i, c, pos, test = input.val(), lastMatch = -1;
                    for (i = 0, pos = 0; len > i; i++) if (tests[i]) {
                        for (buffer[i] = getPlaceholder(i) ; pos++ < test.length;) if (c = test.charAt(pos - 1),
                        tests[i].test(c)) {
                            buffer[i] = c, lastMatch = i;
                            break;
                        }
                        if (pos > test.length) {
                            clearBuffer(i + 1, len);
                            break;
                        }
                    } else buffer[i] === test.charAt(pos) && pos++, partialPosition > i && (lastMatch = i);
                    return allow ? writeBuffer() : partialPosition > lastMatch + 1 ? settings.autoclear || buffer.join("") === defaultBuffer ? (input.val() && input.val(""),
                    clearBuffer(0, len)) : writeBuffer() : (writeBuffer(), input.val(input.val().substring(0, lastMatch + 1))),
                    partialPosition ? i : firstNonMaskPos;
                }
                var input = $(this), buffer = $.map(mask.split(""), function (c, i) {
                    return "?" != c ? defs[c] ? getPlaceholder(i) : c : void 0;
                }), defaultBuffer = buffer.join(""), focusText = input.val();
                input.data($.mask.dataName, function () {
                    return $.map(buffer, function (c, i) {
                        return tests[i] && c != getPlaceholder(i) ? c : null;
                    }).join("");
                }), input.one("unmask", function () {
                    input.off(".mask").removeData($.mask.dataName);
                }).on("focus.mask", function () {
                    if (!input.prop("readonly")) {
                        clearTimeout(caretTimeoutId);
                        var pos;
                        focusText = input.val(), pos = checkVal(), caretTimeoutId = setTimeout(function () {
                            writeBuffer(), pos == mask.replace("?", "").length ? input.caret(0, pos) : input.caret(pos);
                        }, 10);
                    }
                }).on("blur.mask", blurEvent).on("keydown.mask", keydownEvent).on("keypress.mask", keypressEvent).on("input.mask paste.mask", function () {
                    input.prop("readonly") || setTimeout(function () {
                        var pos = checkVal(!0);
                        input.caret(pos), tryFireCompleted();
                    }, 0);
                }), chrome && android && input.off("input.mask").on("input.mask", androidInputEvent),
                checkVal();
            });
        }
    });
});
//#endregion


//#region Dynamic Table
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ╔╦╗┌─┐┌┐ ┬  ┌─┐ 
*   ║║└┬┘│││├─┤│││││  └─┐   ║ ├─┤├┴┐│  ├┤   ** enrae 07/03/2016**
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘   ╩ ┴ ┴└─┘┴─┘└─┘ 
* Función utilizada para cargar la tabla de Dynamics con paginación en servidor.
* Parametros: 
* elementID - El ID del div donde se empotrara el Spinner.
* loaderText - Texto descriptivo que se mostrara con el loader.
  data - lista configuración de grid (encabezados y columnas)
  url - método y controller que se ejecutará para la obtención de los datos a mostrar
*/
(function ($) {
    $.fn.dynamicPaginationTable = function (options) {

        var id = this.selector;
        var settings = $.extend({
            // These are the defaults.
            emptyText: "No se obtubieron resultados",
            id: 1
        }, options);

        if (settings.filterText == null || settings.filterText == '' || settings.filterText == undefined) {
            settings.filterText = "Introduce el texto a buscar";
        }

        //mostrar progress
        $("body").dynamicSpinner({ loadingText: "Cargando información..." });

        //Se agregan los botonoes a la lista
        var html = "<div class='col-lg-12' style='padding-bottom: 20px;'><div class='btn-group' role='group'>";
        $(settings.data.iconosGrid).each(function (key, value) {
            html += " <button type='button' class='btn btn-info icon-grid' onclick='" + String(value["callback"]) + "($(this))' ";
            if (!value["enabled"])
                html += " disabled "
            html += " data-toggle='tooltip' data-placement='bottom' title='" + value["tooltip"] + "' ";
            html += " accion= '" + value["accion"] + "' " + "defaultEnabled=" + value["enabled"];
            html += "><span class='glyphicon glyphicon-" + value["icono"] + " 'aria-hidden='true'></span></button>";
        });

        html += "</div></div>"

        //Se crean los encabezados de la tabla
        html += "<table id='" + id.substring(1) + "Table' class='table table-striped table-hover table-condensed' border ='1'><thead><tr>";
        $(settings.data.encabezados).each(function (key, value) {
            html += "<th>" + value + "</th>";
        });

        html += "</table>"

        //Se crea arreglo para columnas
        var columns = [];
        jQuery.each(settings.data.columnas, function (i, value) {
            var obj = { data: value, name: value, autoWidth: true };
            columns.push(obj);
        });

        $(id).html(html);

        var aLengthMenu = [20, 50, 100];

        if (settings.rowLength == 5) {
            aLengthMenu = [5, 10, 20];
        }

        $($(id + "Table").selector).DataTable({
            "aLengthMenu": aLengthMenu,//[[5, 10, 20], [5, 10, 20]],
            "bSort": false,
            "processing": false, // for show processing bar
            "serverSide": true, // for process on server side
            "orderMulti": false, // for disable multi column order
            //"dom": '<"top"i>rt<"bottom"lp><"clear">', // for hide default global search box // little confusion? don't worry I explained in the tutorial website
            "oLanguage": {
                //"sProcessing": "<div style='background-color:white;' ><img src='../Image/spinner.gif' /></div>",//"Cargando información...",
                //"sProcessing": "<script type='text/javascript'>$('body').dynamicSpinner({ loadingText: 'Cargando información...' });</script>",//"Cargando información...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No existen registros para mostrar",
                "sEmptyTable": "No existen registros para mostrar",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            "ajax": {
                //URL de método y controller",
                "url": options.url,
                "type": "POST",
                "datatype": "json",
                //"data": { "value": 1234 },
                "data": settings.params,
                "beforeSend": function () {
                    //Show Dynamic Loader
                    $("body").dynamicSpinner({ loadingText: "Cargando información..." });
                },
                "error": function (xhr, error, thrown) {
                    $("body").dynamicSpinnerDestroy({});
                    var mdError = $.Zebra_Dialog("Por el momento no es posible atender su solicitud, por favor intente más tarde."
                                                  , {
                                                      'type': 'warning',
                                                      'title': 'Aviso datos',
                                                      'buttons': [{ caption: 'Cerrar', callback: function () { mdError.close(); } }
                                                      ]
                                                  });
                }
            },
            "columns": columns,// agregamos columnas dinámicamente,
            //función para mostrar mensaje antes de cargar datos
            "fnPreDrawCallback": function () {
                $("body").dynamicSpinner({
                    loadingText: "Cargando información..."
                });
            },
            //función para agregar un ID a cada ROW
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).attr("value", aData[settings.data.columnaID]);
                return nRow;
            },
            //funcion para recuperar los datos de las listas que se encuentran en pantalla y mostrar el tablero en base a reglas de negocio
            "fnDrawCallback": function (oSettings) {
                //pasamos el objeto que contiene las acciones por registro para motrar los iconos
                settings.data.datos = oSettings.json.data;

                if (window.grids != undefined && window.grids > 1) {
                    window.grids--;
                } else if (window.grids != undefined && window.grids == 1) {
                    $("body").dynamicSpinnerDestroy({});
                } else if (window.grids == undefined) {
                    $("body").dynamicSpinnerDestroy({});
                }
            },

        });

        $(id + " tbody").on('click', 'tr', function () {
            $("tbody tr").removeClass("rowActive");
            $(this).addClass("rowActive");
            if ($(".rowActive").attr('value') != undefined) {
                $("button").removeAttr("disabled");
                var html = '';
                if (settings.data.datos[0].acciones != null) {
                    var selected = jQuery.grep(settings.data.datos, function (obj) {
                        return obj[settings.data.columnaID] == $(".rowActive").attr('value');
                    });
                    $(selected[0].acciones).each(function (key, value) {
                        html += " <button type='button' class='btn btn-info icon-grid' onclick='" + String(value["callback"]) + "($(this))' ";
                        if (!value["enabled"])
                            html += " disabled "
                        html += " data-toggle='tooltip' data-placement='bottom' title='" + value["tooltip"] + "' ";
                        html += " accion= '" + value["accion"] + "' " + "defaultEnabled=" + value["enabled"];
                        html += "><span class='glyphicon glyphicon-" + value["icono"] + "' aria-hidden='true'></span></button>";
                    });
                    $(this).parent().parent().parent().parent().find('.btn-group').html(html);
                }
            }
            //aplicar tooltip
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(id).on('page.dt', function () {
            $($("button")).each(function (key, value) {
                if (!$(value).attr("defaultEnabled"))
                    $("button").attr("disabled", "disabled");
            });
            $("tbody tr").removeClass("rowActive");
        });

        //Agregamos tooltip
        $(id + " .dataTables_filter input").attr({
            'data-toggle': 'tooltip',
            'data-placement': 'top',
            'title': settings.filterText,//'Introduce el nombre, consecutivo, acuse o fecha de creación de la lista a buscar.',
            'id': id + 'Search'
        });

        //Agregamos id a caja de texto buscador
        //$(".dataTables_filter input").attr('id', id + 'Search');

        // DataTable
        var table = $(id + "Table").DataTable();

        //función solo para ejecutar búsqueda con enter
        $(id + " .dataTables_filter input")
        .unbind()
        .bind('keyup change', function (e) {
            var keys = [20, 16, 18, 17]//, 13]
            if (jQuery.inArray(e.keyCode, keys) == -1) {
                if (this.id == id + 'Search') {
                    if (this.value == "") {
                        table
                            .search(this.value)
                            .draw();
                        this.blur();
                    }

                    if (this.value != "" && e.keyCode == 13) {
                        $(id + " .dataTables_filter a").click();
                    }
                }
            }
        });

        $(id + " .dataTables_filter").append('<a class="dataTableSearch" data-toggle="tooltip" data-placement="bottom" title="Presiona el ícono para buscar" ><span style="color:Black;" class="glyphicon glyphicon-search"  ></span></a>');

        $(id + " .dataTables_filter a").click(function () {
            var filtro = $(id + " .dataTables_filter input").val();
            if (filtro == '' || filtro == null) { return; }
            table.search(filtro).draw();
        });

        $('[data-toggle="tooltip"]').tooltip();
    };
}(jQuery));
//#endregion

//#region Dynamic Alert
/**
*  ╔╦╗┬ ┬┌┐┌┌─┐┌┬┐┬┌─┐┌─┐  ┌─┐┬  ┌─┐┬─┐╔╦╗ 
*   ║║└┬┘│││├─┤│││││  └─┐  ├─┤│  ├┤ ├┬┘ ║   ** enrae 07/03/2016**
*  ═╩╝ ┴ ┘└┘┴ ┴┴ ┴┴└─┘└─┘  ┴ ┴┴─┘└─┘┴└─ ╩  
* Función utilizada para mostrar mensajes en base a guia gráfica gobmx.
* Parametros: 
* elementID - El ID del div donde se mostrará el mensaje.
* message - Mensaje a mostrar.
  type - Tipo de alerta
*/
(function ($) {
    $.fn.dynamicAlert = function (options) {
        //debugger;
        var id = this.selector;
        var settings = $.extend({
            // These are the defaults.
            titulo: "Seleccionar:"
        }, options);

        var tipoMensaje = "¡Error de registro!";
        var clase = "alert-danger ";

        switch (settings.type) {
            case "success":
                tipoMensaje = "¡Felicidades!";
                clase = "alert-success";
                break;
            case "info":
                tipoMensaje = "¡Sugerencia!";
                clase = "alert-info";
                break;
            case "warning":
                tipoMensaje = "¡Precaución!";
                clase = "alert-warning";
                break;
            case "danger":
                tipoMensaje = "¡Error de registro!";
                clase = "alert-danger";
                break;
            default:
        }

        $(id).empty();

        var html = "<div class='alert " + clase + " alert-dismissible' >"
        html += "<button type='button' id='btnClose' class='close' data-dismiss='alert'  aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
        html += "<strong>" + tipoMensaje + "</strong>";
        html += "&nbsp;&nbsp;<span id='spnMensajeTC'>" + settings.message + "</span>";
        html += "</div>";

        $(id).html(html);

        //if (settings.type != 'success') {
        //auto cerrar
        clearTimeout(timerClose);
        startTimer();
        //}
        //mover pantalla hacia parte superior
        $("html, body").animate({
            scrollTop: 100
        }, 1100);
    };
}(jQuery));
//#endregion