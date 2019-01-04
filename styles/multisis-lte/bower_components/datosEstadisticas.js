/*

	JOSÉ MARIO LOPEZ LEIVA
	2018
	marioleiva2011@gmail.com
	ESTADISTICAS GESTION DOCENTES ENAFOP
*/
///INICIO GRAFICOS UNO: COMPARATIVA
var income = document.getElementById("grafico1");
if(income!==null)
{
	var income = document.getElementById("grafico1").getContext("2d");
	var numeroAprobados = $("#numeroAprobados").val();
var numeroPostulantes = $("#numeroPostulantes").val();

var mayor1 = $("#mayor1").val();
var barData = 
			{
                labels : ["Aprobados", "Postulados"],
                datasets : [
                    {
                        fillColor : "#48A497",
                        strokeColor : "#48A4D1",
                        data : [numeroAprobados,numeroPostulantes]
                    }
				
                ],
				
            }
            //get bar chart canvas
            
            //draw bar chart
			var config= {
				scaleOverride : true,
				scaleSteps : 1,
				scaleStepWidth : mayor1,
				scaleStartValue : 0
	
				 //legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
					
				} //fin de config			
    var myChart= new Chart(income).Bar(barData,config);
    myChart.datasets[0].bars[1].fillColor = "rgba(229,12,12,0.7)";
myChart.datasets[0].bars[1].strokeColor = "rgba(229,12,12,1)";
myChart.update();
}

///FIN GRAFICOS UNO: COMPARATIVA



//////////// GRAFICO DOS: GENERO///////////////////////////////////////////
var generoPostulantes = document.getElementById("generoPostulantes");
if(generoPostulantes!==null)
{
	var generoPostulantes = document.getElementById("generoPostulantes").getContext("2d");
	var numGeneroMasculinosPostulantes = $("#numGeneroMasculinosPostulantes").val();
var numGeneroFemeninosPostulantes = $("#numGeneroFemeninosPostulantes").val();
var numGeneroOtrosPostulantes = $("#numGeneroOtrosPostulantes").val();


var numGeneroMasculinosAprobados = $("#numGeneroMasculinosAprobados").val();
var numGeneroFemeninosAprobados = $("#numGeneroFemeninosAprobados").val();
var numGeneroOtrosAprobados = $("#numGeneroOtrosAprobados").val();


var numGeneroMasculinosTotal = $("#numGeneroMasculinosTotal").val();
var numGeneroFemeninosTotal = $("#numGeneroFemeninosTotal").val();
var numGeneroOtrosTotal = $("#numGeneroOtrosTotal").val();
var generoAprobadosData = [
				{
					value: numGeneroFemeninosAprobados,
					color:"#ff99ff",
					highlight: "#FF5A5E",
					label: "Femenino"
				},
				{
					value: numGeneroMasculinosAprobados,
					color: "#00ffff",
					highlight: "#526868",
					label: "Masculino"
				},
				{
					value: numGeneroOtrosAprobados,
					color: "#ffff66",
					highlight: "#37c9ff",
					label: "Otro"
				}
			

			];
/* 			window.onload = function(){
				var ctx = document.getElementById("pastel1").getContext("2d");
				window.myPie = new Chart(ctx).Pie(pieData);
			}; */
var generoPostulantesData = [
				{
					value: numGeneroFemeninosPostulantes,
					color:"#ff99ff",
					highlight: "#FF5A5E",
					label: "Femenino"
				},
				{
					value: numGeneroMasculinosPostulantes,
					color: "#00ffff",
					highlight: "#526868",
					label: "Masculino"
				},
				{
					value: numGeneroOtrosPostulantes,
					color: "#ffff66",
					highlight: "#37c9ff",
					label: "Otro"
				}
			];
			
var generoTotalData = [
				{
					value: numGeneroFemeninosTotal,
					color:"#ff99ff",
					highlight: "#FF5A5E",
					label: "Femenino"
				},
				{
					value: numGeneroMasculinosTotal,
					color: "#00ffff",
					highlight: "#526868",
					label: "Masculino"
				},
				{
					value: numGeneroOtrosTotal,
					color: "#ffff66",
					highlight: "#37c9ff",
					label: "Otro"
				}
			];

			window.onload = function(){
				var generoPostulantes = document.getElementById("generoPostulantes").getContext("2d");
				window.myPie = new Chart(generoPostulantes).Pie(generoPostulantesData);
				///// genero aprobados
				var generoAprobados = document.getElementById("generoAprobados").getContext("2d");
				window.myPie = new Chart(generoAprobados).Pie(generoAprobadosData);
				///genero total
				var generoTtal = document.getElementById("generoTotal").getContext("2d");
				window.myPie = new Chart(generoTtal).Pie(generoTotalData);
			};
}

