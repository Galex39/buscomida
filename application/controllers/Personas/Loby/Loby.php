<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loby extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//Inicializacion de atributos
		//Se hace la validaciòn de permisos
		if (!empty($this->session->userdata('buscomida_session')) && $this->session->userdata('buscomida_session')['tipo']=='Persona') {
			return false;
		}else{
			redirect('Login/login');
		}
	}

	//Se carga la vista del loby
	public function index(){
		$view ['menu'] = $this->load->view('Menus/menu_persona','',True);
		$view ['nav'] = $this->load->view('Nav/nav','',True);
		$view ['footer'] = $this->load->view('Footer/footer','', True);
		$this->load->view('Persona/Loby/Loby',$view);
	}

	public function validarUsuario(){
		$this->load->model('usuarios/Usuarios_model');
		$codigo_us = $this->session->userdata('buscomida_session')['codigo_us'];
		date_default_timezone_set('America/Bogota'); 
		$fecha = strtotime($this->session->userdata('buscomida_session')['fecha_limitado']);
		$fecha_actual = strtotime(date("Y-m-d"));
		$data ['estado'] = 'activo';
		if ($fecha_actual > $fecha) {
			$this->Usuarios_model->updateTableUser($codigo_us,$data);
			
			//Se destruyen las sessiones existentes 
			$this->session->unset_userdata('buscomida_session');

			//Se reciven los datos de la sesion y se crea una nueva sesion
			$data_session = $this->Usuarios_model->selectUserById($codigo_us);
			$this->session->set_userdata('buscomida_session',$data_session);
		}

		$answer ['answer'] = 'Success';

		echo json_encode($answer);
	}

	public function disabledPublic(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$usuario = $this->input->post('id_us');
		$data = array(
			'estado' => 'inactivo'
		);
		if ($this->Publicaciones_model->disabledPublic($usuario,$data)) {
			$answer = array(
				'answer' => 'Success'
			);

			echo json_encode($answer);
		}
	}

	public function newPub(){
		$this->load->model('Publicaciones/Publicaciones_model');

		$fecha = new DateTime();
		$datename = $fecha->getTimestamp();
		
		$config['upload_path'] = 'assets/files/publicaciones/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size']  = '2048';
		$config['max_width']  = '5000';
		$config['max_height']  = '3000';
		$config['file_name'] = $datename."img.jpg";
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);

		$dataForm = array(
			'usuario' => $this->input->post('id_us'),
			'titulo' => $this->input->post('titulo'),
			'descripcion' => $this->input->post('descripcion'),
			'direccion' => $this->input->post('ubicacion'),
			'imagen' => $datename."img_thumb.jpg",
			'tiempo_disponible' => $this->input->post('tiempo'),
			'municipio' => $this->input->post('municipio')
		);
		$datos_json= array();

		if (!$this->upload->do_upload('imagen') ){
			$datos_json["estado"] = "ErrorUpload";
			$datos_json["error"] = $this->upload->display_errors();
		}else{

			$data = array('upload_data' => $this->upload->data());
       		foreach ($this->upload->data() as $item => $value){
                if($item=="file_path"){
                    $path=$value;
                }if($item=="file_name"){
                    $name=$value;
                }    
        	}
      		$this->resize($path,$name);

      		if ($this->Publicaciones_model->insertPub($dataForm)) {
				$datos_json["estado"] = "Success";
			}else{
				$datos_json["estado"] = "ErrorPublic";
				unlink('assets/files/publicaciones/'.$datename."img_thumb.jpg");
			}
		}
		echo json_encode($datos_json);
	}

	public function resize($path,$name){
		$this->load->model('usuarios/Usuarios_model');

         $config['image_library'] = 'gd2';
         $config['source_image'] =  $path.$name; // le decimos donde esta la imagen que acabamos de subir
         $config['new_image']=$path.$name; // las nuevas imágenes se guardan en la carpeta "thumbs"
         $config['create_thumb'] = TRUE;
         $config['maintain_ratio'] = False;
         $config['width'] = 1080;
         $config['height'] = 720;
       
        $this->load->library('image_lib', $config);
       
        if (!$this->image_lib->resize()){
            echo $this->image_lib->display_errors();
        }
       	
        $this->image_lib->resize();
        unlink('assets/files/publicaciones/'.$name);   
    }

	public function getPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		//Se trae la paginaAct en la que se encuentra el usuario
		$paginaAct = $this->input->post('pagina');
		$usuario = $this->input->post('usuario');
		$municipio = $this->input->post('municipio');
		$pubpaginaAct = 6; //Se pone la cantidad de registros por pagina
		$lista = '';
		$public = '';
		$limit = 0;
		//Se trae la cantidad de publicaciones que hay en la base de datos
		$numPub = $this->Publicaciones_model->getNumPublic($usuario,$municipio);

		//Vamos a mostrar las publicaciones de 6 en 6
		$paginas = ceil($numPub/$pubpaginaAct);

		if ($paginaAct > 1) {
			$lista = $lista.'<li class="page-item">
			                    <a class="page-link" href="javascript:getPubli('.($paginaAct-1).')" aria-disabled="true">Anterior</a>
			                  </li>';
		}

		for ($i=1; $i <= $paginas; $i++) { 
			if ($i == $paginaAct) {
				$lista = $lista.'<li class="page-item"><a class="active page-link" href="javascript:getPubli('.$i.')">'.$i.'</a></li>';
			}else{
				$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:getPubli('.$i.')">'.$i.'</a></li>';
			}
		}

		if ($paginaAct < $paginas) {
			$lista = $lista.'<li class="page-item">
			                    <a class="page-link" href="javascript:getPubli('.($paginaAct+1).')" aria-disabled="true">Siguiente</a>
			                 </li>';
		}

		if ($paginaAct <= 1) {
			$limit = 0;
		}else{
			$limit = $pubpaginaAct*($paginaAct-1);
		}


		$data ['pub'] = $this->Publicaciones_model->getPublic($limit,$pubpaginaAct,$usuario,$municipio);
		$data ['pag'] = $lista;

		echo json_encode($data);	 
	}

	public function moreInformatonPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$id = $this->input->post('id_pub');
		$data = $this->Publicaciones_model->getPublicInformation($id);
		echo json_encode($data);
	}

	public function validarPublicacion(){
		$aux = 0;
		$data  =  array();
		$dat ['estado'] = 'inactivo';
		$this->load->model('Publicaciones/Publicaciones_model');
		$datosPub = $this->Publicaciones_model->getPublicIdAndTimed();

		foreach ($datosPub as $publicacion) {
			$id_pub = $publicacion->id_publicaciones;
			$fechaPub = $publicacion->fecha;
			$tiempo_disponible = $publicacion->tiempo_disponible;
			$estado = $publicacion->estado;
			if ($estado == 'inactivo') {
				$data[$aux]['pubElim'] = $publicacion->id_publicaciones;
				$aux ++;
				$this->Publicaciones_model->updatePub($id_pub,$dat);
			}else if($tiempo_disponible!=0) {
				date_default_timezone_set('America/Bogota'); 
				$fecha_pub = date($fechaPub);
				$fechMm = date(strtotime($fecha_pub."+ ".$tiempo_disponible." minutes"));

				$fecha_actual = strtotime(date("Y-m-d H:i:s"));

				if($fecha_actual > $fechMm){
					$data[$aux]['pubElim'] = $publicacion->id_publicaciones;
					$aux ++;
					$this->Publicaciones_model->updatePub($id_pub,$dat);
				}	
			}	
		}
		echo json_encode($data);
	}

	public function eliminarPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$id_pub = $this->input->post('id');
		$data= array(
			'estado' => 'inactivo' 
		);
		if ($this->Publicaciones_model->updatePub($id_pub,$data)) {
			$answer = array(
				'answer' => 'OK'
			);
		}else{
			$answer = array(
				'answer' => 'ERROR'
			);
		}
		
		echo json_encode($answer);	
	}

	public function aceptarPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$this->load->model('usuarios/Usuarios_model');
		$this->load->model('Notificaciones/Notificaciones_model');
		$this->load->model('Solicitudes/Solicitudes_model');

		$id_pub = $this->input->post('id_pub');
		$id_us = $this->input->post('id_us');
		$puState = $this->Publicaciones_model->getPublicState($id_pub);

		if ($puState['estado'] == 'activo') {
			$data_sol = array(
				'usuario' => $id_us,
				'publicacion' => $id_pub
			);

			$data_inc = array(
				'estado' => 'inactivo'
			);

			$data_us = array(
				'estado' => 'solicitando'
			);
			$this->Solicitudes_model->newRequestPub($data_sol);
			$this->Publicaciones_model->updatePub($id_pub,$data_inc);
			$this->Usuarios_model->updateUsState($id_us,$data_us);
			$notifi_info = $this->Publicaciones_model->getUserPub($id_pub);

			$data_not = array(
				'mensaje' => 'Su publicacion de '.$notifi_info['titulo'].' ha sido aceptada',
				'destinatario' => $notifi_info['usuario'],
				'publicacion' => $id_pub,
				'tipo' => 'aceptacion',
				'remitente' => $id_us
			);
			$data_upn = array(
				'estado' => 'inactivo'
			);

			$this->Notificaciones_model->updateNotification($id_pub,$data_upn);
			$this->Notificaciones_model->insertNotification($data_not);

			//Se destruyen las sessiones existentes 
			$this->session->unset_userdata('buscomida_session');

			//Se reciven los datos de la sesion y se crea una nueva sesion
			$data_session = $this->Usuarios_model->selectUserById($id_us);
			$this->session->set_userdata('buscomida_session',$data_session);

			$answer = array(
				'state' => 'Success'
			);
		}else{
			$answer = array(
				'state' => 'Error'
			);
		}
		

		echo json_encode($answer);
	}

	public function showNotifications(){
		$id_us = $this->input->post('id_us');
		$this->load->model('Notificaciones/Notificaciones_model');
		$data = array(
						'info' => $this->Notificaciones_model->getNotifications($id_us),
						'num_not' => $this->Notificaciones_model->getNumNotifications($id_us)
					);
		
		echo json_encode($data);
	}

	public function getRequest(){
		$this->load->model('Solicitudes/Solicitudes_model');
		$id_us = $this->input->post('id_us');
		$data = $this->Solicitudes_model->getPubIdRequest($id_us);
		echo json_encode($data);	
	}

	public function cancelSol(){

		$this->load->model('Publicaciones/Publicaciones_model');
		$this->load->model('usuarios/Usuarios_model');
		$this->load->model('Notificaciones/Notificaciones_model');
		$this->load->model('Solicitudes/Solicitudes_model');

		$id_pub = $this->input->post('id_pub');
		$id_us = $this->input->post('id_us');
		$data_sol = array(
			'estado' => 'cancelado'
		);

		$data_inc = array(
			'estado' => 'activo'
		);

		$data_us = array(
			'estado' => 'activo'
		);
		$this->Solicitudes_model->updateRequest($id_pub,$data_sol);
		$this->Publicaciones_model->updatePub($id_pub,$data_inc);
		$this->Usuarios_model->updateUsState($id_us,$data_us);
		$notifi_info = $this->Publicaciones_model->getUserPub($id_pub);

		$data_not = array(
			'mensaje' => 'Su publicacion de '.$notifi_info['titulo'].' ha sido cancelada',
			'destinatario' => $notifi_info['usuario'],
			'publicacion ' => $id_pub,
			'tipo' => 'cancelacion',
			'remitente' => $id_us
		);

		$data_upn = array(
			'estado' => 'inactivo'
		);

		$this->Notificaciones_model->updateNotification($id_pub,$data_upn);
		$this->Notificaciones_model->insertNotification($data_not);

		//Se destruyen las sessiones existentes 
		$this->session->unset_userdata('buscomida_session');

		//Se reciven los datos de la sesion y se crea una nueva sesion
		$data_session = $this->Usuarios_model->selectUserById($id_us);
		$this->session->set_userdata('buscomida_session',$data_session);

		$answer = array(
			'state' => 'Success'
		);

		echo json_encode($answer);
	}

	public function getInfoUs(){
		$this->load->model('usuarios/Usuarios_model');
		$remitente = $this->input->post('remitente');
		$data = $this->Usuarios_model->selectUserDataById($remitente);

		echo json_encode($data);
	} 

	public function notEntregado(){
		$this->load->model('Notificaciones/Notificaciones_model');
		$data_not = array(
			'mensaje' => 'Ha recibido usted el alimento que solicitó?',
			'destinatario' => $this->input->post('receptor'),
			'publicacion' => $this->input->post('publicacion'),
			'tipo' => 'verificacion',
			'remitente' => $this->input->post('remitente')
		);
		$this->Notificaciones_model->insertNotification($data_not);
		$data = array(
			'answer' => 'Success'
		);
		echo json_encode($data);
	}

	public function validarRecibido(){

		$this->load->model('Publicaciones/Publicaciones_model');
		$this->load->model('usuarios/Usuarios_model');
		$this->load->model('Notificaciones/Notificaciones_model');
		$this->load->model('Solicitudes/Solicitudes_model');

		$id_pub = $this->input->post('publicacion');
		$id_us = $this->input->post('usuario');
		$data_sol ['estado']= 'entregado';

		$data_upn ['estado'] = 'inactivo';

		$this->Solicitudes_model->updateRequest($id_pub,$data_sol);
		$this->Notificaciones_model->updateNotification($id_pub,$data_upn);
		$data_us ['estado'] = ($this->Solicitudes_model->getSolNum($id_us))?'limitado':'activo';
		if ($data_us['estado'] == 'limitado') {
			date_default_timezone_set('America/Bogota');
			$data_us ['fecha_limitado'] = date("Y-m-d H:i:s");
		}
		$this->Usuarios_model->updateUsState($id_us,$data_us);

		//Se destruyen las sessiones existentes 
		$this->session->unset_userdata('buscomida_session');

		//Se reciven los datos de la sesion y se crea una nueva sesion
		$data_session = $this->Usuarios_model->selectUserById($id_us);
		$this->session->set_userdata('buscomida_session',$data_session);

		$answer ['state']= 'Success';

		echo json_encode($answer);
	}

	public function validarNRecibido(){
		$this->load->model('Notificaciones/Notificaciones_model');
		$id_pub = $this->input->post('publicacion');
		$id_us = $this->input->post('usuario');
		$remitente = $this->input->post('receptor');
		$id_noti = $this->input->post('notificacion_act');

		$data_not = array(
			'mensaje' => 'El receptor no ha recibido su alimento, comuniquese con el receptor por favor',
			'destinatario' => $remitente,
			'publicacion ' => $id_pub,
			'tipo' => 'cancelacion',
			'remitente' => $id_us
		);

		$data_upn = array(
			'estado' => 'inactivo'
		);
		$this->Notificaciones_model->insertNotification($data_not);
		$this->Notificaciones_model->updateNotificationById($id_noti,$data_upn);

		$answer ['answer'] = 'Success';

		echo json_decode($answer);
	}

	public  function reportPublic(){
		$this->load->model('Reportes/Reportes_model');
		$id_us = $this->session->userdata('buscomida_session')['codigo_us'];
		$id_pub = $this->input->post('id_pub');

		if ($this->Reportes_model->validateReport($id_us,$id_pub)) {
			$data = array(
				'usuario' => $id_us,
				'publicacion' => $id_pub
			);

			if ($this->Reportes_model->newReport($data)) {
				$answer ['answer'] = 'OK';
			}
		}else{
			$answer ['answer'] = 'ERROR';
		}
		echo json_encode($answer);
	}

}

/* End of file Loby.php */
/* Location: ./application/controllers/Loby.php */
