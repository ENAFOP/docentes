/***
----------------------------------------------------------------- VARIABLES GLOBALES------------------------------------------------------
**/
var masDeUnaExperiencia=false; //se pone a true si en la parte 2 del formulario, añde con el botón una o más entradas, sirve para validar esas nuevas entradas



/***
----------------------------------------------------------------- FUNCIONES------------------------------------------------------
**/
//76
$('#paisResidencia').change(function() 
{
	var pais=$("#paisResidencia").val();
       var x = document.getElementById("divDepartamentos");
		var y = document.getElementById("divMunicipios");	
		if(pais.localeCompare("El Salvador")==0)
		{
			if (x.style.display === "none") 
			{
				$(x).show('slow');
			}				
		}
		else
			{
				
				$(x).hide('slow');
				$('#departamento').val('');
				$(y).hide('slow');
				$('#municipio').val('');
				console.log("despues mubi: "+$('#municipio').val());
			}
    });
	
$('#departamento').change(function() 
{
	console.log("cambio en departamento");
	var depar=$("#departamento").val();
	$.ajax({
                        url:"../response.php?departamento="+depar,
                        success:function(result)
                        {
                               var codificar=JSON.stringify(result);
							   //alert('codificar '+codificar);
                              //var parsear = JSON.parse(codificar); 
                               document.getElementById('municipio').innerHTML = codificar;                             
							   var munis = document.getElementById("divMunicipios");
							   $(munis).show('slow');
                        }
                    }); //fin del ajax
    });
	
$('#paisResidencia').change(function() 
{
	var pais=$("#paisResidencia").val();
       var x = document.getElementById("divDepartamentos");
		var y = document.getElementById("divMunicipios");	
		if(pais.localeCompare("El Salvador")==0)
		{
			if (x.style.display === "none") 
			{
				$(x).show('slow');
			}				
		}
		else
			{
				
				$(x).hide('slow');
				$('#departamento').val('');
				$(y).hide('slow');
				$('#municipio').val('');
				console.log("despues mubi: "+$('#municipio').val());
			}
});

$('input[name=manejoIngles]').click(function() 
{
	 valor=($('input[name=manejoIngles]:checked').val());
	var x = document.getElementById("divOtrasLenguas");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si IDIOMAS");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
	
		$(x).hide('slow');				
	}
});

function validarCargos(numero)
{

  for (i = 1; i <=numero; i++) 
  {
     $("#formularioAplicacion").validate().element("#cargo"+i);
  }
  return true;
}

function validEmail(v) 
{
	
    var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (v.match(r) == null) ? false : true;
}

function goNextTab(currtab, nexttab, numeroActual,numeroSiguiente) 
{

    var curr = $('li.active');
    
    curr.removeClass('active');
    if (curr.is("li:last")) 
	{
        $("li:first-child").addClass('active');
    } 
	else 
	{
        curr.next().find("a").click();
        curr.next().addClass('active');
    }

	
			$("#nav-tab-"+numeroActual).removeClass("active");
			$("#nav-tab-"+numeroSiguiente).addClass("active");
			$('html, body').animate({scrollTop: 0}, 800);

    $('#' + currtab).attr('aria-expanded', 'false');
    $('#' + nexttab).attr('aria-expanded', 'true');

}
function borrarExperiencia() 
{
	var table = document.getElementById("tablaExperiencias");
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) 
	{
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 1) 
			{               // limit the user from removing all the fields
				alert("Cannot Remove all the Passenger.");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}
