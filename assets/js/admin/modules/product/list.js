$(document).ready( function () {
    var table = $('#productsTable').on( 'init.dt', function () {
        $('.panel.panel-default, #loader-img').toggle();
    } ).DataTable( {
        "ajax": {
            "url": "/api/product/many",
            "dataSrc": null
        },
        "language": {
            "url": "/assets/library/DataTables-1.10.2/Lang/russian.lang"
        },
        "aoColumns": [
            { sWidth :'5%',data: "id"},
            {
                data: null,
                render: function(data, type, row, meta){
                    return '<a data-toggle="lightbox" href="/assets/uploads/product/'+data.image+'" class="img-responsive"> <img src="/assets/uploads/product/thumbs/'+data.image+'" class="img-thumbnail"> </a>';
                }
            },
            {data: "title"},
            {data: "model"},
            {data: "price"},
            {data: "amount"},
            {data: "manufacturer_name"},
            {data: "created_date"},
            {
                bSortable: false,
                sWidth :'5%',
                data: null,
                class: "table-glyph",
                'render': function(data, type, row, meta){
                    return '<a href="/admin/product/edit/'+ data.id +'">' +
                                ' <span class="glyphicon glyphicon-pencil"></span>' +
                            '</a>&nbsp' +
                            '<a href="/admin/product/delete/'+data.id+'">' +
                                ' <span class="glyphicon glyphicon-trash"></span> ' +
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
    //                "mColumns": [ 0, 2, 3, 4, 5, 6, 7, 8 ]
    //            }
    //        ]
    //
    //    } );
    //$( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');

    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

} );