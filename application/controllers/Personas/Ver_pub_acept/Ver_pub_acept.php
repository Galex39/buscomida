<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ver_pub_acept extends CI_Controller {

	public function __construct(){
		parent::__construct();
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
		$this->load->view('Persona/Ver_pub_acept/Ver_pub_acept',$view);
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
		$this->load->model('Solicitudes/Solicitudes_model');
		//Se trae la paginaAct en la que se encuentra el usuario
		$paginaAct = $this->input->post('pagina');
		$usuario = $this->input->post('usuario');
		$pubpaginaAct = 6; //Se pone la cantidad de registros por pagina
		$lista = '';
		$public = '';
		$limit = 0;
		//Se trae la cantidad de publicaciones que hay en la base de datos
		$numPub = $this->Solicitudes_model->getNumPubRequest($usuario);

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


		$data ['pub'] = $this->Solicitudes_model->getPubRequest($limit,$pubpaginaAct,$usuario);
		$data ['pag'] = $lista;

		echo json_encode($data);	 
	}

	public function moreInformatonPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$id = $this->input->post('id_pub');
		$data = $this->Publicaciones_model->getPublicInformation($id);
		echo json_encode($data);
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
		$data_sol = array(
			'estado' => 'entregado'
		);

		$data_us = array(
			'estado' => 'activo'
		);
		$this->Solicitudes_model->updateRequest($id_pub,$data_sol);
		$this->Usuarios_model->updateUsState($id_us,$data_us);
		$notifi_info = $this->Publicaciones_model->getUserPub($id_pub);

		$data_upn = array(
			'estado' => 'inactivo'
		);

		$this->Notificaciones_model->updateNotification($id_pub,$data_upn);

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
	}
}

/* End of file Loby.php */
/* Location: ./application/controllers/Loby.php */