function anadirExperiencia() //para tab 2
{
	//alert("anadir entrada a tabla experiencias");
	var table = document.getElementById("tablaExperiencias");
	var rowCount = table.rows.length;
	//console.log("rowcount"+rowCount);
	if(rowCount < 10)
	{                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		//var cell5 = row.insertCell(4);
        var element1 = document.createElement('input'); //cargo[]
		var element2 = document.createElement('input'); //funciones[]
		var element3 = document.createElement('input');//institucion[]
		var element4 = document.createElement('input');//periodoInicial[]	 
		var element5 = document.createElement('input');//periodoFinal[]	 		

        element1.type="text"; element1.className="form-control"; element1.setAttribute("name", "cargo[]"); element1.setAttribute("id", "cargo"+rowCount); //cargo[]//cargo[]
		element2.type="text"; element2.className="form-control"; element2.setAttribute("name", "funciones[]"); element2.setAttribute("id", "funciones"+rowCount); //funciones[]
		element3.type="text"; element3.className="form-control";	element3.setAttribute("name", "institucion[]"); element3.setAttribute("id", "institucion"+rowCount);  //institucion[]
		element4.type="text"; element4.className="form-control";	element4.setAttribute("name", "periodoInicial[]"); element4.setAttribute("id", "periodoInicial"+rowCount); element4.setAttribute("value", "");  //periodoInicial[]
		element5.type="text"; element5.className="form-control";	element5.setAttribute("name", "periodoFinal[]"); element5.setAttribute("id", "periodoFinal"+rowCount); element5.setAttribute("value", "");  //periodoFinal[]	

		//Con estas lineas creo los SPAN   con el respectivo selector de fecha
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
			dd = '0'+dd
		} 

		if(mm<10) {
			mm = '0'+mm
		} 
		today = yyyy + '-' + mm + '-' + dd;
		console.log("Dia completo inicial: "+today);
		 var spanInicial = document.createElement('span');
		  var adicional1 = document.createElement('span');
        adicional1.setAttribute("class", "add-on");
        spanInicial.className="input-append date datepicker";
        spanInicial.setAttribute("data-date", today);
        spanInicial.setAttribute("data-date-format", "yyyy-mm-dd" );
        spanInicial.setAttribute("data-date-language", "es-ES");
        spanInicial.append(element4);
		spanInicial.append(adicional1);

		 
		 var spanFinal = document.createElement('span');
        var adicional2 = document.createElement('span');
        adicional2.setAttribute("class", "add-on");
        spanFinal.className="input-append date datepicker";
        spanFinal.setAttribute("data-date", today);
        spanFinal.setAttribute("data-date-format", "yyyy-mm-dd" );
        spanFinal.setAttribute("data-date-language", "es-ES");
        spanFinal.append(element5);
        spanFinal.append(adicional2);
	
		
		var guion = document.createTextNode("-");
		var div1 = document.createElement("div"); div1.className = "col-xs-4"; div1.appendChild(spanInicial);
		var div2 = document.createElement("div"); div2.className = "col-xs-4"; div2.appendChild(spanFinal);
		var div3 = document.createElement("div"); div3.className = "col-xs-1"; div3.appendChild(guion);
        cell1.appendChild(element1);
		cell2.appendChild(element2);
		cell3.appendChild(element3);
		 cell4.appendChild(div2);
         cell4.appendChild(div3);		 
		 cell4.appendChild(div1); 
		 
		 $(".datepicker").datepicker();
		
		masDeUnaExperiencia=true;		
	}
	else
	{
		 alert("10 experiencias laborales son suficientes");
			   
	}
}
//////////////////////////////////
function anadirCapacitacion()  //se USA EN TAB 6
{
	console.log("anadir entrada a tabla TALLERES Y CAPACITACIONES");
	var table = document.getElementById("tablaCapacitaciones");
	var rowCount = table.rows.length;
	//console.log("rowcount"+rowCount);
	if(rowCount < 10)
	{                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		var cell6 = row.insertCell(5);
		//var cell5 = row.insertCell(4);
        var element1 = document.createElement('input'); //nombreTaller[]
		var element2 = document.createElement('input'); //totalHoras[]
		var element3 = document.createElement('input'); //institucionTaller[]
		var element4 = document.createElement('input'); //atestado
		var element5 = document.createElement('input'); //periodoTallerInicial
		var element6 = document.createElement('input'); //periodoTallerFinal		
        element1.type="text"; element1.className="form-control"; element1.setAttribute("name", "nombreTaller[]"); element1.setAttribute("id", "nombreTaller"+rowCount);  element1.setAttribute("placeholder", "Nombre del taller impartido"); 
		element2.type="number"; element2.className="form-control"; element2.setAttribute("name", "totalHoras[]"); element2.setAttribute("id", "totalHoras"+rowCount); element2.setAttribute("min", "1"); element2.setAttribute("placeholder", "Número de horas impartidas"); //totalHoras[]
		element3.type="text";  element3.className="form-control"; element3.setAttribute("name", "institucionTaller[]"); element3.setAttribute("id", "institucionTaller"+rowCount);  element3.setAttribute("placeholder", "Institución donde impartió el taller"); //instgitucionTaler
		element4.type="file";  element4.setAttribute("name", "atestadoTaller[]"); element4.setAttribute("id", "atestadoTaller"+rowCount); //atestado
		element5.type="text"; element5.className="form-control";	element5.setAttribute("name", "periodoTallerInicial[]"); element5.setAttribute("id", "periodoTallerInicial"+rowCount); element5.setAttribute("value", "");
		element6.type="text"; element6.className="form-control";	element6.setAttribute("name", "periodoTallerFinal[]"); element6.setAttribute("id", "periodoTallerFinal"+rowCount); element6.setAttribute("value", ""); 		
		//Con estas lineas creo los select con el respectivo modalidad
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
			dd = '0'+dd
		} 

		if(mm<10) {
			mm = '0'+mm
		} 
		today = yyyy + '-' + mm + '-' + dd;
		//console.log("Dia completo inicial: "+today);
		 var spanInicial = document.createElement('span');
		  var adicional1 = document.createElement('span');
        adicional1.setAttribute("class", "add-on");
        spanInicial.className="input-append date datepicker";
        spanInicial.setAttribute("data-date", today);
        spanInicial.setAttribute("data-date-format", "yyyy-mm-dd" );
        spanInicial.setAttribute("data-date-language", "es-ES");
        spanInicial.append(element5);
		spanInicial.append(adicional1);

		 
		 var spanFinal = document.createElement('span');
        var adicional2 = document.createElement('span');
        adicional2.setAttribute("class", "add-on");
        spanFinal.className="input-append date datepicker";
        spanFinal.setAttribute("data-date", today);
        spanFinal.setAttribute("data-date-format", "yyyy-mm-dd" );
        spanFinal.setAttribute("data-date-language", "es-ES");
        spanFinal.append(element6);
        spanFinal.append(adicional2);
	
		
		var selectModalidad=document.createElement("select");
		selectModalidad.setAttribute("id", "modalidadTaller"+rowCount);
		selectModalidad.setAttribute("name", "modalidadTaller[]");
		selectModalidad.setAttribute("class", "form-control");
       
		var option3 = document.createElement("option"); option3.setAttribute("disabled", true); option3.setAttribute("selected", true); option3.setAttribute("value", "-1"); option3.text="Seleccione modalidad"
		selectModalidad.appendChild(option3);
		modalidades=["Presencial","Semipresencial","En línea"];
		for (var i = 0; i < modalidades.length; i++) 
		{
			var option = document.createElement("option");
			option.setAttribute("value", modalidades[i]);
			option.text = modalidades[i];			
			selectModalidad.appendChild(option);
		}
		var guion = document.createTextNode("-");
		var div1 = document.createElement("div"); div1.className = "col-xs-4"; div1.appendChild(spanFinal);
		var div2 = document.createElement("div"); div2.className = "col-xs-4"; div2.appendChild(spanInicial);
		var div3 = document.createElement("div"); div3.className = "col-xs-1"; div3.appendChild(guion);
		var div4 = document.createElement("div"); div4.className = "col-xs-9"; div4.appendChild(selectModalidad); //select modalidad
        cell1.appendChild(element1); //apend nombre del programa o taller
		cell2.appendChild(element2); //append del total de horas
		//append el rango: fecha-fecha
		 cell3.appendChild(div2);
         cell3.appendChild(div3);		 
		 cell3.appendChild(div1); 
		 //append la institucion
		 cell4.appendChild(element3);
		  //append modalidad
		 cell5.appendChild(div4);
		 //append atestado
		 cell6.appendChild(element4);
		 
		  $(".datepicker").datepicker();
	}
	else
	{
		 alert("10 talleres o  capacitaciones son suficientes");
			   
	}
}
//////////////////////////////////
function anadirMateria()  //se USA EN TAB 5
{
	//console.log("anadir entrada a tabla MATERIEAS");
	var table = document.getElementById("tablaMaterias");
	var rowCount = table.rows.length;
	//console.log("rowcount"+rowCount);
	if(rowCount < 10)
	{                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		//var cell5 = row.insertCell(4);
        var element1 = document.createElement('input'); //materia[]
		var element2 = document.createElement('input'); //institucionImpartida[]
		var element3 = document.createElement('input'); //atestado
		var element4 = document.createElement('input'); //atestado
		var element5 = document.createElement('input'); //atestado
        element1.type="text"; element1.className="form-control"; element1.setAttribute("name", "materia[]"); element1.setAttribute("id", "materia"+rowCount);  element1.setAttribute("placeholder", "Nombre de la materia impartida"); 
		element2.type="text"; element2.className="form-control"; element2.setAttribute("name", "institucionImpartida[]"); element2.setAttribute("id", "institucionImpartida"+rowCount); element2.setAttribute("placeholder", "Institución donde impartió la materia"); 
		element3.type="file";  element3.setAttribute("name", "atestadoMateria[]"); element3.setAttribute("id", "atestadoMateria"+rowCount);  //atestado: atestadoMateria[]	 
		element4.type="text"; element4.className="form-control";	element4.setAttribute("name", "periodoMateriaInicial[]"); element4.setAttribute("id", "periodoMateriaInicial"+rowCount); element4.setAttribute("value", "");  //periodoMateriaInicial[]
		element5.type="text"; element5.className="form-control";	element5.setAttribute("name", "periodoMateriaFinal[]"); element5.setAttribute("id", "periodoMateriaFinal"+rowCount); element5.setAttribute("value", "");  //periodoMateriaFinal[]	

			//Con estas lineas creo los SPAN   con el respectivo selector de fecha
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
			dd = '0'+dd
		} 

		if(mm<10) {
			mm = '0'+mm
		} 
		today = yyyy + '-' + mm + '-' + dd;
		console.log("Dia completo inicial: "+today);
		 var spanInicial = document.createElement('span');
		  var adicional1 = document.createElement('span');
        adicional1.setAttribute("class", "add-on");
        spanInicial.className="input-append date datepicker";
        spanInicial.setAttribute("data-date", today);
        spanInicial.setAttribute("data-date-format", "yyyy-mm-dd" );
        spanInicial.setAttribute("data-date-language", "es-ES");
        spanInicial.append(element4);
		spanInicial.append(adicional1);

		 
		 var spanFinal = document.createElement('span');
        var adicional2 = document.createElement('span');
        adicional2.setAttribute("class", "add-on");
        spanFinal.className="input-append date datepicker";
        spanFinal.setAttribute("data-date", today);
        spanFinal.setAttribute("data-date-format", "yyyy-mm-dd" );
        spanFinal.setAttribute("data-date-language", "es-ES");
        spanFinal.append(element5);
        spanFinal.append(adicional2);
	
		
		var selectModalidad=document.createElement("select");
		selectModalidad.setAttribute("id", "modalidad"+rowCount);
		selectModalidad.setAttribute("name", "modalidad[]");
		selectModalidad.setAttribute("class", "form-control");

		//opciones de modalidad
		var option3 = document.createElement("option"); option3.setAttribute("disabled", true); option3.setAttribute("selected", true); option3.setAttribute("value", "-1"); option3.text="Seleccione modalidad"
		selectModalidad.appendChild(option3);
		modalidades=["Presencial","Semipresencial","En línea"];
		for (var i = 0; i < modalidades.length; i++) 
		{
			var option = document.createElement("option");
			option.setAttribute("value", modalidades[i]);
			option.text = modalidades[i];			
			selectModalidad.appendChild(option);
		}
		var guion = document.createTextNode("-");
		var div1 = document.createElement("div"); div1.className = "col-xs-4"; div1.appendChild(spanFinal);
		var div2 = document.createElement("div"); div2.className = "col-xs-4"; div2.appendChild(spanInicial);
		var div3 = document.createElement("div"); div3.className = "col-xs-1"; div3.appendChild(guion);
		var div4 = document.createElement("div"); div4.className = "col-xs-9"; div4.appendChild(selectModalidad); //select modalidad
        cell1.appendChild(element1);
		cell2.appendChild(element2);
		//append el rango: fecha-fecha
		 cell3.appendChild(div2);
         cell3.appendChild(div3);		 
		 cell3.appendChild(div1); 
		 //append la modalidad
		 cell4.appendChild(div4);
		  //append el atestado
		 cell5.appendChild(element3);
		 $(".datepicker").datepicker();
	}
	else
	{
		 alert("10 experiencias laborales son suficientes");
			   
	}
}
function anadirGrado(nombreTabla)  //para tab 3
{
	//console.log("añadiendo  un item a 3");
	//alert("anadir entrada a tabla experiencias");
	var table = document.getElementById(nombreTabla);
	var rowCount = table.rows.length;
	//console.log("rowcount"+rowCount);
	if(rowCount < 10)
	{                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);

		//var cell5 = row.insertCell(4);
        var selectTitulo = document.createElement("select"); //inputs genericos
		var selectAno = document.createElement('select'); //
		var institucion = document.createElement('input');
		var nombreTitulo = document.createElement('input');
        var atestado = document.createElement('input'); 		
		 //EN LOS SELECTORES 		
			/////////////selector de TITULO/////////////////////////////////
			var titulos=new Array();
			if(nombreTabla.localeCompare("tablaGrados")==0)
			{
				titulos=["Licenciatura","Ingeniería","Doctorado"];
				selectTitulo.setAttribute("id", "tituloGrado"+rowCount);
				selectTitulo.setAttribute("name", "tituloGrado[]");
				selectTitulo.setAttribute("class", "form-control select");
			}
			
			if(nombreTabla.localeCompare("tablaPosGrados")==0)
			{
				titulos=["Maestría","Doctorado"];
				selectTitulo.setAttribute("id", "tituloPosgrado"+rowCount);
				selectTitulo.setAttribute("name", "tituloPosgrado[]");
				selectTitulo.setAttribute("class", "form-control select");
			}
			if(nombreTabla.localeCompare("tablaOtros")==0)
			{
				titulos=["Diplomado","Curso especializado","Otro"];
				selectTitulo.setAttribute("id", "tituloOtros"+rowCount);
				selectTitulo.setAttribute("name", "tituloOtros[]");
				selectTitulo.setAttribute("class", "form-control select");
			}
							
			
			
			for (var i = 0; i < titulos.length; i++) 
			{
				if(i==0)
				{
				var optiondefault = document.createElement("option");
				optiondefault.setAttribute("value", titulos[i]);
				optiondefault.setAttribute("disabled", "disabled");
				optiondefault.setAttribute("selected", "selected");
				optiondefault.setAttribute("value", "Seleccione un título");
				optiondefault.text = "Seleccione un título";
				selectTitulo.appendChild(optiondefault);
				}
				var option = document.createElement("option");
				option.setAttribute("value", titulos[i]);
				option.text = titulos[i];
				selectTitulo.appendChild(option);
				//selectFinal.appendChild(option);
			}
			/////////////selector de año/////////////////////////////////
			if(nombreTabla.localeCompare("tablaGrados")==0)
			{
				selectAno.setAttribute("id", "anoGrado"+rowCount);
				selectAno.setAttribute("name", "anoGrado[]");
				selectAno.setAttribute("class", "form-control select");
			}
			if(nombreTabla.localeCompare("tablaPosGrados")==0)
			{
				selectAno.setAttribute("id", "anoPosgrado"+rowCount);
				selectAno.setAttribute("name", "anoPosgrado[]");
				selectAno.setAttribute("class", "form-control select");
			}
			if(nombreTabla.localeCompare("tablaOtros")==0)
			{
				selectAno.setAttribute("id", "anoOtros"+rowCount);
				selectAno.setAttribute("name", "anoOtros[]");
				selectAno.setAttribute("class", "form-control select");
			}
			var d = new Date();
			var n = d.getFullYear();
			for (var i = n; i >= 1950; i--) 
			{
				if(i==n)
				{
				var optiondefault = document.createElement("option");
				optiondefault.setAttribute("value", titulos[i]);
				optiondefault.setAttribute("disabled", "disabled");
				optiondefault.setAttribute("selected", "selected");
				optiondefault.setAttribute("value", "Seleccione un título");
				optiondefault.text = "Elija un año";
				selectAno.appendChild(optiondefault);
				}
				var option = document.createElement("option");
				option.setAttribute("value", i);
				option.text = i;
				selectAno.appendChild(option);
				//selectFinal.appendChild(option);
			}			
			///////////////////////////////////
			/////////////selectores /////////////////////////////////
			if(nombreTabla.localeCompare("tablaGrados")==0)
			{
				institucion.type="text"; institucion.className="form-control"; institucion.setAttribute("name", "institucionGrado[]"); institucion.setAttribute("id", "institucionGrado"+rowCount); 
				nombreTitulo.type="text"; nombreTitulo.className="form-control"; nombreTitulo.setAttribute("name", "nombreTituloGrado[]"); nombreTitulo.setAttribute("id", "nombreTituloGrado"+rowCount); 
				atestado.type="file"; atestado.className="form-control"; atestado.setAttribute("name", "atestadoGrado[]"); atestado.setAttribute("id", "atestadoGrado"+rowCount);
				
			}
			if(nombreTabla.localeCompare("tablaPosGrados")==0)
			{
				institucion.type="text"; institucion.className="form-control"; institucion.setAttribute("name", "institucionPosgrado[]"); institucion.setAttribute("id", "institucionPosgrado"+rowCount);
				nombreTitulo.type="text"; nombreTitulo.className="form-control"; nombreTitulo.setAttribute("name", "nombreTituloPosGrado[]"); nombreTitulo.setAttribute("id", "nombreTituloPosGrado"+rowCount);
				atestado.type="file"; atestado.className="form-control"; atestado.setAttribute("name", "atestadoPosgrado[]"); atestado.setAttribute("id", "atestadoPosgrado"+rowCount);
			}
			if(nombreTabla.localeCompare("tablaOtros")==0)
			{
				institucion.type="text"; institucion.className="form-control"; institucion.setAttribute("name", "institucionOtros[]"); institucion.setAttribute("id", "institucionOtros"+rowCount);
				nombreTitulo.type="text"; nombreTitulo.className="form-control"; nombreTitulo.setAttribute("name", "nombreTituloOtros[]"); nombreTitulo.setAttribute("id", "nombreTituloOtros"+rowCount);
				atestado.type="file"; atestado.className="form-control"; atestado.setAttribute("name", "atestadoOtros[]"); atestado.setAttribute("id", "atestadoOtros"+rowCount);
			}
			institucion.setAttribute("placeholder", "Nombre de la institución...");
			nombreTitulo.setAttribute("placeholder", "Nombre del título obtenido...");			
	
				var div1 = document.createElement("div"); div1.className = "col-xs-8"; div1.appendChild(selectTitulo);
				var div2 = document.createElement("div"); div2.className = "col-xs-12"; div2.appendChild(nombreTitulo);
				var div3 = document.createElement("div"); div3.className = "col-xs-8"; div3.appendChild(selectAno);
				var div4 = document.createElement("div"); div4.className = "col-xs-12"; div4.appendChild(institucion);
				var div5 = document.createElement("div"); div5.className = "col-xs-12"; div5.appendChild(atestado);				
				cell1.appendChild(div1);
				cell2.appendChild(div2);		 
				cell3.appendChild(div3);
				cell4.appendChild(div4);
				cell5.appendChild(div5); 	 				
				//console.log(" terminado tabla grados");				
	}
	else
	{
		 alert("10 grados  son suficientes");
			   
	}
}
//para TAB 7;
function anadirTab7(nombreTabla,arrayDescripcion,arrayAtestados)  //para tab 3
{
	//console.log("añadiendo  un item a tabla" + nombreTabla);

	var table = document.getElementById(nombreTabla);
	var rowCount = table.rows.length;
	if(rowCount < 10)
	{                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);

		//var cell5 = row.insertCell(4);
		var areaTexto = document.createElement('textarea'); //el area de texto donde el postulante escribe su 
		var atestado = document.createElement('input'); atestado.type="file";// recibe un archivo
		 //meto atributos a los inputs creados
		areaTexto.setAttribute("id", arrayDescripcion+rowCount);
		areaTexto.setAttribute("name", arrayDescripcion+"[]");
		areaTexto.setAttribute("class", "form-control");
		areaTexto.setAttribute("placeholder", "Ingrese su texto aquí...");
		
		atestado.setAttribute("id", arrayAtestados+rowCount);
		atestado.setAttribute("name", arrayAtestados+"[]");
			////////////////////////////////////////////////////////////////////					
		cell1.appendChild(areaTexto);
		cell2.appendChild(atestado);		 			
	}
	else
	{
		 alert("10 muestras del manejo de la metodología son suficientes");
			   
	}
}
//para TAB 8:
function anadirIdiomas(nombreTabla)  //para tab 8
{
	//console.log("añadiendo  un item a tabla" + nombreTabla);

	var table = document.getElementById(nombreTabla);
	var rowCount = table.rows.length;
	if(rowCount < 10)
	{                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
        var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);

	
		var idioma = document.createElement('input'); //
		 //meto atributos a los inputs creados
		 idioma.setAttribute("type", "text");
		idioma.setAttribute("id", "idiomas"+rowCount);
		idioma.setAttribute("name","idiomas[]");
		idioma.setAttribute("class", "form-control");
		idioma.setAttribute("placeholder", "Nombre del idioma o dialecto...");
		
		var hablado = document.createElement('input'); 
		hablado.type="number";// recibe un archivo
		hablado.setAttribute("min", "0");
		hablado.setAttribute("max", "5");
		hablado.setAttribute("id", "hablados"+rowCount);
		hablado.setAttribute("name","hablados[]");
		hablado.setAttribute("class", "form-control");
		hablado.setAttribute("step", "1");
		hablado.setAttribute("value", "0");
		
		
		var escuchado = document.createElement('input'); 
		escuchado.type="number";// recibe un archivo
		escuchado.setAttribute("min", "0");
		escuchado.setAttribute("max", "5");
		escuchado.setAttribute("id", "escuchados"+rowCount);
		escuchado.setAttribute("name","escuchados[]");
		escuchado.setAttribute("class", "form-control");
		escuchado.setAttribute("step", "1");
		escuchado.setAttribute("value", "0");
		
		var escrito = document.createElement('input'); 
		escrito.type="number";// recibe un archivo
		escrito.setAttribute("min", "0");
		escrito.setAttribute("max", "5");
		escrito.setAttribute("id", "escritos"+rowCount);
		escrito.setAttribute("name","escritos[]");
		escrito.setAttribute("class", "form-control");
		escrito.setAttribute("step", "1");
		escrito.setAttribute("value", "0");

			////////////////////////////////////////////////////////////////////					
		cell1.appendChild(idioma);
		cell2.appendChild(hablado);
		cell3.appendChild(escuchado);
		cell4.appendChild(escrito);		
	}
	else
	{
		 alert("10 idiomas son suficientes");
			   
	}
}
/////////////////para tab 4: AL PRESIONAR SOBRE UN TEMA EL BOTÓN "SI" MOSTRARME LA LISTA DE ESOS TEMAS ///////////////
$('input[name=gerenciaPublica]').click(function() 
{
	console.log("ACTIVADO EVENTO CLICK EN GERENCIA");
    valor=($('input[name=gerenciaPublica]:checked').val());
	console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarGerencia");
	if(valor.localeCompare("si")==0)
	{
		console.log("el valor es si EN EVENTO CLICK GERENCIA");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
	
		$(x).hide('slow');				
	}
});
///////////////////////////////////////
$('input[name=planificacionDesarrollo]').click(function() 
{
    valor=($('input[name=planificacionDesarrollo]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarPlanificacion");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=gestionTalento]').click(function() 
{
    valor=($('input[name=gestionTalento]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarTalento");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=gobiernoTerritorio]').click(function() 
{
    valor=($('input[name=gobiernoTerritorio]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarGobierno");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=etica]').click(function() 
{
    valor=($('input[name=etica]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarEtica");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=gobiernoElectronico]').click(function() 
{
    valor=($('input[name=gobiernoElectronico]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarElectronico");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=gobiernoAbierto]').click(function() 
{
    valor=($('input[name=gobiernoAbierto]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarAbierto");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=gestionCalidad]').click(function() 
{
    valor=($('input[name=gestionCalidad]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarCalidad");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=enfoque]').click(function() 
{
    valor=($('input[name=enfoque]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarEnfoque");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=relaciones]').click(function() 
{
    valor=($('input[name=relaciones]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarRelaciones");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});
///////////////////////////////////////
$('input[name=capacitacion]').click(function() 
{
    valor=($('input[name=capacitacion]:checked').val());
	//console.log("valor de gerencia pública: "+valor);
	var x = document.getElementById("mostrarCapacitacion");
	if(valor.localeCompare("si")==0)
	{
		//console.log("el valor es si");
		 
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		} 		
	}	
	else
	{		
		$(x).hide('slow');		
	}
});

// A CONTINUACION APARECE PARA LA TAB 7, AL PRESIONAR EN UN CHECKBUTTON QUE SE MUESTREN CAMPOS PARA EXPERIENCIAS
//71
$('#metodologiaDiseño').change(function() 
{
	var x = document.getElementById("siete1");
    if($(this).is(":checked")) 
	{			
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		}
	}
	else
	{			
			$(x).hide('slow');
			 var a = document.getElementsByName("metodologiaProgramas[]");
			 var b = document.getElementsByName("metodologiaProgramasAtestado[]");
			 var longi=a.length;
		   //console.log("Longi: "+longi);
			   for(var i=0;i<longi;i++)
			   {
				   //console.log("el area: "+elarea);
				   a[i].value="";
				   b[i].value="";	
				   
				} 
	}			              
    });
               
//72
$('#disenoCartas').change(function() 
{
	var x = document.getElementById("siete2");
	if($(this).is(":checked")) 
	{			
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		}
	}
	else
	{			
			$(x).hide('slow');
			 var a = document.getElementsByName("metodologiaDisenoCartas[]");
			 var b = document.getElementsByName("metodologiaDisenoCartasAtestado[]");
			 var longi=a.length;
		   //console.log("Longi: "+longi);
			   for(var i=0;i<longi;i++)
			   {
				   //console.log("el area: "+elarea);
				   a[i].value="";
				   b[i].value="";	
				   
				} 
		
	}  
               
    });
	
//73
$('#evaluacionProcesos').change(function() 
{
	var x = document.getElementById("siete3");
        if($(this).is(":checked")) 
		{
            
			
			if (x.style.display === "none") 
			{
				$(x).show('slow');
			}
        }
		else
		{			
				$(x).hide('slow');
				var a = document.getElementsByName("metodologiaEvaluacion[]");
			 var b = document.getElementsByName("metodologiaEvaluacionAtestado[]");
			 var longi=a.length;
		   //console.log("Longi: "+longi);
			   for(var i=0;i<longi;i++)
			   {
				   //console.log("el area: "+elarea);
				   a[i].value="";
				   b[i].value="";	
				   
				} 
			
		}
               
    });
//74
$('#facilitacionTalleres').change(function() 
{
	var x = document.getElementById("siete4");
	if($(this).is(":checked")) 
	{			
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		}
	}
	else
	{			
			$(x).hide('slow');
			var a = document.getElementsByName("metodologiaFacilitacion[]");
			 var b = document.getElementsByName("metodologiaFacilitacionAtestado[]");
			 var longi=a.length;		  
			   for(var i=0;i<longi;i++)
			   {				 
				   a[i].value="";
				   b[i].value="";					   
				} 
		
	}               
    });
//75
$('#metodologiasParticipativas').change(function() 
{
	var x = document.getElementById("siete5");
	if($(this).is(":checked")) 
	{			
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		}
	}
	else
	{			
			$(x).hide('slow');
			var a = document.getElementsByName("metodologiaParticipativa[]");
			 var b = document.getElementsByName("metodologiaParticipativaAtestado[]");
			 var longi=a.length;		  
			   for(var i=0;i<longi;i++)
			   {				 
				   a[i].value="";
				   b[i].value="";					   
				} 
		
	}               
    });
//76
$('#elaboracionMaterial').change(function() 
{
	var x = document.getElementById("siete6");
	if($(this).is(":checked")) 
	{			
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		}
	}
	else
	{			
			$(x).hide('slow');
			var a = document.getElementsByName("metodologiaElaboracion[]");
			 var b = document.getElementsByName("metodologiaElaboracionAtestado[]");
			 var longi=a.length;		  
			   for(var i=0;i<longi;i++)
			   {				 
				   a[i].value="";
				   b[i].value="";					   
				} 
		
	}               
    });
//77
$('#disenador').change(function() 
{
	var x = document.getElementById("siete7");
	if($(this).is(":checked")) 
	{			
		if (x.style.display === "none") 
		{
			$(x).show('slow');
		}
	}
	else
	{			
			$(x).hide('slow');
			var a = document.getElementsByName("metodologiaLinea[]");
			 var b = document.getElementsByName("metodologiaLineaAtestado[]");
			 var longi=a.length;		  
			   for(var i=0;i<longi;i++)
			   {				 
				   a[i].value="";
				   b[i].value="";					   
				} 
		
	}               
    });
///////////////////////////////////////
function eliminarDeTabla(tabla)
{
 //alert("eliminando de tabla: "+tabla);
    var table = document.getElementById(tabla);
    var rowCount = table.rows.length;

    if(rowCount>1)
	{            
        table.deleteRow(-1);
    }
}

//////////////////////////////////////////////////////   COMPROBACINES PARA DOCUMENT READY  ///////////////////////////
$(document).ready(function () 
{
 $.fn.datepicker.defaults.autoclose = true;
//pestaña 2
document.getElementById("anadeExperiencia").addEventListener("click", function() {anadirExperiencia()});
document.getElementById("eliminaExperiencia").addEventListener("click", function() {eliminarDeTabla("tablaExperiencias")});
/////pestaña 3
document.getElementById("anadeGrado").addEventListener("click", function() {anadirGrado("tablaGrados")});
document.getElementById("eliminaGrado").addEventListener("click", function() {eliminarDeTabla("tablaGrados")});
document.getElementById("anadePosGrado").addEventListener("click", function() {anadirGrado("tablaPosGrados")});
document.getElementById("eliminaPosGrado").addEventListener("click", function() {eliminarDeTabla("tablaPosGrados")});
document.getElementById("anadeOtro").addEventListener("click", function() {anadirGrado("tablaOtros")});
document.getElementById("eliminaOtro").addEventListener("click", function() {eliminarDeTabla("tablaOtros")});
//pestaña 5
document.getElementById("anadeMateria").addEventListener("click", function() {anadirMateria()});
document.getElementById("eliminaMateria").addEventListener("click", function() {eliminarDeTabla("tablaMaterias")});
//pestaña 6
document.getElementById("anadeCapacitacion").addEventListener("click", function() {anadirCapacitacion()});
document.getElementById("eliminaCapacitacion").addEventListener("click", function() {eliminarDeTabla("tablaCapacitaciones")});
//pestaña 7
//para la tab 7, ya que habran varias tablas iguales, se llama   la funcion anadirTab7 que recibe dos argumentos: nombre de la tabla de la metodologia
//y el nombre de los array de nombres de input, y tercero, array de nombres de atestado
////////////////////////////////////////////////
	//71 (pestaña 7 checbox 1: Diseño de proyectos/programas de capacitacion.
	document.getElementById("anade71").addEventListener("click", function() {anadirTab7("tabla71","metodologiaProgramas","metodologiaProgramasAtestado")});
	document.getElementById("elimina71").addEventListener("click", function() {eliminarDeTabla("tabla71")});
	 //72
	document.getElementById("anade72").addEventListener("click", function() {anadirTab7("tabla72","metodologiaDisenoCartas","metodologiaDisenoCartasAtestado")});
	document.getElementById("elimina72").addEventListener("click", function() {eliminarDeTabla("tabla72")});
	 //73
	document.getElementById("anade73").addEventListener("click", function() {anadirTab7("tabla73","metodologiaEvaluacion","metodologiaEvaluacionAtestado")});
	document.getElementById("elimina73").addEventListener("click", function() {eliminarDeTabla("tabla73")});
	 //74
	document.getElementById("anade74").addEventListener("click", function() {anadirTab7("tabla74","metodologiaFacilitacion","metodologiaFacilitacionAtestado")});
	document.getElementById("elimina74").addEventListener("click", function() {eliminarDeTabla("tabla74")});
	//75
	document.getElementById("anade75").addEventListener("click", function() {anadirTab7("tabla75","metodologiaParticipativa","metodologiaParticipativaAtestado")});
	document.getElementById("elimina75").addEventListener("click", function() {eliminarDeTabla("tabla75")});
	//76
	document.getElementById("anade76").addEventListener("click", function() {anadirTab7("tabla76","metodologiaElaboracion","metodologiaElaboracionAtestado")});
	document.getElementById("elimina76").addEventListener("click", function() {eliminarDeTabla("tabla76")});
	//77
	document.getElementById("anade77").addEventListener("click", function() {anadirTab7("tabla77","metodologiaLinea","metodologiaLineaAtestado")});
	document.getElementById("elimina77").addEventListener("click", function() {eliminarDeTabla("tabla77")});
	//PESTAÑA 8: AÑADIR IDIOMAS AUTOMÁTICAMENTE
	document.getElementById("anadeIdioma").addEventListener("click", function() {anadirIdiomas("tablaIdiomas")});
	document.getElementById("eliminaIdioma").addEventListener("click", function() {eliminarDeTabla("tablaIdiomas")});
	//pestaña 9: tooltip de Que significa esto?
	$('[data-toggle="tooltip"]').tooltip();   

/*  */

	////////////////////////////////////////////////////
	///////BOTONES PARA REGRESAR ATRÁS
	//--/-/-/-/-/-/-/-/-/-----/-/-/-/-/-/-/-/-/-/-/-
 $("#btn-prev-2").on("click", function()
  {
  	$("#nav-tab-2").removeClass("active");
  	$("#nav-tab-1").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
  $("#btn-prev-3").on("click", function()
  {
  	$("#nav-tab-3").removeClass("active");
  	$("#nav-tab-2").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
  
  
  $("#btn-prev-4").on("click", function()
  {
  	$("#nav-tab-4").removeClass("active");
  	$("#nav-tab-3").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
  
   $("#btn-prev-5").on("click", function()
  {
  	$("#nav-tab-5").removeClass("active");
  	$("#nav-tab-4").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
    $("#btn-prev-6").on("click", function()
  {
  	$("#nav-tab-6").removeClass("active");
  	$("#nav-tab-5").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
  $("#btn-prev-7").on("click", function()
  {
  	$("#nav-tab-7").removeClass("active");
  	$("#nav-tab-6").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
  $("#btn-prev-8").on("click", function()
  {
  	$("#nav-tab-8").removeClass("active");
  	$("#nav-tab-7").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  }); 
   $("#btn-prev-9").on("click", function()
  {
  	$("#nav-tab-9").removeClass("active");
  	$("#nav-tab-8").addClass("active");
  	$('html, body').animate({scrollTop: 0}, 800);
  });
  /*
  REGLAS DE VALIDACION
  --/-/-/-/-/-/-/-/-/-----/-/-/-/-/-/-/-/-/-/-/-
  */
		// $.validator.addMethod("regx", function(value, element, regexpr) {          
    // return this.optional(element) || regexpr.test(value);
// }, "Ingrese un formato de NIT válido: 0101-010101-101-1");
    $('#formularioAplicacion').validate({
         ignore: '',
		rules: {
            nombre: 
			{
                required: true
            },
            telefonoCompleto: 
			{
                required: true,
				minlength: 8
            },
			 paisResidencia: 
			{
                required: true
            },
			tipoDocumento: 
			{
                required: true
            },
			numeroDocumento: 
			{
                required: true
            },
			correo: 
			{
                required: true,
				email: true
            },
			genero: 
			{
                required: true
            },
			edad: 
			{
                required: true
            },
            referenciasPersonales: 
			{
                required: true
            },
            cartaMotivacion: 
			{
                required: true
            },

        },
		messages: 
		{
		  nombre: "Debe ingresar su nombre",
		  fechaFin: "Aviso: debe ingresar una fecha inicial del rango",
		  telefonoCompleto: "Ingrese su número de teléfono completo, mínimo 8 dígitos",
		   paisResidencia: "Debe seleccionar un país de residencia",
			numeroDocumento: "Debe ingresar el número de documento",
			funciones: "Debe ingresar un correo electrónico válido",
			institucion: "Debe ingresar un correo electrónico válido",
			correo: "Debe ingresar un correo electrónico válido",
			genero: "Debe seleccionar un género",
			edad: "Debe ingresar su edad actual",
			tipoDocumento: "Debe seleccionar el tipo de documento",
			cartaMotivacion: "Debe adjuntar su carta de motivación",
			referenciasPersonales: "Debe adjuntar una carta de referencias personales"
		},
        submitHandler: function (form) { // for demo
            alert('Formulario llenado correctamente. Ahora será procesado.');
            //var $form = $(form);
            //$form.submit();
			 form.submit();
        }
    });
  /*
  botones PARA PASAR HACIA ADELANTE
  --/-/-/-/-/-/-/-/-/-----/-/-/-/-/-/-/-/-/-/-/-
  */
    // /////////////////////////////  BOTON PARA PASAR DE TAB 1 A TAB 2: valido pestaña 1
    $('#btn-next-1').on('click', function () 
	{
		//VALIDAMOS TODOS LOS CAMPOS DE LA TAB 1
		console.log("a validar");
        var validator = $("#formularioAplicacion").validate();


		var nombre=validator.element("#nombre");
		var paisResidencia=validator.element("#paisResidencia");		
		var telefonoCompleto=validator.element("#telefonoCompleto");	
		var numeroDocumento=validator.element("#numeroDocumento");
		var correo=validator.element("#correo");
		var edad=validator.element("#edad");
		//var nit=validator.element("#nit");
		//console.log("resultado de validar nit: "+nit);
		var tipodoc=validator.element("#tipoDocumento");
		var genero=validator.element("#genero");
		//alert("resultado de validar nombre: "+nombre);
		if(nombre==true && paisResidencia==true && telefonoCompleto==true && numeroDocumento==true && correo==true && tipodoc==true && genero==true && edad==true)
		{
			goNextTab('tab_1','tab_2',1,2);
		}
		
    });
	// /////////////////////////////  BOTON PARA PASAR DE TAB 2 A TAB 3: valido pestaña 2
	$('#btn-next-2').on('click', function () 
	{
		var cargos = document.getElementsByName("cargo[]");
		if(cargos.length==0)
		{
			//si no tiene experiencias laborales, se va de un solo a la otra pestaña
			goNextTab('tab_2','tab_3',2,3);
		}
		
		 $("[name^=cargo]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe precisar el nombre o breve descripción del cargo"
                }
            });
        });
		$("[name^=funciones]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar brevemente las funciones desempeñadas en ese cargo"
                }
            });
        });
		$("[name^=institucion]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar la institución donde desempeñó el cargo"
                }
            });
        });
		$("[name^=periodoInicial]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione una fecha de inicio del cargo"
                }
            });
        });
		$("[name^=periodoFinal]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione fecha final del cargo."
                }
            });
        });
		var validator = $("#formularioAplicacion").validate();
		//var cargos = document.getElementsByName("cargo[]");
		var funciones = document.getElementsByName("funciones[]");
		var instituciones = document.getElementsByName("institucion[]");
		var iniciales = document.getElementsByName("periodoInicial[]");
		var finales = document.getElementsByName("periodoFinal[]");
		var longi=cargos.length;
		for(var i=0;i<longi;i++)
		{						
		   var verCargo=validator.element(cargos[i]);
		   var verFunciones=validator.element(funciones[i]);
		   var verInstituciones=validator.element(instituciones[i]);
		   var verIniciales=validator.element(iniciales[i]);
		   var verFinales=validator.element(finales[i]);
		   
		} 
		if(verCargo==true && verFunciones==true && verInstituciones==true  && verIniciales==true && verFinales==true)
		{
			goNextTab('tab_2','tab_3',2,3);

		}		
	}); //fin de pasar de tab 2 a 3, ya queda validada formalmente
	

});
$('#btn-next-3').on('click', function () 
	{		
	    var validator = $("#formularioAplicacion").validate();
		var tGrado = document.getElementsByName("tituloGrado[]"); var long1=tGrado.length;
		var tPosgrado = document.getElementsByName("tituloPosgrado[]"); var long2=tPosgrado.length;
		var tOtro = document.getElementsByName("tituloOtros[]");	 var long3=tOtro.length;
			//console.log("Lengusht 1,2,3 "+long1,long2,long3);
		if(long1==0 && long2==0 && long3==0)
		{
			//si no tiene lleno nada en ninguna de las 3 secciones, es que no tiene formación en nada, pasamos
			goNextTab('tab_3','tab_4',3,4);			
		}
		else //si hay cosas en el tab, debo comprobarlas
		{
				var estaGrados=false
			if (long1==0)  //si no tiene ninguna experiencia en grados esta bien
			{
				estaGrados=true;
			}		
			if(long1!=0)
			{
					//////////grados
					console.log("Grados tiene más de uno, debo comprobar");
				$("[name^=tituloGrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar título"
					}
				});
				});
				$("[name^=nombreTituloGrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe precisar el nombre o breve descripción del título obtenido"
					}
				});
				});
				$("[name^=anoGrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar en qué año lo obtuvo"
					}
				});
				});
				$("[name^=institucionGrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar el nombre de la institución donde obtuvo el título"
					}
				});
				});
				$("[name^=atestadoGrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar una copia del título o atestado"
					}
				});
				});
			    var titgra = document.getElementsByName("tituloGrado[]");
				var ntgra = document.getElementsByName("nombreTituloGrado[]");
				var angra = document.getElementsByName("anoGrado[]");
				var instigra = document.getElementsByName("institucionGrado[]");
				var ategra = document.getElementsByName("atestadoGrado[]");
				for(var i=0;i<long1;i++)
				{						
				   var gra=validator.element(titgra[i]);
				   var gre=validator.element(ntgra[i]);
				   var gri=validator.element(angra[i]);
				   var gro=validator.element(instigra[i]);
				   var gru=validator.element(ategra[i]);
				   
				}
				if(gra==true && gre==true && gri==true  && gro==true && gru==true)
				{
					estaGrados=true;
					console.log("Esta correcto grados");
				}
			}//fin de comprobar si grados tiene algo
			var estaPosgrados=false
			if (long2==0)  //si no tiene ninguna experiencia en grados esta bien
			{
				estaPosgrados=true;
			}	
			if(long2!=0)
			{
					//////////posgrados
					console.log("posgrados tiene más de uno, debo comprobar");
				$("[name^=tituloPosgrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar título"
					}
				});
				});
				$("[name^=nombreTituloPosGrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe precisar el nombre o breve descripción del título obtenido"
					}
				});
				});
				$("[name^=anoPosgrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						required:"Debe indicar en qué año lo obtuvo"
					}
				});
				});
				$("[name^=institucionPosgrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar el nombre de la institución donde obtuvo el título"
					}
				});
				});
				$("[name^=atestadoPosgrado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar una copia del título o atestado"
					}
				});
				});
				var tp = document.getElementsByName("tituloPosgrado[]");
				var ntp = document.getElementsByName("nombreTituloPosGrado[]");
				var agp = document.getElementsByName("anoPosgrado[]");
				var igp = document.getElementsByName("institucionPosgrado[]");
				var atgp = document.getElementsByName("atestadoPosgrado[]");
				for(var i=0;i<long2;i++)
				{						
				   var posgra=validator.element(tp[i]);
				   var posgre=validator.element(ntp[i]);
				   var posgri=validator.element(agp[i]);
				   var posgro=validator.element(igp[i]);
				   var posgru=validator.element(atgp[i]);				   
				}
				if(posgra==true && posgre==true && posgri==true  && posgro==true && posgru==true)
				{
					estaPosgrados=true;
					console.log("Esta correcto posgrados");
				}					
			}
			
			var estaOtros=false;
			if(long3==0)
			{
				estaOtros=true;
			}
			if(long3!=0)
			{
					//////////otros
					console.log("otross tiene más de uno, debo comprobar");
				$("[name^=tituloOtros]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar título"
					}
				});
				});
				$("[name^=nombreTituloOtros]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe precisar el nombre o breve descripción del título obtenido"
					}
				});
				});
				$("[name^=anoOtros]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar en qué año lo obtuvo"
					}
				});
				});
				$("[name^=institucionOtros]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar el nombre de la institución donde obtuvo el título"
					}
				});
				});
				$("[name^=atestadoOtros]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar una copia del título o atestado"
					}
				});
				});
				var totro = document.getElementsByName("tituloOtros[]");
				var nto = document.getElementsByName("nombreTituloOtros[]");
				var ago = document.getElementsByName("anoOtros[]");
				var igo = document.getElementsByName("institucionOtros[]");
				var atgo = document.getElementsByName("atestadoOtros[]");
				for(var i=0;i<long3;i++)
				{						
				   var verCargo=validator.element(totro[i]);
				   var verFunciones=validator.element(nto[i]);
				   var verInstituciones=validator.element(ago[i]);
				   var verIniciales=validator.element(igo[i]);
				   var verFinales=validator.element(atgo[i]);
				   
				}
				if(verCargo==true && verFunciones==true && verInstituciones==true  && verIniciales==true && verFinales==true)
				{
					estaOtros=true;
					console.log("Esta correcto otros");

				}
			}
			console.log("Booleans 1,2,3: -"+estaGrados+estaPosgrados+estaOtros);										
			////////////////////////////////// POR ULTISMO
			if(estaGrados && estaPosgrados && estaOtros) // SI LAS 3 SERCCIONES ESTÁN CORRECTAS, PASO A LA OTRA PESTAÑA
			{
				console.log("me voy");
				goNextTab('tab_3','tab_4',3,4);
					
			}				    		
		}//fin del else si no hay nada en el tab
			
    });

  $('#btn-next-4').on('click', function () 
	{
		//console.log("PASO DE 4 A 5");
		var puedoPasar=true;
	   //para pasar de la tab 4 a la 5, debo comprobar que cada radio cuyo valor sea sí, no esté vacia la lista de seleccionç
	   //1: gerencia pública:
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=gerenciaPublica]:checked').val());
			//console.log("valor de gerencia pública: "+valor);
			if(valor.localeCompare("si")==0)
			{
				//console.log("el valor es si EN EVENTO CLICK GERENCIA");
				$("[name^=temasGerencia]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de gerencia pública que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasGerencia"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//2: planificacion para el desarrollo
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=planificacionDesarrollo]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasPlanificacion]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de planificación para el desarollo que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasPlanificacion"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//3: gestión del talento humano
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=gestionTalento]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasTalento]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de gestión del talento humano que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasTalento"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//4: Gobierno y territorio
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=gobiernoTerritorio]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasGobierno]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Gobierno y territorio que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasGobierno"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		
		//5: Ética y transparencia en la gestión pública
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=etica]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasEtica]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Ética y transparencia en la gestión pública que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasEtica"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		
		//6: Gobierno electrónico
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=gobiernoElectronico]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasElectronico]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Gobierno electrónico que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasElectronico"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//7: Gobierno abierto y participación ciudadana
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=gobiernoAbierto]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasAbierto]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Gobierno abierto y participación ciudadana que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasAbierto"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//8: Gestión de Calidad en el sector público
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=gestionCalidad]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasCalidad]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Gestión de Calidad en el sector público que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasCalidad"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//9: Enfoque de derechos en la gestión pública
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=enfoque]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasEnfoque]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Enfoque de derechos en la gestión pública que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasEnfoque"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//10:Relaciones laborales en el sector público
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=relaciones]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasRelaciones]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Relaciones laborales en el sector público que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasRelaciones"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}
		//11:R Gestión de capacitación en el sector público
	    var validator = $("#formularioAplicacion").validate();
	     valor=($('input[name=capacitacion]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=temasCapacitacion]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe seleccionar de la lista los temas de Gestión de capacitación en el sector público que asegura conocer"
					}
				});
			});
            var ger=validator.element('[name^="temasCapacitacion"]'); //console.log("cargo: "+cargo);
			if(!ger)
			{
					puedoPasar=false;
			}
		}		
		/////al final si puedo pasar hago el cambio de tabs
		if(puedoPasar)
		{
			goNextTab('tab_4','tab_5',4,5);
		}
     
		
    });	
	///// pasar de tab 5 a 6
	$('#btn-next-5').on('click', function () 
	{
		//console.log("PASO DE 5 A 6");
		var materias = document.getElementsByName("materia[]");
		if(materias.length==0)
		{
			//si no tiene experiencias laborales, se va de un solo a la otra pestaña
			goNextTab('tab_5','tab_6',5,6);
		}
		else
		{
			$("[name^=materia]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar el nombre de la asignatura impartida"
                }
            });
        });
		$("[name^=institucionImpartida]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar la institución donde impartió la materia"
                }
            });
        });
		$("[name^=periodoMateriaInicial]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione un año de inicio del cargo"
                }
            });
        });
		$("[name^=periodoMateriaFinal]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione un año de finalización del cargo. Si sigue en curso, seleccione el año actuals"
                }
            });
        });
		$("[name^=modalidad]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione la modalidad correspondiente de la lista"
                }
            });
        });
		$("[name^=atestadoMateria]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe adjuntar el atestado o comprobante de impartición de la materia"
                }
            });
        })
		var validator = $("#formularioAplicacion").validate();
		var listaMaterias = document.getElementsByName("materia[]");
		var institucion = document.getElementsByName("institucionImpartida[]");
		var pInicial = document.getElementsByName("periodoMateriaInicial[]");
		var pFinal = document.getElementsByName("periodoMateriaFinal[]");
		var modalidad = document.getElementsByName("modalidad[]");
		var atestado = document.getElementsByName("atestadoMateria[]");
		var longi=listaMaterias.length;
		for(var i=0;i<longi;i++)
		{						
		   var valMaterias=validator.element(listaMaterias[i]);
		   var valInsti=validator.element(institucion[i]);
		   var valIni=validator.element(pInicial[i]);
		   var valFini=validator.element(pFinal[i]);
		   var valModalidad=validator.element(modalidad[i]);
		   var valAtesta=validator.element(atestado[i]);
		   
		} 
		if(valMaterias==true && valInsti==true && valIni==true  && valFini==true && valModalidad==true && valAtesta==true)
		{
			goNextTab('tab_5','tab_6',5,6);
		}		
			
		}
		
		 
     
		
    });
	///// pasar de tab 6 a 7
	$('#btn-next-6').on('click', function () 
	{
		var talleres = document.getElementsByName("nombreTaller[]");
		if(talleres.length==0)
		{
			//si no tiene experiencias laborales, se va de un solo a la otra pestaña
			goNextTab('tab_6','tab_7',6,7);
		}
		
		 $("[name^=nombreTaller]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar el nombre del taller impartido"
                }
            });
        });
		$("[name^=totalHoras]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar en número, el total de horas del taller impartidas"
                }
            });
        });
		$("[name^=periodoTallerInicial]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione fecha de  inicio de la impartición del  taller"
                }
            });
        });
		$("[name^=periodoTallerFinal]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione fecha de  fin de la impartición del  taller"
                }
            });
        });
		$("[name^=institucionTaller]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Seleccione la institución en la cual / para la cual impartió el taller"
                }
            });
        });
		$("[name^=modalidadTaller]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe indicar la modalidad del taller"
                }
            });
        })
		$("[name^=atestadoTaller]").each(function () {
            $(this).rules("add", {
                required: true,           
                messages: 
				{
                     required:"Debe adjuntar el atestado o comprobante de impartición del taller"
                }
            });
        })
		var validator = $("#formularioAplicacion").validate();
		var listaTalleres = document.getElementsByName("nombreTaller[]");
		var horasTalleres = document.getElementsByName("totalHoras[]");
		var pInicial = document.getElementsByName("periodoTallerInicial[]");
		var pFinal = document.getElementsByName("periodoTallerFinal[]");
		var institucion = document.getElementsByName("institucionTaller[]");
		var modalidad = document.getElementsByName("modalidadTaller[]");
		var atestado = document.getElementsByName("atestadoTaller[]");
		var longi=listaTalleres.length;
		for(var i=0;i<longi;i++)
		{						
		   var valTalleres=validator.element(listaTalleres[i]);
		   var valHoras=validator.element(horasTalleres[i]);
		   var valIni=validator.element(pInicial[i]);
		   var valFini=validator.element(pFinal[i]);
		   var valInsti=validator.element(institucion[i]);
		   var valModalidad=validator.element(modalidad[i]);
		   var valAtesta=validator.element(atestado[i]);
		   
		} 
		if(valTalleres==true && valHoras==true && valIni==true  && valFini==true && valInsti==true && valModalidad==true && valAtesta==true)
		{
			goNextTab('tab_6','tab_7',6,7);
		}    	
    }); //fin de btn next 6
	///// pasar de tab 7 a 8
	$('#btn-next-7').on('click', function () 
	{	
		//	en la tab 7, si no selecciono el checklist, ni habra existencia del element que contiene los datos, asi que solo si despliego los input, se pondrán.
		//asi q por eso en todos los casos, debo ver si no ha dejado vacio al meter el checkbox
		var validator = $("#formularioAplicacion").validate();
		//
			
		var programas=document.getElementById('metodologiaDiseño').checked
		var okProgramas=true;
		if(programas==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				console.log("ME METI A PROGRAMAS PORQUE ESTA CHEQUEADO EL CHECKBOIX");
				$("[name^=metodologiaProgramas]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaProgramasAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});
			
			var metodoProgramas = document.getElementsByName("metodologiaProgramas[]");
			var ficheroProgramas = document.getElementsByName("metodologiaProgramasAtestado[]");
			for(var i=0;i<metodoProgramas.length;i++)
			{						
			   var valProgramas=validator.element(metodoProgramas[i]);
			   var valFicheroProgramas=validator.element(ficheroProgramas[i]);
			   
			}

			if(valProgramas==true && valFicheroProgramas==true && metodoProgramas.length>=3)
			{
				okProgramas=true;
			}
			else 
			{
				okProgramas=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \"Diseño de programas y/o proyectos de formación y/o capacitación (curricular)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if programas
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var disenocartas=document.getElementById('disenoCartas').checked
		var okdisenocartas=true;
		if(disenocartas==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				//console.log("ME METIO A DISEÑO CARTA" +disenocartas.length);
				$("[name^=metodologiaDisenoCartas]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaDisenoCartasAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});			
			var metodoCartas = document.getElementsByName("metodologiaDisenoCartas[]");
			var ficheroCartas = document.getElementsByName("metodologiaDisenoCartasAtestado[]");
			for(var i=0;i<metodoCartas.length;i++)
			{						
			   var valCartas=validator.element(metodoCartas[i]);
			   var valFicheroCartas=validator.element(ficheroCartas[i]);
			   
			}
			if(valCartas==true && valFicheroCartas==true && metodoCartas.length>=3)
			{
				okdisenocartas=true;
			}
			else 
			{
				okdisenocartas=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \"Diseño de cartas didácticas (diseños instruccionales)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if programas
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var evaluacion=document.getElementById('evaluacionProcesos').checked
		    var okevaluacion=true;
		if(evaluacion==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
				$("[name^=metodologiaEvaluacion]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaEvaluacionAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});			
			var metodoEvaluacion = document.getElementsByName("metodologiaEvaluacion[]");
			var ficheroEvaluacion = document.getElementsByName("metodologiaEvaluacionAtestado[]");
			for(var i=0;i<metodoEvaluacion.length;i++)
			{						
			   var valEvaluacion=validator.element(metodoEvaluacion[i]);
			   var valFicheroEvaluacion=validator.element(ficheroEvaluacion[i]);
			   
			}
			if(valEvaluacion==true && valFicheroEvaluacion==true && metodoEvaluacion.length>=3)
			{
				okevaluacion=true;
			}
			else 
			{
				okevaluacion=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \"Evaluación de procesos de formación (en cuales procesos, metodología)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if programas
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var facilitacion=document.getElementById('facilitacionTalleres').checked;
		    var okfacilitacion=true;
		if(facilitacion==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
				$("[name^=metodologiaFacilitacion]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaFacilitacionAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});			
			var metodoFacilitacion = document.getElementsByName("metodologiaFacilitacion[]");
			var ficheroFacilitacion = document.getElementsByName("metodologiaFacilitacionAtestado[]");
			for(var i=0;i<metodoFacilitacion.length;i++)
			{						
			   var valFacilitacion=validator.element(metodoFacilitacion[i]);
			   var valFicheroFacilitacion=validator.element(ficheroFacilitacion[i]);
			   
			}
			if(valFacilitacion==true && valFicheroFacilitacion==true && metodoFacilitacion.length>=3)
			{
				okfacilitacion=true;
			}
			else 
			{
				okfacilitacion=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \"Facilitación de talleres o cursos de formación o capacitación (cuáles)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if programas
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var participativa=document.getElementById('metodologiasParticipativas').checked;
		    var okparticipativa=true;
		if(participativa==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
				$("[name^=metodologiaParticipativa]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaParticipativaAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});			
			var metodoParticipativa = document.getElementsByName("metodologiaParticipativa[]");
			var ficheroParticipativa = document.getElementsByName("metodologiaParticipativaAtestado[]");
			for(var i=0;i<metodoParticipativa.length;i++)
			{						
			   var valParticipativa=validator.element(metodoParticipativa[i]);
			   var valFicheroParticipativa=validator.element(ficheroParticipativa[i]);
			   
			}
			if(valParticipativa==true && valFicheroParticipativa==true && metodoParticipativa.length>=3)
			{
				okparticipativa=true;
			}
			else 
			{
				okparticipativa=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \"Metodologías participativas (cuáles)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if participativa
			var elaboracion=document.getElementById('elaboracionMaterial').checked;
		    var okelaboracion=true;
		if(elaboracion==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
				$("[name^=metodologiaElaboracion]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaElaboracionAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});			
			var metodoElaboracion = document.getElementsByName("metodologiaElaboracion[]");
			var ficheroElaboracion = document.getElementsByName("metodologiaElaboracionAtestado[]");
			for(var i=0;i<metodoElaboracion.length;i++)
			{						
			   var valElaboracion=validator.element(metodoElaboracion[i]);
			   var valFicheroElaboracion=validator.element(ficheroElaboracion[i]);
			   
			}
			if(valElaboracion==true && valFicheroElaboracion==true && metodoElaboracion.length>=3)
			{
				okelaboracion=true;
			}
			else 
			{
				okelaboracion=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \" Elaboración de material de apoyo (manuales, guías, lecturas. Cuáles)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if elaboracion
		var linea=document.getElementById('disenador').checked;
		    var oklinea=true;
		if(linea==true)
			{
				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
				$("[name^=metodologiaLinea]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe indicar la experiencia en la metodología indicada"
					}
				});
			});
			$("[name^=metodologiaLineaAtestado]").each(function () {
				$(this).rules("add", {
					required: true,           
					messages: 
					{
						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
					}
				});
			});			
			var metodoLinea = document.getElementsByName("metodologiaLinea[]");
			var ficheroLinea = document.getElementsByName("metodologiaLineaAtestado[]");
			for(var i=0;i<metodoLinea.length;i++)
			{						
			   var valLinea=validator.element(metodoLinea[i]);
			   var valFicheroLinea=validator.element(ficheroLinea[i]);
			   
			}
			if(valLinea==true && valFicheroLinea==true && metodoLinea.length>=3)
			{
				oklinea=true;
			}
			else 
			{
				oklinea=false;
				alert("No se puede avanzar: debe agregar al menos 3 atestados y descripciones para la metodología \" Metodologías en línea (si es diseñador instruccional, contenidista o solo tutor)\" \n Utilice el botón \"Añadir una nueva experiencia en esta metodología\" para que aparezcan nuevas filas donde podrá añadir la descripción y atestado.");
			}							
		} //fin de if elaboracion
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/* console.log("A comprobar Programas: "+okProgramas);
		console.log("A comprobar disenocartas: "+okdisenocartas);
		console.log("A comprobar okevaluacion: "+okevaluacion);
		console.log("A comprobar okfacilitacion: "+okfacilitacion);
		console.log("A comprobar okparticipativa: "+okparticipativa);
		console.log("A comprobar okelaboracion: "+okelaboracion);
		console.log("A comprobar oklinea: "+oklinea); */
		if(okProgramas==true && okdisenocartas==true && okevaluacion==true && okfacilitacion==true && okparticipativa==true && okelaboracion==true && oklinea==true)
		{
			goNextTab('tab_7','tab_8',7,8);
		}    		
    });//fin de pasar a 7 a 8
	///// pasar de tab 8 a 9
	$('#btn-next-8').on('click', function () 
	{		
		//si ha puesto sabe idiomas, no debe dejar vacío
		var okIdiomas=false;
		var validator = $("#formularioAplicacion").validate();
		valor=($('input[name=manejoIngles]:checked').val());
			if(valor.localeCompare("si")==0)
			{
				$("[name^=idiomas]").each(function () 
				{
					$(this).rules("add", 
					{
						required: true,           
						messages: 
						{
							 required:"Debe indicar el nombre del idioma que conoce"
						}
					});
				});
				
				var idiomas = document.getElementsByName("idiomas[]");
				for(var i=0;i<idiomas.length;i++)
				{						
				   var valIdiomas=validator.element(idiomas[i]);
				   //var valFicheroEvaluacion=validator.element(ficheroEvaluacion[i]);
				   
				}
				if(valIdiomas==true)
				{
					okIdiomas=true;
				}
				
				if(okIdiomas==true)
				{
					goNextTab('tab_8','tab_9',8,9);  
				}
			}
			else
			{
				goNextTab('tab_8','tab_9',8,9);  
			}
					
    });




/////// ----------------------------------  APARTADO DE BORRADO DE FORMULARIO -------------------------------------------------
$('#form_reset1').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab1()
  }, 1);
});
$('#form_reset2').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab2()
  }, 1);
});
$('#form_reset3').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab3()
  }, 1);
});
$('#form_reset4').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab4()
  }, 1);
});
$('#form_reset5').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab5()
  }, 1);
});
$('#form_reset6').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab6()
  }, 1);
});

