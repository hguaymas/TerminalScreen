/* Set the defaults for DataTables initialisation */
//$.extend( true, $.fn.dataTable.defaults, {
//	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'p i>>",
//	"sPaginationType": "bootstrap",
//	"oLanguage": {
//		"sLengthMenu": "_MENU_"
//	}
//} );


/* Default class modification */
$.extend($.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
});


/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
{
    return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": oSettings._iDisplayLength === -1 ?
                0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": oSettings._iDisplayLength === -1 ?
                0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    };
};


/* Bootstrap style pagination control */
$.extend($.fn.dataTableExt.oPagination, {
    "bootstrap": {
        "fnInit": function(oSettings, nPaging, fnDraw) {
            var oLang = oSettings.oLanguage.oPaginate;
            var fnClickHandler = function(e) {
                e.preventDefault();
                if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                    fnDraw(oSettings);
                }
            };

            $(nPaging).addClass('pagination').append(
                    '<ul>' +
                    '<li class="first disabled tip" data-toggle="tooltip" title="Primera"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>' +
                    '<li class="prev disabled tip" data-toggle="tooltip" title="Anterior"><a href="#"><i class="fa fa-angle-left"></i></a></li>' +
                    '<li class="next disabled tip" data-toggle="tooltip" title="Siguiente"><a href="#"><i class="fa fa-angle-right"></i></a></li>' +
                    '<li class="last disabled tip" data-toggle="tooltip" title="Última"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>' +
                    '</ul>'
                    );
            var els = $('a', nPaging);
            $(els[0]).bind('click.DT', {action: "first"}, fnClickHandler);
            $(els[1]).bind('click.DT', {action: "previous"}, fnClickHandler);
            $(els[2]).bind('click.DT', {action: "next"}, fnClickHandler);
            $(els[3]).bind('click.DT', {action: "last"}, fnClickHandler);
        },
        "fnUpdate": function(oSettings, fnDraw) {
            var iListLength = 5;
            var oPaging = oSettings.oInstance.fnPagingInfo();
            var an = oSettings.aanFeatures.p;
            var i, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

            if (oPaging.iTotalPages < iListLength) {
                iStart = 1;
                iEnd = oPaging.iTotalPages;
            } else if (oPaging.iPage <= iHalf) {
                iStart = 1;
                iEnd = iListLength;
            } else if (oPaging.iPage >= oPaging.iTotalPages - iHalf) {
                iStart = oPaging.iTotalPages - iListLength + 1;
                iEnd = oPaging.iTotalPages;
            } else {
                iStart = oPaging.iPage - iHalf + 1;
                iEnd = iStart + iListLength - 1;
            }

            for (i = 0, iLen = an.length; i < iLen; i++) {
                // Remove the middle elements
                $('li:gt(1)', an[i]).filter(':not(.next,.last)').remove();

                // Add the new list items and their event handlers
                for (j = iStart; j <= iEnd; j++) {
                    sClass = j == oPaging.iPage + 1 ? 'class="active"' : "";
                    $("<li " + sClass + '><a href="#">' + j + "</a></li>").insertBefore($(".next,.last", an[i])[0]).bind("click", function(a) {
                        a.preventDefault();
                        oSettings._iDisplayStart = (parseInt($("a", this).text(), 10) - 1) * oPaging.iLength;
                        fnDraw(oSettings)
                    })
                }

                // Add / remove disabled classes from the static elements
                if (oPaging.iPage === 0)
                    $(".first,.prev", an[i]).addClass("disabled");
                else
                    $(".first,.prev", an[i]).removeClass("disabled")

                if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0)
                    $(".next,.last", an[i]).addClass("disabled");
                else
                    $(".next,.last", an[i]).removeClass("disabled")
            }
            $('.tip').tooltip();
        }
    }
});


/*
 * TableTools Bootstrap compatibility
 * Required TableTools 2.1+
 */

// Set the classes that TableTools uses to something suitable for Bootstrap
$.extend(true, $.fn.DataTable.TableTools.classes, {
    "container": "DTTT ",
    "buttons": {
        "normal": "btn btn-white",
        "disabled": "disabled"
    },
    "collection": {
        "container": "DTTT_dropdown dropdown-menu",
        "buttons": {
            "normal": "",
            "disabled": "disabled"
        }
    },
    "print": {
        "info": "DTTT_print_info modal"
    },
    "select": {
        "row": "active"
    }
});

// Have the collection use a bootstrap compatible dropdown
$.extend(true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
    "collection": {
        "container": "ul",
        "button": "li",
        "liner": "a"
    }
});
var asInitVals = new Array();
$(document).ready(function() {

    var responsiveHelper = undefined;
    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };

    var tableElement = $('.datatable_general');
    var oTable = tableElement.dataTable({
        "sPaginationType": "bootstrap",
        "sDom": "<'row'<'col-md-6'l <'toolbar'>><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
        bAutoWidth: false,
        /*"aoColumnDefs": [{ 
         'bSortable': false, 'aTargets': [ 0 ] 
         }],*/
        "aaSorting": [[0, "asc"]],
        //"sDom": "<'row separator bottom'<'col-md-9'l><'col-md-3'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "No se encontraron coincidencias",
            "sEmptyTable": "No hay datos disponibles",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Primero",
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
                "sLast": "Último"
            }
        },
        fnPreDrawCallback: function() {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper) {
                responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
            }
        },
        fnRowCallback: function(nRow) {
            responsiveHelper.createExpandIcon(nRow);
        },
        fnDrawCallback: function(oSettings) {
            responsiveHelper.respond();
        }
//        "fnInitComplete": function() {
//            fnInitCompleteCallback(this);
//        }
    });
    var tableElement2 = $('.datatable_general_editable');
    var oTable2 = tableElement2.dataTable({
        "sPaginationType": "bootstrap",
        "sDom": "<'row'<'col-md-6'l <'toolbar'>><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
        bAutoWidth: false,
        /*"aoColumnDefs": [{ 
         'bSortable': false, 'aTargets': [ 0 ] 
         }],*/
        "aaSorting": [[0, "asc"]],
        //"sDom": "<'row separator bottom'<'col-md-9'l><'col-md-3'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "No se encontraron coincidencias",
            "sEmptyTable": "No hay datos disponibles",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Primero",
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
                "sLast": "Último"
            }
        },
        fnPreDrawCallback: function() {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper) {
                responsiveHelper = new ResponsiveDatatablesHelper(tableElement2, breakpointDefinition);
            }
        },
        fnRowCallback: function(nRow) {
            responsiveHelper.createExpandIcon(nRow);                        
        },
        fnDrawCallback: function(oSettings) {
            responsiveHelper.respond();            
            makeEditables();
        }
//        "fnInitComplete": function() {
//            fnInitCompleteCallback(this);
//        }
    });
    $("div.toolbar").html('<div class="table-tools-actions"><button class="btn btn-primary" style="margin-left:12px" id="nuevo_registro">Nuevo</button></div>');

    //oTable.columnFilter({"sPlaceHolder": 'head:after'});
    $('.dataTables_filter input').addClass("input-medium "); // modify table search input
    $('.dataTables_length select').addClass("select2-wrapper span12"); // modify table per page dropdown
    $(".select2-wrapper").select2({minimumResultsForSearch: -1});        
    //makeEditables();
});   