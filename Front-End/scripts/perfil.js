// Listener para menu central
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Collapsible.init(document.getElementById("menu-collapsible"), {});
});

// Listener para modal de "Eliminar cuenta"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("delete-modal"), {});
});

// Listener para menu slide
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Sidenav.init(document.getElementById("slide-out"), 'left');
});

$(document).ready(function () {

    $('#btnCloseSession').click(function(e){
        e.preventDefault();
        $.ajax({
            method: "get",
            url: "../Back-End/PHP/destroySession_AX.php",
            cache: false,
            beforeSend : function(){
                console.log('Started request !');
            }
        })
        .done( function( data ){
            console.log(data);
            if (data.valid) {
                $(location).attr("href", "./#");
            } else {
                // alert(data.message);
            }
        })
        .fail( function( jqXHR, textStatus, error ){
            console.log(textStatus+':'+jqXHR.status+' : '+jqXHR.statusText);
        })
        .always( function( result ){ 
            console.log('Request done !!');
            $(location).attr("href", "./index.html");
        });
    });

	$('#FormChangeEmail').validetta({
		bubblePosition: "bottom",
		bubbleGapTop: 10,
		bubbleGapLeft: -5,
		onError: function (e) {
			e.preventDefault();
			alert("ERROR");
		},
        onValid: function (e) {
            e.preventDefault(); // Deja de actuar como formulario
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/changeEmail_AX.php",
                data: $(this.form).serialize(),
                dataType : 'json',
                cache: false,
                beforeSend : function(){
                    console.log('Started request !');
                    console.log($(this.form).serialize());
                }
            })
            .done( function( data ){
                console.log(data);
                if (data.valid) {
                    $(location).attr("href", "./perfil.php");
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

	$('#FormChangePassword').validetta({
		bubblePosition: "bottom",
		bubbleGapTop: 10,
		bubbleGapLeft: -5,
		onError: function (e) {
			e.preventDefault();
			alert("ERROR");
		},
        onValid: function (e) {
            e.preventDefault(); // Deja de actuar como formulario
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/changePassword_AX.php",
                data: $(this.form).serialize(),
                dataType : 'json',
                cache: false,
                beforeSend : function(){
                    console.log('Started request !');
                }
            })
            .done( function( data ){
                console.log(data);
                if (data.valid) {
                    $(location).attr("href", "./perfil.php");
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

	$('#FormDelete').validetta({
		bubblePosition: "bottom",
		bubbleGapTop: 10,
		bubbleGapLeft: -5,
		onError: function (e) {
			e.preventDefault();
			alert("ERROR");
		},
        onValid: function (e) {
            e.preventDefault(); // Deja de actuar como formulario
            $.ajax({
                method: "post",
                url: "../Back-End/PHP/deleteUser_AX.php",
                data: $(this.form).serialize(),
                dataType : 'json',
                cache: false,
                beforeSend : function(){
                    console.log('Started request !');
                }
            })
            .done( function( data ){
                console.log(data);
                if (data.valid) {
                    $.ajax({
                        method: "get",
                        url: "../Back-End/PHP/destroySession_AX.php",
                        cache: false,
                        beforeSend : function(){
                            console.log('Started request !');
                        }
                    })
                    .done( function( data ){
                        console.log(data);
                        if (data.valid) {
                            $(location).attr("href", "./#");
                        } else {
                            // alert(data.message);
                        }
                    })
                    .fail( function( jqXHR, textStatus, error ){
                        console.log(textStatus+':'+jqXHR.status+' : '+jqXHR.statusText);
                    })
                    .always( function( result ){ 
                        console.log('Request done !!');
                        $(location).attr("href", "./index.html");
                    });
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
