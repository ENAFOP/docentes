$(document).ready(function () 
{
	 $('#formRegistro').validate({
         ignore: '',
		rules: {
            nombre: 
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
	$('#usuario').change(function() {
		//console.log("cambio en usuario");
		var nomUsuario=$( "#usuario").val();
		$.ajax({
			url:"/comprobarExisteNombre.php?usuario="+nomUsuario,
			success:function(result)
			{
				   var codificar=JSON.stringify(result);
				   if(codificar.localeCompare("false")==0) //no existe en bd, ok
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
						//$("#chequecitoMalo").show();
						var x = document.getElementById("chequecitoMalo");
						if (x.style.display === "none") 
						{
							$(x).show('fast');
						}
						
				   }
			}
		}); //fin del ajax
	});
	
	var validator = $("#formRegistro").validate();
	
});