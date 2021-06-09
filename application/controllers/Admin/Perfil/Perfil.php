<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//Inicializacion de atributos
		//Se hace la validaciòn de permisos
		if (!empty($this->session->userdata('buscomida_session')) && $this->session->userdata('buscomida_session')['tipo']=='Admin') {
			return false;
		}else{
			// redirect('Login/login');
		}
	}

	public function index(){
		$view ['menu'] = $this->load->view('Menus/menu_admin','',True);
		$view ['nav'] = $this->load->view('Nav/nav_admin','',True);
		$view ['footer'] = $this->load->view('Footer/footer','', True);
		$this->load->view('Admin/Perfil/perfil',$view);
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
		$config['max_size']  = '3048';
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
		$this->session->set_userdata('buscomida_session',$data_session);}

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