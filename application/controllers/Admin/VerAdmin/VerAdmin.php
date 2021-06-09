<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerAdmin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//Inicializacion de atributos
		//Se hace la validaciòn de permisos
		if (!empty($this->session->userdata('buscomida_session')) && $this->session->userdata('buscomida_session')['tipo']=='Admin') {
			return false;
		}else{
			redirect('Login/login');
		}
	}

	//Se carga la vista del loby
	public function index(){
		$view ['menu'] = $this->load->view('Menus/menu_admin','',True);
		$view ['nav'] = $this->load->view('Nav/nav_admin','',True);
		$view ['footer'] = $this->load->view('Footer/footer','', True);
		$this->load->view('Admin/verAdmin/verAdmin',$view);
	}

	public function getAdministradores(){
		$this->load->model('usuarios/Usuarios_model');
		$query = $this->Usuarios_model->selectAdminUsers();

		echo json_encode($query);
	}

	public function newAdmin(){
		//Se carga el modelo que se va a utilizar
		$this->load->model('usuarios/Usuarios_model');

		$user_name = $this->input->post('user_name');
		$pw = $this->input->post('pw');
		$r_pw = $this->input->post('r_pw');

		if (!$this->Usuarios_model->validateUser($user_name)) {
			if ($pw == $r_pw){

				$pawE = md5($pw);

				$data_norm = array(            
			        'nombres' => $this->input->post('name'),
			        'apellidos' => $this->input->post('last_name'),
			        'telefono' => $this->input->post('cel_number'),
			        'email' => $this->input->post('email'),
			        'municipio' => $this->input->post('municipio')
		    	);

		    	$data_us = array(
		    		'usuario' => $user_name,
		    		'pw' => sha1($pawE),
		    		'tipo' => 'Admin'
		    	);

		    	if ($this->Usuarios_model->register($data_us,$data_norm)) {
		    		$data ['state'] = 'SUCCESS';

		    	}
			}else{
				$data['state']= 'ERR_PASS';
			}
		}else{
			$data['state']= 'ERR_US';
		}
		echo json_encode($data);
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


}

/* End of file verAdmin.php */
/* Location: ./application/controllers/Admin/verAdmin/verAdmin.php */