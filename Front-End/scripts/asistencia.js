// Tabs
var instance = M.Tabs.init(document.getElementById("tabs-asistencia"), {});

// Listener para modal de "Comentarios"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("asist-modal"), {});
});

// Table browser
function searchAsist() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("browser-input");
    filter = input.value.toUpperCase();
    table = document.getElementById("asist-table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Listener para el select del modal
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});

// Agrega el rfc al modal
$('td').on("click", "a.modal-trigger", function(){
    let rfc = $(this).attr('id');
    console.log(rfc);
    $('#actual-rfc').val(rfc);
});

// Manda peticion para eliminar al dar click en icono de eliminar
$('td').on("click", "a.delete-rfc", function(){
    let rfc = $(this).attr('id');
    let payload = jQuery.parseJSON( '{ "rfc" : "' + rfc + '" }')
    console.log(payload);
    $.ajax({
                method: "post",
                url: "../Back-End/PHP/dAssistant_AX.php",
                data: payload,
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    console.log('Started request !');
                }
            })
                .done(function (data) {
                    console.log(data);
                    if (data.valid) {
                        $(location).attr("href", "asistencia.php");
                    } else {
                        alert(data.message);
                    }
                })
                .fail(function (jqXHR, textStatus, error) {
                    console.log(textStatus + ':' + jqXHR.status + ' : ' + jqXHR.statusText);
                })
                .always(function (result) {
                    console.log('Request done !!');
                });
});

// Bloque para ocultar Input y Label de Otro
$('#asist-select').change(function () {
    if ($(this).val().includes("Otro...")) {
        $('#otherInput').prop("hidden", false);
        $('#otherLabel').prop("hidden", false);
    } else {
        $('#otherInput').prop("hidden", true);
        $('#otherLabel').prop("hidden", true);
    }
});

// Peticiones rest con ajax
$(document).ready(function () {
    $('#otherInput').prop("hidden", true);
    $('#otherLabel').prop("hidden", true);

    $('#FormAssistance').validetta({
        bubblePosition: "bottom",
        bubbleGapTop: 10,
        bubbleGapLeft: -5,
        onError: function (e) {
            e.preventDefault();
            // alert("ERROR");
        },
        onValid: function (e) {
            e.preventDefault(); // Deja de actuar como formulario
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/cAssistant_AX.php",
                data: $(this.form).serialize(),
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    console.log('Started request !');
                }
            })
                .done(function (data) {
                    console.log(data);
                    if (data.valid) {
                        $(location).attr("href", "asistencia.php");
                    } else {
                        alert(data.message);
                    }
                })
                .fail(function (jqXHR, textStatus, error) {
                    console.log(textStatus + ':' + jqXHR.status + ' : ' + jqXHR.statusText);
                })
                .always(function (result) {
                    console.log('Request done !!');
                });
        }
    });

    $('#FormCommentaries').validetta({
        bubblePosition: "bottom",
        bubbleGapTop: 10,
        bubbleGapLeft: -5,
        onError: function (e) {
            e.preventDefault();
            // alert("ERROR");
        },
        onValid: function (e) {
            e.preventDefault(); // Deja de actuar como formulario
            let payload = jQuery.parseJSON( '{' + $("option:selected").map(function(){
                return '"' + this.id + '" : "' + this.value + '"'
            }).get().join(", ") + ', "rfc" : "' + $('#actual-rfc').val() + '", "otherInput" : "' + $('#otherInput').val() + '" }')
            console.log(payload);
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/uAssistant_AX.php",
                // Cambiar data para que mande el RFC
                data: payload,
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    console.log('Started request !');
                }
            })
                .done(function (data) {
                    console.log(data);
                    if (data.valid) {
                        $(location).attr("href", "asistencia.php");
                    } else {
                        alert(data.message);
                    }
                })
                .fail(function (jqXHR, textStatus, error) {
                    console.log(textStatus + ':' + jqXHR.status + ' : ' + jqXHR.statusText);
                })
                .always(function (result) {
                    console.log('Request done !!');
                });
        }
    });
});

// Listener para modal de "Asistencia por QR"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("qr-modal"), {});
});