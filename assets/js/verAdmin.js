$(document).ready(index);

let tablaUsuarios;

function index(){
	listar();
	getDepartamentos();
	$('#departamento').change(function() {
		let id_dep = $('#departamento').val();
		console.log(id_dep);
		getMunicipios(id_dep);
	});

	$('#btn-registrarAdmin').click(newAdmin);
}


function listar(){
	var spanish = {
	    			"sProcessing":     "Procesando...",
	                "sLengthMenu":     "Mostrar _MENU_ registros",
	                "sZeroRecords":    "No se encontraron resultados",
	                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
	                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	                "sInfoPostFix":    "",
	                "sSearch":         "Buscar:",
	                "sUrl":            "",
	                "sInfoThousands":  ",",
	                "sLoadingRecords": "Cargando...",
	                "oPaginate": {
	                    "sFirst":    "Primero",
	                    "sLast":     "Último",
	                    "sNext":     "Siguiente",
	                    "sPrevious": "Anterior"
	                },
	                "oAria": {
	                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	                },
	                "buttons": {
	                    "copy": "Copiar",
	                    "colvis": "Visibilidad"
	                }
				}
	tablaUsuarios = $('#tableAdmin').DataTable({  
	    "ajax":{            
	        "url": "http://buscomida.info/buscomida/index.php/Admin/VerAdmin/VerAdmin/getAdministradores", 
	        "method": 'POST', //usamos el metodo POST
	        "dataSrc":""
	    },
	    "columns":[
	        {"data": "nombres"},
	        {"data": "apellidos"},
	        {"data": "telefono"},
	        {"data": "email"},
	        {"data": "municipio"},
	        {"data": "usuario"},
	        {"data": "estado"},
	        
	    ],
	    "language": spanish
	});		
}

function getDepartamentos(){
	jQuery.ajax({
	  url: url+'index.php/Admin/VerAdmin/VerAdmin/getDepartamentos',
	  type: 'POST',
	  dataType: 'json',
	  success: function(data) {
	    $.each(data, function() {
		  	let html = `<option value="`+this.id+`">`+this.nombre+`</option>`;
		  	$('#departamento').append(html);
		});
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function getMunicipios(id){
	jQuery.ajax({
		  url: url+'index.php/Admin/VerAdmin/VerAdmin/getMunicipios',
		  type: 'POST',
		  dataType: 'json',
		  data: {'id_dep': id},
		  success: function(data) {
		  	$('#municipio').empty();
		  	$('#municipio').append('<option value="">Seleccione un municipio</option>');
		  	$.each(data, function() {
			  	let html = `<option value="`+this.id+`">`+this.nombre+`</option>`;
			  	$('#municipio').append(html);
			});

		  },
		  error: function(data) {
		    console.log('Error en el servidor')
		    console.log(data);
		  }
	});
}

function newAdmin(){
	aux = 0;
	$(".input-admin").each(function(){
	   	if ($(this).val() == "" || $(this).val() == null) {
			Swal.fire({
			  position: 'center',
			  icon: 'warning',
			  title: 'Todos los campos deben estar llenos',
			  showConfirmButton: false,
			  timer: 3000
			})
			return false;
		}else{
			aux++;
		}
	});
	if (aux == 9) {
		var combo = document.getElementById("municipio");
		var selected = combo.options[combo.selectedIndex].text;
		jQuery.ajax({
			url: url+'index.php/Admin/VerAdmin/VerAdmin/newAdmin',
			type: 'POST',
			dataType: 'json',
			data:  $('#formAdmin').serialize(),
			success: function(data) {
				if (data.state == 'SUCCESS') {
					tablaUsuarios.rows.add( [ {
					        "nombres": $('#name').val(),
					        "apellidos": $('#last_name').val(),
					        "telefono": $('#cel_number').val() ,
					        "email": $('#email').val(),
					        "municipio": selected,
					        "usuario": $('#user_name').val(),
					        "estado": "activo"
					    }]).draw();
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Usuario registrado',
						showConfirmButton: false,
						timer: 3000
					});
					$('#formAdmin')[0].reset();
					$('.newAdmin').modal('hide');
				}
			  	if (data.state == 'ERR_US'){
			  		Swal.fire({
						position: 'center',
						icon: 'warning',
						title: 'El usuario ya se encuentra en uso',
						showConfirmButton: false,
						timer: 3000
					})
			  	}
			  	if (data.state == 'ERR_PASS'){
			  		Swal.fire({
						position: 'center',
						icon: 'warning',
						title: 'Las contraseñas no coinciden, rectifiquelas por favor',
						showConfirmButton: false,
						timer: 3000
					})
			  	}
			  },
			error: function(data) {
			    console.log('Error en el servidor');
			   	console.log(data);
			}
		});	
	}		
}

