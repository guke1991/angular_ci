$(document).ready( function () {
    var table = $('#manufacturersTable').on( 'init.dt', function () {
        $('.panel.panel-default, #loader-img').toggle();
    } ).DataTable( {
        "ajax": {
            "url": "/api/manufacturer/many",
            "dataSrc": null
        },
        "language": {
            "url": "/assets/library/DataTables-1.10.2/Lang/russian.lang"
        },
        "aoColumns": [
            { sWidth :'5%',data: "id"},
            {data: "name"},
            {data: "category_name"},
            {
                bSortable: false,
                sWidth :'5%',
                data: null,
                class: "table-glyph",
                'render': function(data, type, row, meta){
                    return '<a href="/admin/manufacturer/edit/'+data.id+'">' +
                                '<span class="glyphicon glyphicon-pencil"></span>&nbsp' +
                           '</a>' +
                           '<a href="/admin/manufacturer/delete/'+data.id+'">' +
                                '<span class="glyphicon glyphicon-trash"></span>' +
                           '</a>';
                }
            }
        ]
    } );
    //var tt = new $.fn.dataTable.TableTools( table,
    //    {
    //        "sSwfPath": "/assets/library/DataTables-1.10.2/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
    //        "aButtons": [
    //
    //            {
    //                "sExtends": "xls",
    //                "mColumns": [ 0, 1, 2 ]
    //            }
    //        ]
    //
    //    } );
    //$( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');
} );