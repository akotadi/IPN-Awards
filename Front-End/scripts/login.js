$(document).ready(function(){

	// Tabs
	var instance = M.Tabs.init(document.getElementById("tabs-login"), {swipeable: true});
	instance.select("swipe-login");

	$('#FormLogin').validetta({
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
				url:"../Back-End/PHP/index_AX.php",
				data:$("#FormLogin").serialize(),
				cache:false,
				success:function(resp){
					if (resp == 200) {
						$(location).attr("href", "home.html");
					}else{
						alert("Usuario y/o contraseña inválido");
					}
				}
			});
		}
	});

	$('#FormRecover').validetta({
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
				url:"../Back-End/PHP/recoveryPassword_AX.php",
				data:$("#FormRecover").serialize(),
				cache:false,
				success:function(resp){
					if (resp == 200) {
						$(location).attr("href", "login.html");
					}else{
						alert("Error con la recuperación, por favor vuelve a intentarlo");
					}
				}
			});
		}
	});
});