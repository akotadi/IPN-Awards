// Tabla de busqueda en invitados
$(document).ready(function () {
    $('#tabla-invitados tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });
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

function selectAll(){
    if($('tbody').has('tr.selected')){
        $('tbody').children('tr.selected').removeClass('selected');
        $('tbody').children('tr').addClass('selected');
    } else {
        $('tbody').children('tr').addClass('selected');
    }
}