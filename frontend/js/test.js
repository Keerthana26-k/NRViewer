/**
 * Created by RU00160171 on 21.10.2017.
 */
$ = require('jquery');
let columns;

 columns= $.ajax({
    url: "/columns",
    type: 'GET',

}).done(function (data) {
     data = JSON.parse(data);

     $.each(data, function(i,v){
          data = v['COLUMN_NAME'];
         $('body').append(data);
     });

});


module.exports = columns;