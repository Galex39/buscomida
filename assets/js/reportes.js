$(document).ready(index);

function index(){
	getPubli(1);
}

function getPubli(pagina){
	jQuery.ajax({
	  url: url+'index.php/Admin/Denuncias/Denuncias/getPub',
	  type: 'POST',
	  dataType: 'json',
	  success: function(data) {
	    $("#panel_pub").empty();
	    $.each(data.pub, function () {
	    	let html = `<div class="card border-left-success cardPub" style="width: 20rem; text-align: center; float: left; margin: 10px">
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
									<button class="btn btn-success verDetalle" data-toggle="modal" data-target="#moreInformationPub">Ver Detalles</button>
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
	  url: url+'index.php/Admin/Denuncias/Denuncias/moreInformatonPub',
	  type: 'POST',
	  dataType: 'json',
	  data: {'id_pub': id_pub},
	  success: function(data) {
	  	console.log(data);
	    $('#id_pub').val(data.id_publicaciones);
	    $("#pubImageView").attr('src', url+'assets/files/publicaciones/'+data.imagen);
	    $('#titleModalPub').text(data.titulo);
	    $('#descriptionPub').text('Descripción: '+data.descripcion);
	    $('#fechaInicioPub').text('Fecha inicio: '+data.fecha);
	    $('#horaCadPub').text('Tiempo disponible: '+data.tiempo_disponible+' Minutos');
	    $('#nameDonantePub').text('Donante: '+data.nombres+' '+data.apellidos);
	    $('#telefonoUsPub').text('Telefono: '+data.telefono);
	    $('#direccionPub').text('Dirección: '+data.direccion);

	    //Eliminar publicacio
		$('#deletePub').click(function(){
			elimiarPub(indicador);
		});
		$('#quitarRep').click(function(){
			quitarReporte(indicador);
		});
	  },
	  error: function(data) {
	    console.log('Error en el servidor');
	    console.log(data);
	  }
	});	
}

function elimiarPub(puntero){
	let id_pub = $('#id_pub').val();

	Swal.fire({
	  title: 'Estas seguro?',
	  text: "Si lo haces no podras revertirlo!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, eliminalo!'
	}).then((result) => {
	  if (result.value) {
	  	jQuery.ajax({
		  url: url+'index.php/Admin/Denuncias/Denuncias/eliminarPub',
		  type: 'POST',
		  data: {'id': id_pub},
		  success: function(data) {
		  	console.log(data);
		  	puntero.parent().parent().remove();
		    Swal.fire(
		      'Eliminado!',
		      'La publicación a sido eliminada.',
		      'success'
		    )
		    $('#moreInformationPub').modal('hide');
		  },
		  error: function(data) {
		  	console.log('Error en el servidor');
		    console.log(data);
		  }
		});
	    
	  }
	})	
}

function quitarReporte(puntero){
	let id_pub = $('#id_pub').val();

	Swal.fire({
	  title: 'Estas seguro?',
	  text: "Si lo haces no podras revertirlo!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, anular!'
	}).then((result) => {
	  if (result.value) {
	  	jQuery.ajax({
		  url: url+'index.php/Admin/Denuncias/Denuncias/quitarReporte',
		  type: 'POST',
		  data: {'id': id_pub},
		  success: function(data) {
		  	console.log(data);
		  	puntero.parent().parent().remove();
		    Swal.fire(
		      'Reporte anulado!',
		      'La publicación a sido desmarcada como reportada',
		      'success'
		    )
		    $('#moreInformationPub').modal('hide');
		  },
		  error: function(data) {
		  	console.log('Error en el servidor');
		    console.log(data);
		  }
		});
	    
	  }
	})	
}
