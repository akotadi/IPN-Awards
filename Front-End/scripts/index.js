// Listener para menu slide
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Sidenav.init(document.getElementById("slide-out"), 'left');
});

// Listener para modal de "Consultar qr"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("qr-modal"), {});
});

$(document).ready(function () {

	$('#FormQR').validetta({
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
				url: "../Back-End/PHP/consultRFC_AX.php",
				data: $(this.form).serialize(),
				dataType : 'json',
				cache: false,
				beforeSend : function(){
					console.log('Started request !');
				}
			})
			.done( function( data ){
				// console.log(data);
				if (data.valid) {
					create();
				} else {
					alert(data.message);
				}
            })
            .fail( function( jqXHR, textStatus, error ){
                console.log(textStatus+':'+jqXHR.status+' : '+jqXHR.statusText);
            })
            .always( function( result ){ console.log('Request done !!');
			});
        }
	});
});
