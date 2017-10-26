var $ = require('jquery');
require('datatables.net')(window, $);
require('datatables.net-bs')(window, $);

$(function () {

    $("#listTable").DataTable({
        "processing": true,
        "scrollX": true
    });


});


