//Variables raras
let aux = 0; //Esta es para validar si los inputs del hacer publicación estan todos llenos
let cont = 0; //Para marcar las claves del json que verifica las publicaciones

$(document).ready(index);

function index(){
	validarUsuario();
	disabledPublic();
	$("#imagenPub").change(function(event) {
	    filePreview(this);
	});
	setInterval(validarPublicacion,5000);
	setInterval(showNotification,5000);
	getPubli(1);
	validationPanel();
	showNotification();
	$('#btn-publicar').click(insertPubli);
	$('#btn-recivir').click(aceptarPublicacion);
}

function validarUsuario(){
	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/validarUsuario',
	  type: 'POST',
	  dataType: 'json',
	  error: function(data) {
	     console.log('Error en el servidor');
	     console.log(data);
	  }
	});
	
}

function disabledPublic(){   
	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/disabledPublic',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_us': $('#id_us').val()},
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});
}

function validationPanel(){
	let usuario = $('#id_us').val();
	let estado = $('#state_us').val(); 

    if (estado == 'activo' && estado == 'limitado') {
    	getPubli(1);
    }

    if (estado == 'solicitando') {
    	jQuery.ajax({
    	  url: url+'index.php/Personas/Loby/Loby/getRequest',
    	  type: 'POST',
    	  dataType: 'json',
    	  data: {'id_us': usuario},

    	  success: function(data) {
    	  	let id_pub = data.publicacion;
    	   	console.log('success');
    	   	console.log(data);
    	   	showNewCard(id_pub);
    	  },
    	  error: function(data) {
    	    	console.log('Error en el servidor');
    	   		console.log(data);
    	  }
    	});	
    }	
}

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#preImagePub").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function insertPubli(){
	aux = 0;
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
	      url: url+"index.php/Personas/Loby/Loby/newPub",
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

function getPubli(pagina){
	let usuario = $('#id_us').val();
	let municipio = $('#id_mun').val();
	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/getPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {
	  			'pagina': pagina,
	  			'usuario' : usuario,
	  			'municipio' : municipio
			},
	  success: function(data) {
	    $("#panel_pub").empty();
	    $.each(data.pub, function () {
	    	let html = `<div class="card border-left-info cardPub" style="width: 20rem; text-align: center; float: left; margin: 10px">
								<div class="imgUser">
									<img class="img-fluid impub imgTarget" src="`+url+`assets/files/publicaciones/`+this.imagen+`"
										alt="...">
								</div>
								<div class="card-body">
									<input type="hidden" value="`+this.id_publicaciones+`">
									<h5 class="card-title text-uppercase">`+this.titulo+`</h5>
									<p class="card-text">`+this.nombres+` `+this.apellidos+`</p>
									
								</div>
								<div class="card-footer">
									<button class="btn btn-info verDetalle" data-toggle="modal" data-target="#moreInformationPub">Ver Detalles</button>
								</div>
						</div>`
			$("#panel_pub").append(html);     
	    });
	    $('.pagination').html(data.pag)	
	    $(".verDetalle").click(seeMorePubInfo);
	  },
	  error: function(data) {
	  	console.log('Error');
	    console.log(data);
	  }
	});	
}