$('#form_reset7').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab7()
  }, 1);
});

$('#form_reset8').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab8()
  }, 1);
});

$('#form_reset9').click(function(e) {
  setTimeout(function() 
  {

    limpiarTab9()
  }, 1);
});
///
function limpiarTab1() 
{
	document.getElementById("nombre").value = '';
	var val=document.getElementById("paisResidencia").value='';
	var val=document.getElementById("tipoDocumento").value='';
	var val=document.getElementById("numeroDocumento").value='';
	var val=document.getElementById("nit").value='';
	var val=document.getElementById("edad").value='';
	var val=document.getElementById("telefonoCompleto").value='';
	//var val=document.getElementById("finTelefono").value='';
	var val=document.getElementById("correo").value='';
}
function limpiarTab2() 
{
	var a = document.getElementsByName("cargo[]");
	var b = document.getElementsByName("funciones[]");
	var c = document.getElementsByName("institucion[]");
	var d = document.getElementsByName("periodoInicial[]");
	var e = document.getElementsByName("periodoFinal[]");
	var longi=a.length; 
   for(var i=0;i<longi;i++)
   {						
	   a[i].value="";
	   b[i].value="";
	   c[i].value="";
	   d[i].value="";
	   e[i].value="";
	   
	} 
}
function limpiarTab3() 
{	
	//OJO: LA TAB 3 ESTÁ EN TRES BLOQUES "SEPÀRADOS"
	var a = document.getElementsByName("tituloGrado[]");
	var b = document.getElementsByName("anoGrado[]");
	var c = document.getElementsByName("institucionGrado[]");
	var nombreA = document.getElementsByName("nombreTituloGrado[]");
	var atestadoA = document.getElementsByName("atestadoGrado[]");
	var longi=a.length; 
   for(var i=0;i<longi;i++)
   {						
	   $(a[i]).prop('selectedIndex',0); //resetea un select co valor default
	   $(b[i]).prop('selectedIndex',0);
	   nombreA[i].value="";
	   atestadoA[i].value="";
	   c[i].value="";	   
	}
	/////////////////////////////////////////////////////////
	var d = document.getElementsByName("tituloPosgrado[]");
	var e = document.getElementsByName("anoPosgrado[]");
	var f = document.getElementsByName("institucionPosgrado[]");
	var nombreB = document.getElementsByName("nombreTituloPosGrado[]");
	var atestadoB = document.getElementsByName("atestadoPosgrado[]");
	var longi2=d.length; 
	   for(var i=0;i<longi2;i++)
	   {						
		   $(d[i]).prop('selectedIndex',0); //resetea un select co valor default
		   $(e[i]).prop('selectedIndex',0);
		   f[i].value="";
		   nombreB[i].value="";
		   atestadoB[i].value="";		   
		}
	////////////////////////////////////////////////////////
	var g = document.getElementsByName("tituloOtros[]");
	var h = document.getElementsByName("anoOtros[]");
	var i = document.getElementsByName("institucionOtros[]");
	var nombreC = document.getElementsByName("nombreTituloOtros[]");
	var atestadoC = document.getElementsByName("atestadoOtros[]");
	var longi3=g.length; 
	   for(var cont=0;cont<longi3;cont++)
	   {						
		   $(g[cont]).prop('selectedIndex',0); //resetea un select co valor default
		   $(h[cont]).prop('selectedIndex',0);
		   i[cont].value="";
		   nombreC[cont].value="";
		   atestadoC[cont].value="";		   
		}  
}
function limpiarTab4() 
{
	
  



}
function limpiarTab5() 
{
	var a = document.getElementsByName("materia[]");
	var b = document.getElementsByName("institucionImpartida[]");
	var c = document.getElementsByName("periodoMateriaInicial[]");
	var d = document.getElementsByName("periodoMateriaFinal[]");
	var e = document.getElementsByName("modalidad[]");
	var f = document.getElementsByName("atestadoMateria[]");
	var longi=a.length; 
   for(var i=0;i<longi;i++)
   {						
	   a[i].value="";
	   b[i].value="";
	  c[i].value="";
	   d[i].value="";
	   $(e[i]).prop('selectedIndex',0);
	   f[i].value="";
	   
	} 
}
function limpiarTab6() 
{
	var a = document.getElementsByName("nombreTaller[]");
	var b = document.getElementsByName("totalHoras[]");
	var c = document.getElementsByName("institucionTaller[]");
	var d = document.getElementsByName("atestadoTaller[]");
	var fechaInicial = document.getElementsByName("periodoTallerInicial[]");
	var fechaFinal = document.getElementsByName("periodoTallerFinal[]");
	var modalidad = document.getElementsByName("modalidadTaller[]");
	//console.log("fecha Inicial select: "+fechaInicial.length);
			 var longi=a.length; 
				//console.log("longi: "+longi);
			   for(var i=0;i<longi;i++)
			   {						
				   a[i].value="";
				   b[i].value="";
				   c[i].value="";
				   d[i].value="";
				    fechaInicial[i].value="";
				    fechaFinal[i].value="";
				   $(modalidad[i]).prop('selectedIndex',0);				   
				}
}
function limpiarTab7() 
{
	//algoritmo de limpieza de la tab 7: deselecciono el checbox, limpio textareas y oculto div
	//uso la funcion click PORQUE DISPARA EL EVENTO CHANGE, que uso en un método más arriba
  //donde detecto, que si estoy ocultando el div, borro ese contenido y lo oculto.
  //https://stackoverflow.com/questions/8206565/check-uncheck-checkbox-with-javascript
  //PERO. si no he tocado (el textbox no esta seleccionado) y ejecuta Limpiar tab 7, activaré esos checkbox y no lo quiero.
  //para ello compruebo si no está checked
  //console.log("pene: "+document.getElementById('metodologiaDiseño').checked);
  if(document.getElementById('metodologiaDiseño').checked)
  {
	document.getElementById('metodologiaDiseño').click(); 
  } 
  if(document.getElementById('disenoCartas').checked)
  {
	  document.getElementById('disenoCartas').click();
  }
  if(document.getElementById('evaluacionProcesos').checked)
  {
	  document.getElementById('evaluacionProcesos').click();
  }
  if(document.getElementById('facilitacionTalleres').checked)
  {
	  document.getElementById('facilitacionTalleres').click();
  }
  if(document.getElementById('metodologiasParticipativas').checked)
  {
	  document.getElementById('metodologiasParticipativas').click();
  }
  if(document.getElementById('elaboracionMaterial').checked)
  {
	  document.getElementById('elaboracionMaterial').click();
  }
  if(document.getElementById('disenador').checked)
  {
	  document.getElementById('disenador').click(); 
  }  
}

