// Listener para modal de "Comentarios"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("asist-modal"), {});
});
// Listener para modal de "Comentarios"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("aviso-modal"), {});
});
// Listener para modal de "Comentarios"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("add-modal"), {});
});
// Listener para el select del modal
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
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

// Tabla: selects
$(document).ready(function () {
    $('#tabla-invitados tbody').on('click', 'td.name', function () {
        if ($(this).parent('tr').attr('class') == 'selected') {
            $(this).parent('tr').attr('class', 'not-selected');
        } else {
            $(this).parent('tr').attr('class', 'selected');
        }
    });
});

function selectAll(e) {
    if ($('tbody').has('tr.not-selected')[0] != undefined) {
        $('tbody').children('tr.not-selected').removeClass('not-selected');
        $('tbody').children('tr').addClass('selected');
    } else {
        $('tbody').children('tr.selected').removeClass('selected');
        $('tbody').children('tr').addClass('not-selected');
    }
}

// Table browser
function searchAsist() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("browser-input");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabla-invitados");
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

// Agrega el rfc al modal
$('td').on("click", "a.modal-trigger", function () {
    let rfc = $(this).attr('id');
    console.log(rfc);
    $('#actual-rfc').val(rfc);
});

// Manda peticion para eliminar al dar click en icono de eliminar
$('td').on("click", "a.delete-rfc", function () {
    let rfc = $(this).attr('id');
    let payload = jQuery.parseJSON('{ "rfc" : "' + rfc + '" }')
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

// Peticiones rest con ajax
$(document).ready(function () {
    $('#otherInput').prop("hidden", true);
    $('#otherLabel').prop("hidden", true);

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
            let payload = jQuery.parseJSON('{' + $("option:selected").map(function () {
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

    $('#FormAdd').validetta({
        bubblePosition: "bottom",
        bubbleGapTop: 10,
        bubbleGapLeft: -5,
        onError: function (e) {
            e.preventDefault();
            // alert("ERROR");
        },
        onValid: function (e) {
            e.preventDefault(); // Deja de actuar como formulario
            const rfc = $("#rfc").val();
            const name = $("#name").val();
            const first_surname = $("#first_surname").val();
            const second_surname = $("#second_surname").val();
            const email = $("#email").val();
            const procedency = $('#procedency-select').find('option:selected').val();
            const award = $('#award-select').find('option:selected').val();
            const data = {
                rfc: rfc,
                name: name,
                first_surname: first_surname,
                second_surname: second_surname,
                email: email,
                procedency: procedency,
                award: award
            };
            console.log(rfc);
            console.log(name);
            console.log(first_surname);
            console.log(second_surname);
            console.log(email);
            console.log(procedency);
            console.log(award);
            console.log(data);
            console.log(JSON.stringify(data));
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/cAwarded_AX.php",
                data: data,
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

// Bloque para editor de aviso
// sendNews.php
$('#btnSendEmail').click(function (e) {
    e.preventDefault();
    const html = $('#text').froalaEditor('html.get');
    const subject = $("#asunto").val();
    const rfcs = [];
    $(document).find('tr.selected').each(function () { rfcs.push(this.id); });
    const data = {
        subject: subject,
        text: html,
        rfclist: rfcs
    };
    console.log(subject);
    console.log(html);
    console.log(rfcs);
    console.log(data);
    console.log(JSON.stringify(data));
    $.ajax({
        method: "post",
        url: "../Back-End/PHP/sendNews.php",
        data: data,
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

$('#text').froalaEditor({
    toolbarButtons: ['bold', 'italic', 'underline', '|', 'fontFamily', 'fontSize', 'color', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', '|', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertTable', 'insertHR', '|', 'specialCharacters', '|', 'selectAll', 'clearFormatting', '|', 'print', '|', 'undo', 'redo'],
    toolbarButtonsXS: ['bold', 'italic', 'underline', '-', 'fontFamily', 'fontSize', 'color', 'paragraphStyle', '-', 'paragraphFormat', 'align', 'formatOL', 'formatUL', '-', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertTable', 'insertHR', '|', 'specialCharacters', '-', 'selectAll', 'clearFormatting', '|', 'print', '-', 'undo', 'redo']
});

// Bloque para enviar invitacion
// sendInvitation.php
$('#btnInvitacion').click(function () {
    const rfcs = [];
    $(document).find('tr.selected').each(function () { rfcs.push(this.id); });
    const data = {
        rfclist: rfcs
    };
    console.log(rfcs);
    console.log(data);
    console.log(JSON.stringify(data));
    $.ajax({
        method: "post",
        url: "../Back-End/PHP/sendInvitation.php",
        data: data,
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