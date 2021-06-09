$(document).ready(index);

let fecha = new Date();
let year_act = fecha.getFullYear();

function index(){
	chartBar(year_act);
	chartPie(year_act);
	chartLine(year_act);
	$('#btn-year').click(function(event) {
		let getYerar = $('#year').val();
		chartBar(getYerar);
	});

	$('#btn-year1').click(function(event) {
		let getYerar = $('#year1').val();
		chartPie(getYerar);
	});

	$('#btn-year2').click(function(event) {
		let getYerar = $('#year2').val();
		chartLine(getYerar);
	});
}

function chartBar(year){
	$('#year').attr("placeholder", year_act);
	jQuery.ajax({
	  url: url+'index.php/Admin/Estadisticas/Estadisticas/getPubxM',
	  type: 'POST',
	  dataType: 'json',
	  data: {'year': year},
	  success: function(data) {
	  		var valores = eval(data);
	  		$('#chartPxM').empty();
			let ctx= document.getElementById("chartPxM").getContext("2d");
		    let myChart= new Chart(ctx,{
		        type:"bar",
		        data:{
		            labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		            datasets:[{
		                label:'Num datos',
		                data: [valores[0],valores[1],valores[2],valores[3],valores[4],valores[5],valores[6],valores[7],valores[8],valores[9],valores[10],valores[11]],
		                backgroundColor:[
		                    'rgb(66, 134, 244)',
		                    'rgb(74, 135, 72)',
		                    'rgb(229, 89, 50)',
		                    'rgb(57, 177, 180)',
		                    'rgb(57, 180, 139)',
		                    'rgb(156, 180, 57)',
		                    'rgb(124, 57, 180)',
		                    'rgb(194, 160, 223)',
		                    'rgb(149, 183, 234)',
		                    'rgb(127, 194, 157)',
		                    'rgb(77, 146, 194)',
		                    'rgb(184, 79, 105)', 
		                ]
		            }]
		        },
		        options: {
			    maintainAspectRatio: false,
			    layout: {
			      padding: {
			        left: 10,
			        right: 25,
			        top: 25,
			        bottom: 0
			      }
			    },
			    scales: {
			      xAxes: [{
			        gridLines: {
			          display: false,
			          drawBorder: false
			        },
			        ticks: {
			          maxTicksLimit: 6
			        }
			      }],
			      yAxes: [{
			        ticks: {
			          maxTicksLimit: 5,
			          padding: 10,
			          beginAtZero: true
			        },
			        gridLines: {
			          color: "rgb(234, 236, 244)",
			          zeroLineColor: "rgb(234, 236, 244)",
			          drawBorder: false,
			          borderDash: [2],
			          zeroLineBorderDash: [2]
			        }
			      }],
			    },
			    legend: {
			      display: false
			    },
			    tooltips: {
			      backgroundColor: "rgb(255,255,255)",
			      bodyFontColor: "#858796",
			      titleMarginBottom: 10,
			      titleFontColor: '#6e707e',
			      titleFontSize: 14,
			      borderColor: '#dddfeb',
			      borderWidth: 1,
			      xPadding: 15,
			      yPadding: 15,
			      displayColors: false,
			      intersect: false,
			      mode: 'index',
			      caretPadding: 10,
			    }
			  }
		    }); 	
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});
}

function chartPie(year){
	$('#year1').attr("placeholder", year_act);
	jQuery.ajax({
	  url: url+'index.php/Admin/Estadisticas/Estadisticas/roundChart',
	  type: 'POST',
	  dataType: 'json',
	  data: {'year': year},
	  success: function(data) {
	  		var valores = eval(data);
	  		$('#myPieChart').empty();
			let ctx= document.getElementById("myPieChart").getContext("2d");
		    let myChart= new Chart(ctx,{
		        type:"pie",
		        data:{
		            labels:['Publicaciones','Aceptadas','No Aceptadas'],
		            datasets:[{
		                label:'Cantidad',
		                data: [valores[0],valores[1],(valores[0]-valores[1])],
		                backgroundColor:[
		                    'rgb(66, 134, 244)',
		                    'rgb(74, 135, 72)',
		                    'rgb(229, 89, 50)', 
		                ]
		            }]
		        },
		        options: {
				    maintainAspectRatio: false,
				    tooltips: {
				      backgroundColor: "rgb(255,255,255)",
				      bodyFontColor: "#858796",
				      borderColor: '#dddfeb',
				      borderWidth: 1,
				      xPadding: 15,
				      yPadding: 15,
				      displayColors: false,
				      caretPadding: 10,
				    },
				    legend: {
				      display: false
				    },
				    cutoutPercentage: 80,
				},
		    }); 	
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});
}

function chartLine(year){
	$('#year2').attr("placeholder", year_act);
	jQuery.ajax({
	  url: url+'index.php/Admin/Estadisticas/Estadisticas/linearChart',
	  type: 'POST',
	  dataType: 'json',
	  data: {'year': year},
	  success: function(data) {
	  		console.log(data);
	  		var valores = eval(data);
	  		$('#chartDcxM').empty();
			let ctx= document.getElementById("chartDcxM").getContext("2d");
		    let myChart= new Chart(ctx,{
		        type:"line",
		        data:{
		            labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		            datasets:[{
		                label:'Num datos',
		                data: [valores[0],valores[1],valores[2],valores[3],valores[4],valores[5],valores[6],valores[7],valores[8],valores[9],valores[10],valores[11]],
		                backgroundColor:[
		                    'rgb(66, 134, 244)',
		                    'rgb(74, 135, 72)',
		                    'rgb(229, 89, 50)',
		                    'rgb(57, 177, 180)',
		                    'rgb(57, 180, 139)',
		                    'rgb(156, 180, 57)',
		                    'rgb(124, 57, 180)',
		                    'rgb(194, 160, 223)',
		                    'rgb(149, 183, 234)',
		                    'rgb(127, 194, 157)',
		                    'rgb(77, 146, 194)',
		                    'rgb(184, 79, 105)', 
		                ]
		            }]
		        },
		        options: {
			    maintainAspectRatio: false,
			    layout: {
			      padding: {
			        left: 10,
			        right: 25,
			        top: 25,
			        bottom: 0
			      }
			    },
			    scales: {
			      xAxes: [{
			        gridLines: {
			          display: false,
			          drawBorder: false
			        },
			        ticks: {
			          maxTicksLimit: 6
			        }
			      }],
			      yAxes: [{
			        ticks: {
			          maxTicksLimit: 5,
			          padding: 10,
			          beginAtZero: true
			        },
			        gridLines: {
			          color: "rgb(234, 236, 244)",
			          zeroLineColor: "rgb(234, 236, 244)",
			          drawBorder: false,
			          borderDash: [2],
			          zeroLineBorderDash: [2]
			        }
			      }],
			    },
			    legend: {
			      display: false
			    },
			    tooltips: {
			      backgroundColor: "rgb(255,255,255)",
			      bodyFontColor: "#858796",
			      titleMarginBottom: 10,
			      titleFontColor: '#6e707e',
			      titleFontSize: 14,
			      borderColor: '#dddfeb',
			      borderWidth: 1,
			      xPadding: 15,
			      yPadding: 15,
			      displayColors: false,
			      intersect: false,
			      mode: 'index',
			      caretPadding: 10,
			    }
			  }
		    }); 	
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});
}