function limpiarTab8() 
{
	var a = document.getElementsByName("idiomas[]");
		var b = document.getElementsByName("hablados[]");
		var c = document.getElementsByName("escuchados[]");
		var d = document.getElementsByName("escritos[]");
		var longi=a.length; 
				console.log("longi: "+longi);
			   for(var i=0;i<longi;i++)
			   {						
				   a[i].value="";
				   b[i].value="";
				   c[i].value="";
				   d[i].value="";								   
				}		
	valor=($('input[name=manejoIngles]:checked').val());
	//console.log("valor de ingles ANTES de limpieza: "+valor);
	if(valor.localeCompare("si")==0)
	{
		//quito el no y pongo el si
		document.getElementById("ingles1").checked = false;	
		document.getElementById("ingles2").checked = true;
		
	}
	valorPrezi=($('input[name=manejoPrezi]:checked').val());
	//console.log("valor de prezi ANTES de limpieza: "+valorPrezi);
	if(valorPrezi.localeCompare("si")==0)
	{
		//quito el no y pongo el si
		document.getElementById("prezi1").checked = false;	
		document.getElementById("prezi2").checked = true;	
	}	

	document.getElementById("informacionRelevante").value = '';
}

function limpiarTab9() 
{
	document.getElementById("cartaMotivacion").value = '';
	document.getElementById("referenciasPersonales").value = '';
}
//FRESA AL PASTEL: con esto evito que se pueda navegar por el formulario clickeando cabeceras de TABS
$('[id^="nav-tab-"]').click(function(e){
  if (e.originalEvent !== undefined)
  {
    return false;
  }
});
