<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

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
	
	public function index(){
		$view ['menu'] = $this->load->view('Menus/menu_persona','',True);
		$view ['nav'] = $this->load->view('Nav/nav','',True);
		$view ['footer'] = $this->load->view('Footer/footer','', True);
		$this->load->view('Perfil/perfil',$view);
	}

	public function updateBData(){
		$this->load->model('usuarios/Usuarios_model');

		$codigo_us = $this->input->post('codigo_us');

		$data = array(
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'email' => $this->input->post('email'),
			'telefono' => $this->input->post('telefono'),
			'municipio' => $this->input->post('municipio')
		);

		if ($this->Usuarios_model->updateDataUser($codigo_us,$data)) {
			$answer ['answer'] = 'success';

			//Se destruyen las sessiones existentes 
				$this->session->unset_userdata('buscomida_session');

			//Se reciven los datos de la sesion y se crea una nueva sesion
			$data_session = $this->Usuarios_model->selectUserById($codigo_us);
			$this->session->set_userdata('buscomida_session',$data_session);
		}else{
			$answer ['answer'] = 'error';
		}

		echo json_encode($answer);
	}

	public function updatePass(){
		$this->load->model('usuarios/Usuarios_model');
		
		$codigo_us =$this->input->post('codigo_us');
		$pw =  md5($this->input->post('pw_act'));
		$pw_n = md5($this->input->post('pw_n'));
		$pw_nr = md5($this->input->post('pw_nr'));

		if ($this->Usuarios_model->validatePass($codigo_us,sha1($pw))) {
			if ($pw_n == $pw_nr) {
				$data = array(
					'pw' => sha1($pw_n)
				);
				if ($this->Usuarios_model->updateTableUser($codigo_us,$data)) {
					$answer ['answer'] = 'Success';
				}else{
					$answer ['answer'] = 'ERROR';
				}
			}else{
				$answer ['answer'] = 'ERR_PWD'; 
			}
		}else{
			$answer ['answer'] = 'ERR_PASS';
		}

		echo json_encode($answer);
	}

	public function changeImage(){

		$this->load->model('usuarios/Usuarios_model');

		$fecha = new DateTime();
		$datename = $fecha->getTimestamp();
		
		$config['upload_path'] = 'assets/files/usuarios/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size']  = '2000';
		$config['max_width']  = '5000';
		$config['max_height']  = '4000';
		$config['file_name'] = $datename."img.jpg";
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		$codigo_us = $this->input->post('codigo_us');
		$data = array(
			'foto' => $datename.'img_thumb.jpg'
		);
		$datos_json= array();
		if ($this->Usuarios_model->changeImage($codigo_us,$data)) {
			if (!$this->upload->do_upload('profileImage') ){
				$datos_json["estado"] = "ErrorUpload";
				$datos_json["error"] = $this->upload->display_errors();
			}else{

				$datos_json["estado"] = "Success";

				$data = array('upload_data' => $this->upload->data());
      
           		foreach ($this->upload->data() as $item => $value){
              
	                if($item=="file_path"){
	                    $path=$value;
	                }if($item=="file_name"){
	                    $name=$value;
	                }    
           
            	}// end foreach
           
          		$this->resize($path,$name,$codigo_us);
          	}
		}else{
			$datos_json["estado"] = "ErrorPublic";
		}
		echo json_encode($datos_json);
	}

	public function resize($path,$name,$codigo_us){
		$this->load->model('usuarios/Usuarios_model');

         $config['image_library'] = 'gd2';
         $config['source_image'] =  $path.$name; // le decimos donde esta la imagen que acabamos de subir
         $config['new_image']=$path.$name; // las nuevas imágenes se guardan en la carpeta "thumbs"
         $config['create_thumb'] = TRUE;
         $config['maintain_ratio'] = False;
         $config['width'] = 450;
         $config['height'] = 500;
       
        $this->load->library('image_lib', $config);
       
        if (!$this->image_lib->resize()){
            echo $this->image_lib->display_errors();
        }

        $this->image_lib->resize();

        unlink('assets/files/usuarios/'.$name);

        //Se destruyen las sessiones existentes 
		$this->session->unset_userdata('buscomida_session');

		//Se reciven los datos de la sesion y se crea una nueva sesion
		$data_session = $this->Usuarios_model->selectUserById($codigo_us);
		$this->session->set_userdata('buscomida_session',$data_session);
    }

    public function resizeImPub($path,$name){
		$this->load->model('usuarios/Usuarios_model');

         $config['image_library'] = 'gd2';
         $config['source_image'] =  $path.$name; // le decimos donde esta la imagen que acabamos de subir
         $config['new_image']=$path.$name; // las nuevas imágenes se guardan en la carpeta "thumbs"
         $config['create_thumb'] = TRUE;
         $config['maintain_ratio'] = False;
         $config['width'] = 450;
         $config['height'] = 500;
       
        $this->load->library('image_lib', $config);
       
        if (!$this->image_lib->resize()){
            echo $this->image_lib->display_errors();
        }

        $this->image_lib->resize();

        unlink('assets/files/publicaciones/'.$name);
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
      		$this->resizeImPub($path,$name);

      		if ($this->Publicaciones_model->insertPub($dataForm)) {
				$datos_json["estado"] = "Success";
			}else{
				$datos_json["estado"] = "ErrorPublic";
				unlink('assets/files/publicaciones/'.$datename."img_thumb.jpg");
			}
		}
		echo json_encode($datos_json);
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
			'mensaje' => 'El receptor no ha recibido su alimento, comuniquese con el por favor',
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

		$answer = array(
			'answer' => 'Success'
		);

		echo json_encode($answer);
	}

	public function getDepartamentos(){
		$this->load->model('DepMun/DepMun_model');
		$data = $this->DepMun_model->getDepart();

		echo json_encode($data);
	}

	public function getMunicipios(){
		$this->load->model('DepMun/DepMun_model');
		$id_dep = $this->input->post('id_dep');
		$data = $this->DepMun_model->getMun($id_dep);

		echo json_encode($data);
	}

	public function getDepmun(){
		$this->load->model('DepMun/DepMun_model');
		$id = $this->input->post('municipio');
		$data = $this->DepMun_model->getDepmun($id);
		echo json_encode($data);
	}
}
 
/* End of file Perfil.php */
/* Location: ./application/controllers/Perfil/Perfil.php */