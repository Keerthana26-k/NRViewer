/**
 * Created by RU00160171 on 20.10.2017.
 */
$ = require('jquery');
_ = require('lodash');

function getColumns(callback) {
    return $.ajax({
        url: "/columns",
        type: 'GET'
    }).done(callback)
}


getColumns(function (columns) {

columns =JSON.parse(columns).map(function (item) {
    item['data']=item['COLUMN_NAME'];
    delete item['COLUMN_NAME'];
        return item;
});
console.log(columns);
    $("#start").click(function () {
        $('#example').DataTable({
            "ajax":{
                "url": "/test",
                "dataSrc":""
            },
            "columns": columns
        });
    })
});

module.exports = columns;

/*
 function (data) {
 data = JSON.parse(data);


 }*/
