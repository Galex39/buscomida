//Variables raras
let aux = 0; //Esta es para validar si los inputs del hacer publicación estan todos llenos
let cont = 0; //Para marcar las claves de el json que verifica las publicaciones

$(document).ready(index);

function index(){
	$("#imagenPub").change(function(event) {
	    filePreview(this);
	});
	setInterval(showNotification,5000);
	getPubli(1);
	showNotification();
	$('#btn-publicar').click(insertPubli);
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
	      url: url+"index.php/Personas/Ver_pub_acept/Ver_pub_acept/newPub",
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
	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub_acept/Ver_pub_acept/getPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {
	  			'pagina' : pagina,
	  			'usuario' : usuario 
			},
	  success: function(data) {
	    $("#panel_pub").empty();
	    $.each(data.pub, function () {
    		let html = `<div class="card border-left-info cardPub"
							style="width: 20rem; text-align: center; float: left; margin: 10px">
							<div class="imgUser">
								<img class="img-fluid impub imgTarget" src="`+url+`assets/files/publicaciones/`+this.imagen+`"
									alt="...">
							</div>
							<div class="card-body">
								<input type="hidden" value="`+this.publicacion+`">
								<h5 class="card-title text-uppercase">`+this.titulo+`</h5>
								<p class="card-text">`+this.nombres+` `+this.apellidos+`</p>
							</div>
							<div class="card-footer">
								<button class="btn btn-info ver_infoPub" data-toggle="modal" data-target="#moreInformationPub">Ver detalles</button>
							</div>	
					</div>`;
	    	
			$("#panel_pub").append(html);     
	    });
	    $('.pagination').html(data.pag)
	    $('.ver_infoPub').click(seeMorePubInfo);
	  },
	  error: function(data) {
	  	console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function seeMorePubInfo(){
	indicador = $(event.target);
	let id_pub = indicador.parent().parent().children('.card-body').children('input[type="hidden"]').val();
	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub_acept/Ver_pub_acept/moreInformatonPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_pub': id_pub},
	  success: function(data) {
	    $('#id_pub').val(data.id_publicaciones);
	    $("#pubImageView").attr('src', url+'assets/files/publicaciones/'+data.imagen);
	    $('#titleModalPub').text(data.titulo);
	    $('#descriptionPub').text(data.descripcion);
	    $('#fechaInicioPub').text('Fecha inicio: '+data.fecha);
	    $('#horaCadPub').text('Tiempo disponible: '+data.tiempo_disponible+' Minutos');
	    $('#nameDonantePub').text('Donante: '+data.nombres+' '+data.apellidos);
	    $('#telefonoUsPub').text('Telefono: '+data.telefono);
	    $('#direccionPub').text('Dirección: '+data.direccion);
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function showNotification(){
	let usuario = $('#id_us').val();

	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub_acept/Ver_pub_acept/showNotifications',
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
				  CancelButtonText: 'No lo he recibido'
				}).then((result) => {
				  	if (result.value) {
					    jQuery.ajax({
						      url: url+'index.php/Personas/Ver_pub/Ver_pub/validarRecibido',
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
						       	getPubli(1);
						      },
						      error: function(data) {
						        console.log('Error en el servidor');
						       	console.log(data);
						      }
					    });
					    
				  	}else{
				  		jQuery.ajax({
						      url: url+'index.php/Personas/Ver_pub/Ver_pub/validarNrRecibido',
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
	console.log(event.target);
	let remitente = indicador.children('.contInfo').children('.remitente').val();
	let publicacion = indicador.children('.contInfo').children('.pubic_not').val();

	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub_acept/Ver_pub_acept/getInfoUs',
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
	  url: url+'index.php/Personas/Ver_pub_acept/Ver_pub_acept/notEntregado',
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

