$(document).ready(function() {



    var nombre = " "
    var apellido = " "




    $.ajax({
        type: "POST",
        url: "index.php?controller=empleado&action=save",
        data: {
            empnombre: nombre,
            empape: apellido,
        },
        cache: false,
        success: function(data) {
            alert(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });



});