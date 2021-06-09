<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends CI_Controller {

	public function __construct(){
		parent::__construct();
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
		$this->load->view('Admin/Estadisticas/estadisticas',$view);
	}

	public function getPubxM(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$year = $this->input->post('year');
		$data = $this->Publicaciones_model->getPubxM($year);
		$l = 0;
		$array;

		foreach ($data as $valor) {
			if (sizeof($data) > $l) {
				$array[$l] = $valor['numero'];
			}else{
				$array[$l] = 0;
			}
			$l++; 
		}

		echo json_encode($array);
	}

	public function roundChart(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$this->load->model('Solicitudes/Solicitudes_model');
		$year = $this->input->post('year');
		$data1 = $this->Publicaciones_model->getPubByYear($year);
		$data2 = $this->Solicitudes_model->getPubAceptByYear($year);
		
		$array = array(
			'0' => $data1['hechas'],
			'1' => $data2['aceptadas']
		);

		echo json_encode($array);
	}

	public function linearChart(){
		$this->load->model('Solicitudes/Solicitudes_model');
		$year = $this->input->post('year');
		$data = $this->Solicitudes_model->getPubAceptByMonth($year);
		$l = 0;
		$array;

		foreach ($data as $valor) {
			if (sizeof($data) > $l) {
				$array[$l] = $valor['aceptadas'];
			}else{
				$array[$l] = 0;
			}
			$l++; 
		}

		echo json_encode($array);
	}

}

/* End of file Loby.php */
/* Location: ./application/controllers/Loby.php */
