$(document).ready(index);

let municipio = $('#id_mun').val();

function index (){
	$("#profileImage").change(function(event) {
	    filePreview(this); 
	});

	$("#imagenPub").change(function(event) {
	    filePreviewPub(this);
	});
	showNotification();
	setInterval(showNotification,5000);
	$('#btn-publicar').click(insertPubli);
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

function filePreviewPub(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#preImagePub").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function updateBData(){
	$("#waitEditarDataUser").css('display', 'inline-block');

	jQuery.ajax({
	  url: url+'index.php/Perfil/Perfil/updateBData',
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
	  url: url+'index.php/Perfil/Perfil/updatePass',
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
	  url: url+'index.php/Perfil/Perfil/changeImage',
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

function insertPubli(){
	aux = 0
	$(".formPubInput").each(function(){
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
	if (aux == 5){
		datos_formulario = new FormData( $("#newpub_form")[0] );
		$("#waitInsertPub").css('display', 'inline-block');
	    $.ajax({
	      url: url+"index.php/Perfil/Perfil/newPub",
	      type: 'POST', 
	      dataType: 'json',
	      data: datos_formulario,
	      contentType: false,
	      processData: false,
	    })
	    .done(function(data) {
	        $("#waitInsertPub").css('display', 'none');
	        if (data.estado == 'Success') {
	        	Swal.fire({
				  position: 'center',
				  icon: 'success',
				  title: 'Alimento publicado',
				  showConfirmButton: false,
				  timer: 1500
				})
	        	$('#newpub_form')[0].reset();
	        	$('.newpub').modal('hide');
	        }

	        if (data.estado == 'ErrorUpload') {
	        	Swal.fire({
				  position: 'center',
				  icon: 'error',
				  title: data.error,
				  showConfirmButton: false,
				  timer: 3000
				})
	        }   
	    })
	    .fail(function(data) {
	      console.log("Error Servidor:");
	      console.log(data);
	    });
	}
}

function showNotification(){
	let usuario = $('#id_us').val();
	jQuery.ajax({
	  url: url+'index.php/Perfil/Perfil/showNotifications',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_us': usuario},
	  success: function(data) {
	   let datos = data;
	   $('#num_not').text(datos.num_not);
	   $("#panel-not").empty();
	   $.each(datos.info, function () {
	   		let row = this;
	   		let html = "";
	   		if (this.tipo == 'aceptacion') {
	   			html = ` <button type="button" onClick="showInfoRemitente(this)" class="dropdown-item d-flex align-items-center confirmar_noti">
				            <div class="mr-3">
				              <div class="icon-circle bg-primary">
				                <i class="fas fa-file-alt text-white"></i>
				              </div>
				            </div>
				            <div class="contInfo">
				              <input type="hidden" class="remitente" value="`+row.remitente+`">
				              <input type="hidden" class="pubic_not" value="`+row.publicacion+`">
				              <div class="small text-gray-500">`+row.fecha+`</div>
				              <span class="font-weight-bold">`+row.mensaje+`</span>
				            </div>
				        </button>`
	   		}
	    	
			if (this.tipo == 'cancelacion') {
				html = `<button type="button" class="dropdown-item d-flex align-items-center">
		                  <div class="mr-3">
		                    <div class="icon-circle bg-warning">
		                      <i class="fas fa-exclamation-triangle text-white"></i>
		                    </div>
		                  </div>
		                  <div>
		                    <div class="small text-gray-500">`+row.fecha+`</div>
				            <span class="font-weight-bold">`+row.mensaje+`</span>
		                  </div>
			            </button>`
			}

			if (this.tipo == 'verificacion') {
				Swal.fire({
				  title: 'Verificacion',
				  text: row.mensaje,
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Si lo he recibido!',
				}).then((result) => {
				  	if (result.value) {
					    jQuery.ajax({
						      url: url+'index.php/Personas/Loby/Loby/validarRecibido',
						      type: 'POST',
						      dataType: 'json',
						      data: {
						      	'accion' : 'recibido',
						      	'usuario' : usuario,
						      	'publicacion' : row.publicacion
						      },
						      success: function(data) {
						       	console.log('Success');
						       	console.log(data);
						      },
						      error: function(data) {
						        console.log('Error en el servidor');
						       	console.log(data);
						      }
					    });
					    
				  	}else{
				  		jQuery.ajax({
						      url: url+'index.php/Perfil/Perfil/validarNRecibido',
						      type: 'POST',
						      dataType: 'json',
						      data: {
						      	'accion' : 'nrecibido',
						      	'usuario' : usuario,
						      	'publicacion' : row.publicacion,
						      	'receptor' : row.remitente,
						      	'notificacion_act' : row.id_noti 
						      },
						      success: function(data) {
						       	console.log('Success');
						       	console.log(data);
						       	getPubli(1);
						      },
						      error: function(data) {
						        console.log('Error en el servidor');
						       	console.log(data);
						      }
					    });
				  	}
				})
			}	        
			$("#panel-not").append(html);     
	   });
	   
	   
	  },
	  error: function(data) {
	    console.log('Error');
	   console.log(data);
	  }
	});	
}

function showInfoRemitente(elemento){
	indicador = $(elemento);
	let remitente = indicador.children('.contInfo').children('.remitente').val();
	let publicacion = indicador.children('.contInfo').children('.pubic_not').val();

	jQuery.ajax({
	  url: url+'index.php/Perfil/Perfil/getInfoUs',
	  type: 'POST',
	  dataType: 'json',
	  data: {'remitente': remitente},
	  success: function(data) {
	  	console.log('Entregado swal');
	    $('#confEnt').modal('show');
	    let html = `<div class="col-md-6">
			            <div class="form-group" style="text-align: center">
			              <img class="img-fluid" id="imageViewAcept" src="`+url+`assets/files/usuarios/`+data.foto+`">
			            </div>
			        </div>
	    			<div class="col-md-6">
	    				<ul class="list-inline">
			                <li><b>Nombres: </b></li>
			                <p>`+data.nombres+`</p>
			                <li><b>Apellidos: </b></li>
			                <p>`+data.apellidos+`</p>
			                <li><b>Telefono: </b></li>
			                <p>`+data.telefono+`</p>
			                <li><b>Email: </b></li>
			                <p>`+data.email+`</p>
			            </ul>
	    			</div>`;
		$('#putInfo').html(html);
		$('#btn-entregado').one('click', function(event) {
		    entregado(remitente,publicacion);
	    });           
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function entregado(remitente,publicacion){
	let us = $('#id_us').val();
	let receptor = remitente;
	let pubicacion = publicacion;

	jQuery.ajax({
	  url: url+'index.php/Perfil/Perfil/notEntregado',
	  type: 'POST',
	  dataType: 'json',
	  data: {
	  	'remitente': us,
	  	'receptor' : receptor,
	  	'publicacion' : publicacion
	  },
	  success: function(data) {
	    console.log('Success entregado');
	    console.log(data);
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function getDepmun(){
	let mun = $('#id_mun').val();

	jQuery.ajax({
	  url: url+'index.php/Perfil/Perfil/getDepmun',
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
	  url: url+'index.php/Perfil/Perfil/getDepartamentos',
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
		  url: url+'index.php/Perfil/Perfil/getMunicipios',
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