//////////// FIN GRAFICO DOS: GENERO///////////////////////////////////////////



/////////////////////////////////////////////////// GRAFICOS EDAD
 var edad = document.getElementById("graficoEdad");
 if(edad!==null)
 {
	 var edad = document.getElementById("graficoEdad").getContext("2d");
	 var edadMediaAprobados = $("#edadMediaAprobados").val();
var edadMediaPostulados = $("#edadMediaPostulados").val();
var edadMediaTotal = $("#edadMediaTotal").val();
var mayorEdad=Math.max(edadMediaAprobados,edadMediaPostulados,edadMediaTotal);
var datosEdad = 
			{
                 labels : ["Postulantes","Aprobados","Media total"],
                datasets : [
                    {
                        fillColor : "#66ccff",
                        strokeColor : "#ff99cc",
						label: 'Edad (promedio)',
                        data : [edadMediaPostulados,edadMediaAprobados,edadMediaTotal]
                    }
				
                ]
				
            }
            //get bar chart canvas
            var edad = document.getElementById("graficoEdad").getContext("2d");
            //draw bar chart
			var config2= {
				scaleOverride : true,
				scaleSteps : 1,
				scaleStepWidth : mayorEdad,
				scaleStartValue : 0
	
				 //legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
					
				} //fin de config			
    var myChartEdad= new Chart(edad).Bar(datosEdad,config2);
    myChartEdad.datasets[0].bars[1].fillColor = "#66ccff";
myChartEdad.datasets[0].bars[1].strokeColor = "#ff99cc";
myChartEdad.update();
	 
 }

////////////// FIN GRAFICOS EDAD