function seeMorePubInfo(){
	indicador = $(event.target);
	let id_pub = indicador.parent().parent().children('.card-body').children('input[type="hidden"]').val();

	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/moreInformatonPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_pub': id_pub},
	  success: function(data) {
	    $('#id_pub').val(data.id_publicaciones);
	    $("#pubImageView").attr('src', url+'assets/files/publicaciones/'+data.imagen);
	    $('#titleModalPub').text(data.titulo);
	    $('#descriptionPub').text('Descripción: '+data.descripcion);
	    $('#fechaInicioPub').text('Fecha inicio: '+data.fecha);
	    $('#horaCadPub').text('Tiempo disponible: '+data.tiempo_disponible+' Minutos');
	    $('#nameDonantePub').text('Donante: '+data.nombres+' '+data.apellidos);
	    $('#telefonoUsPub').text('Telefono: '+data.telefono);
	    $('#direccionPub').text('Dirección: '+data.direccion);
	    //Reportar publicacion
		$('#btn-reportar').click(function(){
			reportar(id_pub);
		});
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function validarPublicacion(){
	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/validarPublicacion',
	  type: 'POST',
	  dataType: 'json',
	  success: function(data) {
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function aceptarPublicacion(){
	let estado = $('#state_us').val();

	if (estado != 'limitado') {
		let usuario = $('#id_us').val();
		let id_public = $('#id_pub').val();
		
		jQuery.ajax({
		  url: url+'index.php/Personas/Loby/Loby/aceptarPub',
		  type: 'POST',
		  dataType: 'json',
		  data: {
		  			'id_pub': id_public,
		  			'id_us': usuario
				},
		  success: function(data) {
		   if (data.state == 'Success') {
			   	Swal.fire({
				  title: 'Sulicitud aceptada!',
				  text: 'Diríjase a la direción que indica la publicación o comuniquese con el donador a el número que aparece en esta',
				  imageUrl: url+'assets/img/espera.png',
				  imageWidth: 400,
				  imageHeight: 400,
				  imageAlt: 'Custom image',
				})
			   	showNewCard(id_public);
		   }else{
		   		Swal.fire({
				  position: 'center',
				  icon: 'warning',
				  title: 'La publicación a sido aceptada por alguien más',
				  showConfirmButton: false,
				  timer: 2000
				})
		   }

		  },
		  error: function(data) {
		    console.log('Error');
		   	console.log(data);
		  }
		});	
	}else{
		Swal.fire({
		  position: 'center',
		  icon: 'warning',
		  title: 'Llegaste a el límite de publicaciones aceptadas por día, vuelve mañana para más',
		  showConfirmButton: false,
		  timer: 3000
		})
	}
}

function showNotification(){
	let usuario = $('#id_us').val();

	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/showNotifications',
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
				  title: 'Verificación',
				  text: row.mensaje,
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Si lo he recibido!',
				  cancelButtonText : 'No lo he recibido!'
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
						       	getPubli(1);
						      },
						      error: function(data) {
						        console.log('Error en el servidor');
						       	console.log(data);
						      }
					    });
					    
				  	}else{
				  		jQuery.ajax({
						      url: url+'index.php/Personas/Loby/Loby/validarNrecibido',
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

function showNewCard(id){
	let id_pub = id;
	jQuery.ajax({
		  url: url+'index.php/Personas/Loby/Loby/moreInformatonPub',
		  type: 'POST',
		  dataType: 'json',
		  data: {'id_pub': id_pub},
		  success: function(data) {
		    let html = 	`<div class="col-md-12" style="margin-top: 4%">
					      <div class="card card-info">
					        <div class="card-header">
					          <h3 class="card-title card-text-pipe text-uppercase">datos de la donacion que recibiras:</h3>
					        </div>
					        <!-- form start -->
					        <div class="card-body row">
					          <div class="col-md-7">
					            <div class="form-group" style="text-align: center">
					              <img class="img-fluid" id="imageViewAcept" src="`+url+`assets/files/publicaciones/`+data.imagen+`">
					            </div>
					          </div>
					          <div class="col-md-5">
					            <input type="hidden" id="id_pub_acept" value="`+data.id_publicaciones+`">
					            <ul class="list-inline">
					              <li><b>Titulo:</b></li>
					              <p>`+data.titulo+`</p>
					              <li><b>Fecha Inicio:</b></li>
					              <p>`+data.fecha+`</p>
					              <li><b>Tiempo disponible:</b></li>
					              <p>`+data.tiempo_disponible+`</p>
					              <li><b>Donante:</b></li>
					              <p>`+data.nombres+` `+data.apellidos+`</p>
					              <li><b>Telefono:</b></li>
					              <p>`+data.telefono+`</p>
					              <li><b>Has click en la dirección:</b></li>
					              <p><a style="text-decoration: none; color: grey" href="" data-toggle="modal" data-target=".ver_mapa">`+data.direccion+`</a></p>
					            </ul>
					          </div>
					        </div>
					        <div class="card-footer">
					          <div class="row justify-content-end"><button type="button" id="btn-cancelSol" class="btn btn-info">Cancelar</button></div>
					        </div>
					      </div>
					    </div>`
			$('#panel_pub').empty();
			$('#panel_pub').append(html);
			$('#btn-cancelSol').click(canselarSol);		    
		  },
		  error: function(data) {
		    console.log('Error en el servidor');
		    console.log(data);
		  }
	});
}

function canselarSol(){
	let usuario = $('#id_us').val();
	let publicacion = $('#id_pub_acept').val();

	jQuery.ajax({
		url: url+'index.php/Personas/Loby/Loby/cancelSol',
		type: 'POST',
		dataType: 'json',
		data: {
		  		'id_us': usuario,
		  		'id_pub': publicacion
			  },
		success: function(data) {
		   $("#panel_pub").empty();
		   getPubli(1);
		},
		error: function(data) {
		   console.log('Error en el servidor');
		   console.log(data);
		}
	});
}

function showInfoRemitente(elemento){
	indicador = $(elemento);
	let remitente = indicador.children('.contInfo').children('.remitente').val();
	let publicacion = indicador.children('.contInfo').children('.pubic_not').val();
    
	jQuery.ajax({
	  url: url+'index.php/Personas/Loby/Loby/getInfoUs',
	  type: 'POST',
	  dataType: 'json',
	  data: {'remitente': remitente},
	  success: function(data) {
	    $('#confEnt').modal('show');
	    let html = `<div class="col-md-6">
			            <div class="form-group" style="text-align: center">
			              <img class="img-fluid" id="imageViewAcept" src="`+url+`assets/files/usuarios/`+data.foto+`">
			            </div>
			        </div>
	    			<div class="col-md-4">
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
	  url: url+'index.php/Personas/Loby/Loby/notEntregado',
	  type: 'POST',
	  dataType: 'json',
	  data: {
	  	'remitente': us,
	  	'receptor' : receptor,
	  	'publicacion' : publicacion
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
}

function reportar(id_pub){
	let usuario = $('#id_us').val();
	Swal.fire({
	  title: 'Estas seguro?',
	  text: "Quieres reportar esta publicación!",
	  icon: 'warning', 
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Reportar!'
	}).then((result) => {
	  if (result.value) {
	  	jQuery.ajax({
	  	  url: url+'index.php/Personas/Loby/Loby/reportPublic',
	  	  type: 'POST',
	  	  dataType: 'json',
	  	  data: {
	  	  	'id_pub': id_pub,
	  	  	'id_us' : usuario
	  	  },
	  	  success: function(data) {
	  	  	if (data.answer == 'OK') {
	  	  		Swal.fire(
			      'Reportada!',
			      'La publicación a sido reportada como inapropiada.',
			      'success'
			    )
	  	  	}
	  	  	if (data.answer == 'ERROR') {
	  	  		Swal.fire(
			      'No se pudo hacer el reporte!',
			      'Usted ya ha reportado esta publicación',
			      'warning'
			    )
	  	  	}
	  	  },
	  	  error: function(data) {
	  	    console.log('Error en el servidor');
	  	    console.log(data);
	  	  }
	  	});
	  }
	})
}