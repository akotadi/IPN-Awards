// Listener para modal de "Comentarios"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("add-modal"), {});
});

// Listener para el select del modal
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});

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

$('td').on("click", "a.delete", function () {
    let user = $(this).attr('id');
    let payload = jQuery.parseJSON('{ "user" : "' + user.substr(0,10) + '" }')
    console.log(payload);
    debugger;
    $.ajax({
        method: "post",
        url: "../Back-End/PHP/dUser_AX.php",
        data: payload,
        dataType: 'json',
        cache: false,
        beforeSend: function () {
            console.log('Started request !');
        }
    })
        .done(function (data) {
            console.log(data);
            debugger;
            if (data.valid) {
                $(location).attr("href", "./usuarios.php");
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
            const user = $("#user").val();
            const email = $("#email").val();
            const password = $("#password").val();
            const procedency = $('#procedency-select').find('option:selected').val();
            const data = {
                user: user,
                email: email,
                password: password,
                procedency: procedency
            };
            console.log(user);
            console.log(password);
            console.log(email);
            console.log(procedency);
            console.log(JSON.stringify(data));
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/cUser_AX.php",
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
                        $(location).attr("href", "./usuarios.php");
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