/////////////////////////////////////////////////// GRAFICOS PROFESIONES
var profesiones = document.getElementById("graficoProfesiones");
if(profesiones!==null)
{
	var profesiones = document.getElementById("graficoProfesiones").getContext("2d");
// 	var bachilleresAprobados = $("#bachilleresAprobados").val();
// var bachilleresPostulados = $("#bachilleresPostulados").val();
var LicenciadosAprobados = $("#LicenciadosAprobados").val();
var LicenciadosPostulados = $("#LicenciadosPostulados").val();
var IngenierosAprobados = $("#IngenierosAprobados").val();
var IngenierosPostulados = $("#IngenierosPostulados").val();
var MasteresAprobados = $("#MasteresAprobados").val();
var MasteresPostulados = $("#MasteresPostulados").val();
var DoctoresAprobados = $("#DoctoresAprobados").val();
var DoctoresPostulados = $("#DoctoresPostulados").val();
var OtrosAprobados = $("#OtrosAprobados").val();
var OtrosPostulados = $("#OtrosPostulados").val();

var diplomadoPostulados = $("#diplomadoPostulados").val();
var diplomadoAprobados = $("#diplomadoAprobados").val();

var cursosAprobados = $("#cursosAprobados").val();
var cursosPostulados = $("#cursosPostulados").val();


var mayorProfesion=Math.max(cursosAprobados,cursosPostulados,diplomadoPostulados,diplomadoAprobados,LicenciadosAprobados,LicenciadosPostulados,IngenierosAprobados,IngenierosPostulados,MasteresAprobados,MasteresPostulados,DoctoresAprobados,DoctoresPostulados,OtrosAprobados,OtrosPostulados);
var datosProfesiones = 
			{
                 labels : ["Licenciatura","Ingeniería","Maestría","Doctorado","Cursos especializados","Diplomado","Otro"],
                datasets : [
                    {
                        fillColor : "#0000ff",
                        strokeColor : "#ff99cc",
						label: 'Aprobados',
                        data : [LicenciadosAprobados,IngenierosAprobados,MasteresAprobados,DoctoresAprobados,cursosAprobados,diplomadoAprobados,OtrosAprobados]
                    },
					{
                        fillColor : "#ffff00",
                        strokeColor : "#ff99cc",
						label: 'Postulantes',
                        data : [LicenciadosPostulados,IngenierosPostulados,MasteresPostulados,DoctoresPostulados,cursosPostulados,diplomadoPostulados,OtrosPostulados]
                    }				
                ]				
            }
            //get bar chart canvas
            var profesiones = document.getElementById("graficoProfesiones").getContext("2d");
            //draw bar chart
			var config3= {
				scaleOverride : true,
				scaleSteps : 1,
				scaleStepWidth : mayorProfesion,
				scaleStartValue : 0
	
				 //legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
					
				} //fin de config			
    var myChartProfesiones= new Chart(profesiones).Bar(datosProfesiones,config3);
	
	
}

	
/////////////////// GRAFICO TEMAS
var temas = document.getElementById("graficoTemas");
if(temas!==null)
{
	var temas = document.getElementById("graficoTemas").getContext("2d");
	
var aprobadosGerencia = $("#aprobadosGerencia").val();
var postuladosGerencia = $("#postuladosGerencia").val();
var aprobadosPlanificacion = $("#aprobadosPlanificacion").val();
var postuladosPlanificacion = $("#postuladosPlanificacion").val();
var aprobadosTalento = $("#aprobadosTalento").val();
var postuladosTalento = $("#postuladosTalento").val();
var aprobadosGobierno = $("#aprobadosGobierno").val();
var postuladosGobierno = $("#postuladosGobierno").val();
var aprobadosEtica = $("#aprobadosEtica").val();
var postuladosEtica = $("#postuladosEtica").val();
var aprobadosElectronico = $("#aprobadosElectronico").val();
var postuladosElectronico = $("#postuladosElectronico").val();
var aprobadosAbierto = $("#aprobadosAbierto").val();
var postuladosAbierto = $("#postuladosAbierto").val();
var aprobadosCalidad = $("#aprobadosCalidad").val();
var postuladosCalidad = $("#postuladosCalidad").val();
var aprobadosEnfoque = $("#aprobadosEnfoque").val();
var postuladosEnfoque = $("#postuladosEnfoque").val();
var aprobadosRelaciones = $("#aprobadosRelaciones").val();
var postuladosRelaciones = $("#postuladosRelaciones").val();
var aprobadosCapacitacion = $("#aprobadosCapacitacion").val();
var postuladosCapacitacion = $("#postuladosCapacitacion").val();

//var mayorProfesion=Math.max(bachilleresAprobados,bachilleresPostulados,LicenciadosAprobados,LicenciadosPostulados,IngenierosAprobados,IngenierosPostulados,MasteresAprobados,MasteresPostulados,DoctoresAprobados,DoctoresPostulados,OtrosAprobados,OtrosPostulados);
var datosTemas = 
			{
                 labels : ["Gerencia pública","Planificación para el desarrollo","Gestión del talento humano por competencias en el sector público","Gobierno y territorio","Ética y transparencia en la gestión pública","Gobierno electrónico","Gobierno abierto y participación ciudadana","Gestión de Calidad en el sector público","Enfoque de derechos en la gestión pública","Relaciones laborales en el sector público","Gestión de capacitación en el sector público"],
                datasets : [
                    {
                        fillColor : "#0000ff",
                        strokeColor : "#ff99cc",
						label: 'Aprobados',
                        data : [aprobadosGerencia,aprobadosPlanificacion,aprobadosTalento,aprobadosGobierno,aprobadosEtica,aprobadosElectronico,aprobadosAbierto,aprobadosCalidad,aprobadosEnfoque,aprobadosRelaciones,aprobadosCapacitacion]
                    },
					{
                        fillColor : "#ffff00",
                        strokeColor : "#ff99cc",
						label: 'Postulantes',
                         data : [postuladosGerencia,postuladosPlanificacion,postuladosTalento,postuladosGobierno,postuladosEtica,postuladosElectronico,postuladosAbierto,postuladosCalidad,postuladosEnfoque,postuladosRelaciones,postuladosCapacitacion]
                    }				
                ]				
            }
            //get bar chart canvas
            var temas = document.getElementById("graficoTemas").getContext("2d");
            //draw bar chart
			var config4= {
				scaleOverride : true,
				scaleSteps : 1,
				scaleStepWidth : 5,
				scaleStartValue : 0
	
				 //legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
					
				} //fin de config			
    var myChartTemas= new Chart(temas).Bar(datosTemas,config4);

}
/////////////////// FIN TEMAS /////////////////////

