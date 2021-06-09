//Variables raras
let aux = 0; //Esta es para validar si los inputs del hacer publicación estan todos llenos
let cont = 0; //Para marcar las claves de el json que verifica las publicaciones

$(document).ready(index);

function index(){
	$("#imagenPub").change(function(event) {
	    filePreview(this);
	});
	$("#UpimagenPub").change(function(event) {
	    filePreviewUp(this);
	});
	$("#RepimagenPub").change(function(event) {
	    filePreviewRep(this);
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

function filePreviewUp(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#preUpImagePub").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function filePreviewRep(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#preRepImagePub").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function insertPubli(){
	aux = 0
	$(".formPubInput1").each(function(){
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
	      url: url+"index.php/Personas/Ver_pub/Ver_pub/newPub",
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
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/getPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {
	  			'pagina' : pagina,
	  			'usuario' : usuario 
			},
	  success: function(data) {
	    $("#panel_pub").empty();
	    $.each(data.pub, function () {
	    	let row = this;
	    	let html = "";

	    	if (this.estado == 'activo') {
	    		html = `<div class="card border-left-info cardPub"style="width: 20rem; text-align: center; float: left; margin: 10px">
								<div class="imgUser">
									<img class="img-fluid impub imgTarget" src="`+url+`assets/files/publicaciones/`+row.imagen+`"
										alt="...">
								</div>
								<div class="card-body">
									<input type="hidden" value="`+row.id_publicaciones+`">
									<h5 class="card-title text-uppercase">`+row.titulo+`</h5>
									<p class="card-text">`+row.nombres+` `+row.apellidos+`</p>
									
								</div>
								<div class="card-footer">
									<button class="btn btn-info cancelar">Cancelar</button>
									<button class="btn btn-info editar" data-toggle="modal" data-target=".updatePub">Editar</button>	
								</div>
						</div>`;
	    	}

	    	if (this.estado == 'inactivo') {
	    		html = `<div class="card border-left-info cardPub"
								style="width: 20rem; text-align: center; float: left; margin: 10px">
								<div class="imgUser">
									<img class="img-fluid impub imgTarget" src="`+url+`assets/files/publicaciones/`+row.imagen+`"
										alt="...">
								</div>
								<div class="card-body">
									<input type="hidden" value="`+row.id_publicaciones+`">
									<input type="hidden" value="`+row.estado+`" class="mpState">
									<h5 class="card-title text-uppercase">`+row.titulo+`</h5>
									<p class="card-text">`+row.nombres+` `+row.apellidos+`</p>
									
								</div>
								<div class="card-footer">
									<button class="btn btn-info repub" data-toggle="modal" data-target=".republicarPub">Re publicar</button>
								</div>
							</div>`;

	    	}
	    	
			$("#panel_pub").append(html);     
	    });
	    $('.pagination').html(data.pag)
	    $('.cancelar').click(cancelar);	
	    $(".editar").click(preEditar);
	    $('.repub').click(preRPub);
	  },
	  error: function(data) {
	  	console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function preEditar(){
	indicador = $(event.target);
	let id_pub = indicador.parent().parent().children('.card-body').children('input[type="hidden"]').val();
	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/moreInformatonPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_pub': id_pub},
	  success: function(data) {
	    $('#preUpImagePub').attr('src',url+'assets/files/publicaciones/'+data.imagen)
	    $('#Upid_pubF').val(data.id_publicaciones);
	    $('#Upid_pubIm').val(data.id_publicaciones);
	    $('#Uptitulo').val(data.titulo);
	    $('#Updescripcion').val(data.descripcion);
	    $('#Upubicacion').val(data.direccion);
	    $('#Uptiempo').val(data.tiempo_disponible);

	    $("#btn-updatePubInfo").off("click").on("click",function(){
	    	actualizar(indicador);
	    });
	    $("#btn-updatePubImage").off("click").on("click",function(){
	    	changeImage(indicador);
	    });
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function preRPub(){
	indicador = $(event.target);
	let id_pub = indicador.parent().parent().children('.card-body').children('input[type="hidden"]').val();
	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/moreInformatonPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_pub': id_pub},
	  success: function(data) {
	    $('#preRepImagePub').attr('src',url+'assets/files/publicaciones/'+data.imagen)
	    $('#Repid_pubF').val(data.id_publicaciones);
	    $('#Repid_pubIm').val(data.id_publicaciones);
	    $('#Reptitulo').val(data.titulo);
	    $('#Repdescripcion').val(data.descripcion);
	    $('#Repubicacion').val(data.direccion);
	    $('#Reptiempo').val(data.tiempo_disponible);

	    $("#btn-repdatePubInfo").off("click").on("click",function(){
	    	republicar(indicador);
	    });
	    $("#btn-repdatePubImage").off("click").on("click",function(){
	    	RepchangeImage(indicador);
	    });
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function actualizar(indicador){
	let card = indicador;
	aux = 0

	$(".UformPubInput").each(function(){
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

	if (aux == 4){
		let datos_formulario = $("#updatePub_form").serialize();
		$("#waitUpdatePub").css('display', 'inline-block');
	    $.ajax({
	      url: url+"index.php/Personas/Ver_pub/Ver_pub/updatePub",
	      type: 'POST', 
	      dataType: 'json',
	      data: datos_formulario,
	    })
	    .done(function(data) {
	        $("#waitInsertPub").css('display', 'none');
	        if (data.estado == 'Success') {
	        	Swal.fire({
				  position: 'center',
				  icon: 'success',
				  title: 'Publicación Actualizada',
				  showConfirmButton: false,
				  timer: 1500
				})
	        	getPubli(1);
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

function republicar(indicador){
	let card = indicador;
	aux = 0
	$(".RepformPubInput").each(function(){
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

	if (aux == 4 ){
		let datos_formulario = $("#repdatePub_form").serialize();
		$("#waitUpdatePub").css('display', 'inline-block');
	    $.ajax({
	      url: url+"index.php/Personas/Ver_pub/Ver_pub/rePublicar",
	      type: 'POST', 
	      dataType: 'json',
	      data: datos_formulario,
	    })
	    .done(function(data) {
	        $("#waitInsertPub").css('display', 'none');
	        if (data.estado == 'Success') {
	        	Swal.fire({
				  position: 'center',
				  icon: 'success',
				  title: 'La publicacion se ha republicado',
				  showConfirmButton: false,
				  timer: 1500
				})
	        	
	        	getPubli(1);
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

function cancelar(){
	indicador = $(event.target);
	let id_pub = indicador.parent().parent().children('.card-body').children('input[type="hidden"]').val();

	Swal.fire({
	  title: 'Estas seguro que quieres cancelarlo?',
	  text: "Si cancelas la publicación no podra ser vista por otros usuarios",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!!!',
	  cancelButtonText: 'No'
	}).then((result) => {
	  if (result.value) {
	  	jQuery.ajax({
		  url: url+"index.php/Personas/Ver_pub/Ver_pub/cancel_pub",
		  type: 'POST',
		  dataType: 'json',
		  data: {'publicacion': id_pub},
		  success: function(data) {
		    if (data.state == 'Success') {
		    	getPubli(1);
		    }
		  },
		  error: function(data) {
		    console.log('Error en el servidor');
		    console.log(data);
		  }
		});
	    Swal.fire(
	      'Cancelada!',
	      'La publicacion a sido cancelada',
	      'success'
	    )
	  }
	})	
}

function showNotification(){
	let usuario = $('#id_us').val();

	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/showNotifications',
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
						      url: url+'index.php/Personas/Ver_pub/Ver_pub/validarNRecibido',
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

function changeImage(indicador){
	let card = indicador;
	let datos_formulario = new FormData( $("#changeImage_form")[0]);

	console.log($('#UpimagenPub').val());
	$("#waitEditarFotoUser").css('display', 'inline-block');
	
	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/changeImagePub',
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
			  timer: 3000
			})
	    }

	    if (datos.estado == 'Success') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'Foto actualizada correctamente',
			  showConfirmButton: false,
			  timer: 1500
			})
			card.parent().parent().children().children('img').attr('src',url+'assets/files/publicaciones/'+datos.img);
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

function RepchangeImage(indicador){
	let card = indicador;
	let datos_formulario = new FormData( $("#repchangeImage_form")[0]);
	$("#waitEditarFotoUser").css('display', 'inline-block');
	
	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/changeImagePub',
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
			  timer: 3000
			})
	    }

	    if (datos.estado == 'Success') {
	    	Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'Foto actualizada correctamente',
			  showConfirmButton: false,
			  timer: 1500
			})
			card.parent().parent().children().children('img').attr('src',url+'assets/files/publicaciones/'+datos.img);
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

function showInfoRemitente(elemento){
	indicador = $(elemento);
	console.log(event.target);
	let remitente = indicador.children('.contInfo').children('.remitente').val();
	let publicacion = indicador.children('.contInfo').children('.pubic_not').val();

	jQuery.ajax({
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/getInfoUs',
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
	  url: url+'index.php/Personas/Ver_pub/Ver_pub/notEntregado',
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

