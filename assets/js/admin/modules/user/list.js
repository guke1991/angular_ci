$(document).ready( function () {
    table = $('#usersTable').on( 'init.dt', function () {
        $('.panel.panel-default, #loader-img').toggle();
    } ).DataTable( {
        "ajax": {
            "url": "/api/user/many",
            "dataSrc": null
        },
        "language": {
            "url": "/assets/library/DataTables-1.10.2/Lang/russian.lang"
        },
        "aoColumns": [
            { sWidth :'5%',data: "id"},
            {data: "first_name"},
            {data: "last_name"},
            {data: "email"},
            {data: "phone"},
            {data: "city_name"},
            {data: "role_name"},
            {
                data: null,
                render: function(data, type, row, meta){
                    return data.is_active == 1?'Активен':'Неактивен';
                }
            },
            {data: "created_date"},
            {
                bSortable: false,
                sWidth :'5%',
                data: null,
                class: "table-glyph",
                'render': function(data, type, row, meta){
                    var id = meta.row;
                    return '<a href="#" onclick="setInfoData('+id+');" data-toggle="modal" data-target="#userInfoModal">'+
                    '<span class="glyphicon glyphicon-info-sign"></span></a>';
                }
            }
        ]
    } );

} );
function setInfoData(row){
    var data = table.data()[row];
    $('#userFirstName').text(data.first_name);
    $('#userLastName').text(data.last_name);
    $('#userMiddleName').text(data.mid_name);
    $('#userEmail').text(data.email);
    $('#userPhone').text(data.phone);
    $('#userFax').text(data.fax);
    $('#userCompany').text(data.company);
    $('#userRegion').text(data.region_name);
    $('#userCity').text(data.city_name);
    $('#userAddressLine1').text(data.address_line1);
    $('#userAddressLine2').text(data.address_line2);
    $('#userRole').text(data.role_name);
    $('#userActive').text(data.is_active == 1?'Да':'Нет');
    $('#userSign').text(data.is_sign == 1?'Да':'Нет');

}