//GRAFICA PRACTICAN DOCENCIA
var graficaDocencia = document.getElementById("graficaDocencia");
if(graficaDocencia!==null)
{
	var graficaDocencia = document.getElementById("graficaDocencia").getContext("2d");
	//

	var numDocenciaAprobados = $("#numDocenciaAprobados").val();
var numDocenciaPostulados = $("#numDocenciaPostulados").val();

var numDocenciaTotal = $("#numDocenciaTotal").val();

var docenciaData = [
				{
					value: numDocenciaAprobados,
					color:"#00cc66",
					highlight: "#FF5A5E",
					label: "Aprobados"
				},
				{
					value: numDocenciaPostulados,
					color: "#cc00cc",
					highlight: "#526868",
					label: "Postulados"
				}

			

			];
			window.onload = function(){
				window.myPie = new Chart(graficaDocencia).Pie(docenciaData);

			};
}
//////////////////////////////////////// 
var metodologias = document.getElementById("graficoMetodologias");
if(metodologias!==null)
{
	var metodologias = document.getElementById("graficoMetodologias").getContext("2d");
	
var aprobadosProgramas = $("#aprobadosProgramas").val();
var postuladosProgramas = $("#postuladosProgramas").val();
var aprobadosCartas = $("#aprobadosCartas").val();
var postuladosCartas = $("#postuladosCartas").val();
var aprobadosEvaluacion = $("#aprobadosEvaluacion").val();
var postuladosEvaluacion = $("#postuladosEvaluacion").val();
var aprobadosFacilitacion = $("#aprobadosFacilitacion").val();
var postuladosFacilitacion = $("#postuladosFacilitacion").val();
var aprobadosParticipativa = $("#aprobadosParticipativa").val();
var postuladosParticipativa = $("#postuladosParticipativa").val();
var aprobadosElaboracion = $("#aprobadosElaboracion").val();
var postuladosElaboracion = $("#postuladosElaboracion").val();
var aprobadosAbierto = $("#aprobadosAbierto").val();
var aprobadosLinea = $("#aprobadosLinea").val();
var postuladosLinea = $("#postuladosLinea").val();


var mayorMetodologia=Math.max(aprobadosProgramas,
postuladosProgramas,
aprobadosCartas,
postuladosCartas,
aprobadosEvaluacion,
postuladosEvaluacion,
aprobadosFacilitacion,
postuladosFacilitacion,
aprobadosParticipativa,
postuladosParticipativa,
aprobadosElaboracion,
postuladosElaboracion,
aprobadosLinea,
postuladosLinea);
var datosMetodologias = 
			{
                 labels : ["Diseño de programas y/o proyectos de formación y/o capacitación","Diseño de cartas didácticas",
                 "Evaluación de procesos de formación","Facilitación de talleres o cursos de formación o capacitación",
                 "Metodologías participativas","Elaboración de material de apoyo","Metodologías en línea"],
                datasets : [
                    {
                        fillColor : "#0000ff",
                        strokeColor : "#ff99cc",
						label: 'Aprobados',
                        data : [aprobadosProgramas,aprobadosCartas,aprobadosEvaluacion,aprobadosFacilitacion,aprobadosParticipativa,aprobadosElaboracion,aprobadosAbierto,aprobadosLinea]
                    },
					{
                        fillColor : "#ffff00",
                        strokeColor : "#ff99cc",
						label: 'Postulantes',
                         data : [postuladosProgramas,postuladosCartas,postuladosEvaluacion,postuladosFacilitacion,postuladosParticipativa,postuladosElaboracion,postuladosAbierto,postuladosLinea]
                    }				
                ]				
            }
            //get bar chart canvas
            var metodologias = document.getElementById("graficoMetodologias").getContext("2d");
            //draw bar chart
			var config5= {
				scaleOverride : true,
				scaleSteps : 1,
				scaleStepWidth : mayorMetodologia,
				scaleStartValue : 0
	
				 //legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
					
				} //fin de config			
    var myChartMetodologias= new Chart(metodologias).Bar(datosMetodologias,config5);

}
/// FIN METODOLOGIAS

//////////////// INICIO EXTRANJEROS
var extranjeros = document.getElementById("PiePostulantes");
if(extranjeros!==null)
{
var postulantesExt = $('#PiePostulantes').get(0).getContext('2d')
var aprobadosExt = $('#PieAprobados').get(0).getContext('2d')
///

var postulantesNacionales = $("#postulantesNacionales").val();
console.log("postulantesNacionales "+postulantesNacionales);
var postulantesExtranjeros = $("#postulantesExtranjeros").val();
console.log("postulantesExtranjeros "+postulantesExtranjeros);
var aprobadosNacionales = $("#aprobadosNacionales").val();
console.log("aprobadosNacionales "+aprobadosNacionales);
var aprobadosExtranjeros = $("#aprobadosExtranjeros").val();
//var totalExtranjeros = $('#totalExtranjeros').get(0).getContext('2d')
    var pieChart1       = new Chart(postulantesExt);
	var pieChart2       = new Chart(aprobadosExt);
	//var pieChart3       = new Chart(totalExtranjeros);
	
    var PieDataPostulantes        = [
      {
        value    : postulantesNacionales,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Nacionales'
      },
      {
        value    : postulantesExtranjeros,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Extranjeros'
      }

    ]
	
		
    var PieDataAprobados        = [
      {
        value    : aprobadosNacionales,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Nacionales'
      },
      {
        value    : aprobadosExtranjeros,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Extranjeros'
      }

    ]	
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 34,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart1.Doughnut(PieDataPostulantes, pieOptions)
	pieChart2.Doughnut(PieDataAprobados, pieOptions)
	//pieChart3.Doughnut(PieData, pieOptions)

}
