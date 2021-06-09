$(document).ready(index);

function index(){
	getDepartamentos();

	$('#departamento').change(function() {
		let id_dep = $('#departamento').val();
		getMunicipios(id_dep);	
	});
}

function getDepartamentos(){
	jQuery.ajax({
	  url: url+'index.php/Register/Register/getDepartamentos',
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
		  url: url+'index.php/Register/Register/getMunicipios',
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