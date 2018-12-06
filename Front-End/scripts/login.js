$(document).ready(function () {

	// Tabs
	var instance = M.Tabs.init(document.getElementById("tabs-login"), { swipeable: true });
	instance.select("swipe-login");

	$('#FormLogin').validetta({
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
				url: "../Back-End/PHP/index_AX.php",
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
					$(location).attr("href", "./home.php");
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

	$('#FormRecover').validetta({
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
				url: "../Back-End/PHP/recoveryPassword_AX.php",
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
					$(location).attr("href", "index.html");
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
