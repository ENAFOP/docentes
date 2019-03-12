$(document).ready(function () 
{
	 $('#formRegistro').validate({
         ignore: '',
		rules: {
            nombre: 
			{
                required: true
            },
            nit: 
			{
                required: true
            },
			usuario: 
			{
                required: true
            },
            correo: 
			{
                required: true,
				email: true

            },
			 password: 
			{
                required: true,
				minlength: 7
				
            },
			password2: 
			{
                equalTo: "#password"
				
            }
			
        },
		messages: 
		{
		  nombre: "Debe ingresar su nombre completo",
		  nit: "Debe ingresar su NIT completo y correcto",
		  usuario: "Debe ingresar  un nombre de usuario",
		  correo: "Debe ingresar su correo electrónico",
		  password: "Ingrese un password de al menos 7 caracteres de longitud",
		  password2: "El password ingresado no coincide con el que ingresó anteriormente"	
		},
        submitHandler: function (form) { // for demo
            //alert('Formulario llenado correctamente. Ahora será registrado.');
            //var $form = $(form);
            //$form.submit();
			 form.submit();
        }
    });
	$('#nit').change(function() {
		//console.log("cambio en usuario");

		var nit=$("#nit").val();

		//console.log("el nit completo es; "+nomUsuario);
		//1: comprobar si el nit está escrito correctamente:
		var re = new RegExp("^([0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1})$");
		var estabien=0; //0 es false, 1 es ok que esta en formato NIT
		if (re.test(nit)) 
		{
		    estabien=1;
		}

		    if(estabien==0)
			{
				document.getElementById('nit').style.borderColor = "red";
				alert("NIT escrito incorrectamente!");
				document.getElementById('nit').value = "";
				//si esta mal escrito quito lo del NIT no existe n la base
				var x = document.getElementById("chequecito");
				$(x).hide('fast');
			} 

			else
			{
						$.ajax({
					url:"../comprobarExisteNombre.php?usuario="+nit,
					success:function(result)
					{
						   var codificar=JSON.stringify(result);
						   document.getElementById('nit').style.borderColor = "green";
						   if(codificar.localeCompare("false")==0 ) //no existe en bd, ok
						   {
								//console.log("Usuario no existe en la bd y está libre");
								//document.getElementById("divNomUsuario").classList.remove("has-feedback");
								//document.getElementById("divNomUsuario").classList.add("has-success");
								$("#divNomUsuario").removeClass("has-error");
								$("#divNomUsuario").addClass("has-success");
								var x = document.getElementById("chequecito");
								if (x.style.display === "none") 
								{
									$(x).show('fast');
								} 	
								var malo=document.getElementById("chequecitoMalo");
								malo.style.display = "none";
						   }
						   else //existe en la bd, alerto del error
						   {
							   var bueno=document.getElementById("chequecito");
							   bueno.style.display = "none";
							   $("#divNomUsuario").removeClass("has-success");
							   	$("#divNomUsuario").addClass("has-error");
							   	document.getElementById('nit').style.borderColor = "red";
								//$("#chequecitoMalo").show();
								var x = document.getElementById("chequecitoMalo");
								if (x.style.display === "none") 
								{
									$(x).show('fast');
								}
								
						   }
					}
				}); //fin del ajax
			} //fin del else si NIT esta bien escrito

		//2: ver si ya está registrado
		
	});
	
	var validator = $("#formRegistro").validate();
	
});