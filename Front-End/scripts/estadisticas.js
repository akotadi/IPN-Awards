document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("stats-modal"), {});
});
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("stats-modal2"), {});
});
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("stats-modal3"), {});
});

$(document).ready(function () {
	// $('#btnReporte').click(function(e){
 //        e.preventDefault();
 //        $.ajax({
 //            method: "get",
 //            url: "../Back-End/PHP/createSpeech.php",
 //            cache: false,
 //            beforeSend : function(){
 //                console.log('Started request !');
 //            }
 //        })
 //        .done( function( data ){
 //            console.log(data);
 //            debugger;
 //            if (data.valid) {
 //                $(location).attr("href", "./#");
 //            } else {
 //                // alert(data.message);
 //            }
 //        })
 //        .fail( function( jqXHR, textStatus, error ){
 //            console.log(textStatus+':'+jqXHR.status+' : '+jqXHR.statusText);
 //        })
 //        .always( function( result ){ 
 //            console.log('Request done !!');
 //        });
 //    });
});
