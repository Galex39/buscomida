$(document).ready(index);

let municipio = $('#id_mun').val();

function index (){
	$("#profileImage").change(function(event) {
	    filePreview(this); 
	});
	
	$('#btn-edit-bdata').click(updateBData);
	$('#btn-upass').click(uptadePassword);
	$('#btn-cimage').click(changeImage);
	getDepmun();
	$('#departamento').change(function(){
		let id = $('#departamento').val();
		getMunicipios(id);
	});
}

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#previewImagenUser").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function updateBData(){
	$("#waitEditarDataUser").css('display', 'inline-block');

	jQuery.ajax({
	  url: url+'index.php/Admin/Perfil/Perfil/updateBData',
	  type: 'POST',
	  dataType: 'json',
	  data: $('#form-bdata').serialize(),
	  success: function(data) {
	    $("#waitEditarDataUser").css('display', 'none');
	    if (data.answer == 'success') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'Los datos se han guardado correctamente',
			  showConfirmButton: false,
			  timer: 2000
			})
	    }
	  },
	  error: function(data) {
	    console.log('Error en el servidor:');
	    console.log(data);
	    Swal.fire({
			  position: 'center',
			  icon: 'error',
			  title: 'Los datos se han guardado correctamente',
			  showConfirmButton: false,
			  timer: 2000
			})
	  }
	});	
}

function uptadePassword(){
	$("#waitEditarPassUser").css('display', 'inline-block');
	jQuery.ajax({
	  url: url+'index.php/Admin/Perfil/Perfil/updatePass',
	  type: 'POST',
	  dataType: 'json',
	  data: $('#form-uppass').serialize(),
	  success: function(data) {
	    $("#waitEditarPassUser").css('display', 'none');
	    if (data.answer == 'Success') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'Los datos se han guardado correctamente',
			  showConfirmButton: false,
			  timer: 2000
			})

			$('#form-uppass')[0].reset();
	    }

	    if (data.answer == 'ERROR') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'error',
			  title: 'Hubo un problema al actualizar los datos',
			  showConfirmButton: false,
			  timer: 2000
			})
	    }

	    if (data.answer == 'ERR_PWD') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'error',
			  title: 'Las contraseñas no coinciden',
			  showConfirmButton: false,
			  timer: 2000
			})
	    }

	    if (data.answer == 'ERR_PASS') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'error',
			  title: 'La contraseña ingresada no coinside con la de este usuario',
			  showConfirmButton: false,
			  timer: 2000
			})
	    }
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
    	Swal.fire({
		  position: 'center',
		  icon: 'error',
		  title: 'Hubo un error en el servidor',
		  showConfirmButton: false,
		  timer: 2000
		})
	  }
	});	
}

function changeImage(){
	let datos_formulario = new FormData( $("#form-cimage")[0]);
	$("#waitEditarFotoUser").css('display', 'inline-block');
	
	jQuery.ajax({
	  url: url+'index.php/Admin/Perfil/Perfil/changeImage',
	  type: 'POST',
	  dataType: 'json',
	  data: datos_formulario,
	  contentType: false,
      processData: false,
	  success: function(data) {
	    $("#waitEditarFotoUser").css('display', 'none');
	    let datos = data;

	    if (datos.estado == 'ErrorUpload'){
	    	Swal.fire({
			  position: 'center',
			  icon: 'warning',
			  title: datos.error,
			  showConfirmButton: false,
			  timer: 5000
			})
	    }

	    if (datos.estado == 'Success') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'Foto actualizada correctamente',
			  showConfirmButton: false,
			  timer: 5000
			})
	    }
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);

	    Swal.fire({
			  position: 'center',
			  icon: 'error',
			  title: 'Error en el servidor',
			  showConfirmButton: false,
			  timer: 2000
			})
	  }
	});	
}

function getDepmun(){
	let mun = $('#id_mun').val();

	jQuery.ajax({
	  url: url+'index.php/Admin/Perfil/Perfil/getDepmun',
	  type: 'POST',
	  dataType: 'json',
	  data: {'municipio': mun},
	  success: function(data) {
	    let departamento = data.departamento_id;
	    getDepartamentos(departamento);
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function getDepartamentos(id){
	let dep = id;
	jQuery.ajax({
	  url: url+'index.php/Admin/Perfil/Perfil/getDepartamentos',
	  type: 'POST',
	  dataType: 'json',
	  success: function(data) {
	    $.each(data, function() {
	    	let html='';
	    	if (this.id == dep) {
	    		html = `<option value="`+this.id+`" selected>`+this.nombre+`</option>`;
	    	}else{
	    		html = `<option value="`+this.id+`">`+this.nombre+`</option>`;
	    	}
		  	$('#departamento').append(html);
		});
		id = $("#departamento").val();
		getMunicipios(id);
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function getMunicipios(id){
	jQuery.ajax({
		  url: url+'index.php/Admin/Perfil/Perfil/getMunicipios',
		  type: 'POST',
		  dataType: 'json',
		  data: {'id_dep': id},
		  success: function(data) {
		  	$('#municipio').empty();
		  	$.each(data, function() {
		  		let html = '';
		  		if (this.id == municipio) {
		  			html = `<option value="`+this.id+`" selected>`+this.nombre+`</option>`;
		  		}else{
		  			html = `<option value="`+this.id+`">`+this.nombre+`</option>`;
		  		}
			  	$('#municipio').append(html);
			});

		  },
		  error: function(data) {
		    console.log('Error en el servidor');
		    console.log(data);
		  }
	});
}