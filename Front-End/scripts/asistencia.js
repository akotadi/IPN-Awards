// Tabs
var instance = M.Tabs.init(document.getElementById("tabs-asistencia"), {});

// Listener para modal de "Eliminar cuenta"
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
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});

// Bloque para ocultar Input y Label de Otro
$('#asist-select').change(function() {
    if( $(this).val().includes("otro")) {
        $('#otherInput').prop( "hidden", false );
        $('#otherLabel').prop( "hidden", false );
    } else {
        $('#otherInput').prop( "hidden", true );
        $('#otherLabel').prop( "hidden", true );
    }
});

$(document).ready(function () {
    $('#otherInput').prop("hidden", true);
    $('#otherLabel').prop("hidden", true);

    $('#FormAssistance').validetta({
        bubblePosition: "bottom",
        bubbleGapTop: 10,
        bubbleGapLeft: -5,
        onError:function(e){
            e.preventDefault();
            // alert("ERROR");
        },
        onValid:function(e){
            e.preventDefault(); // Deja de actuar como formulario
            $.ajax({
                method:"post",
                url:"../Back-End/PHP/cAssistant_AX.php",
                data:$("#FormAssistance").serialize(),
                cache:false,
                success:function(resp){
                    if (resp == 200) {
                        $(location).attr("href", "asistencia.html");
                    }else{
                        alert("Hubo un problema, inténtelo de nuevo.");
                    }
                    alert(resp);
                }
            });
        }
    });

    $('#FormCommentaries').validetta({
        bubblePosition: "bottom",
        bubbleGapTop: 10,
        bubbleGapLeft: -5,
        onError:function(e){
            e.preventDefault();
            // alert("ERROR");
        },
        onValid:function(e){
            e.preventDefault(); // Deja de actuar como formulario
            $.ajax({
                method:"post",
                url:"../Back-End/PHP/uAssistant_AX.php",
                data:$("#FormCommentaries").serialize(),
                cache:false,
                success:function(resp){
                    if (resp == 200) {
                        // $(location).attr("href", "home.html");
                    }else{
                        alert("Hubo un problema, inténtelo de nuevo.");
                    }
                }
            });
        }
    });
});

// Listener para modal de "Asistencia por QR"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("qr-modal"), {});
});

