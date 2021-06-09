<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Denuncias extends CI_Controller {

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
		$this->load->view('Admin/Denuncias/denuncias',$view);
	}

	public function getPub(){
		$this->load->model('Reportes/Reportes_model');
		//Se trae la paginaAct en la que se encuentra el usuario
		$paginaAct = $this->input->post('pagina');
		$municipio = $this->session->userdata('buscomida_session')['municipio'];
		$pubpaginaAct = 6; //Se pone la cantidad de registros por pagina
		$lista = '';
		$public = '';
		$limit = 0;
		//Se trae la cantidad de publicaciones que hay en la base de datos
		$numPub = $this->Reportes_model->getNumPublicReport($municipio);

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


		$data ['pub'] = $this->Reportes_model->getPublicReport($limit,$pubpaginaAct,$municipio);
		$data ['pag'] = $lista;

		echo json_encode($data);	 
	}

	public function moreInformatonPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$id = $this->input->post('id_pub');
		$data = $this->Publicaciones_model->getPublicInformation($id);
		echo json_encode($data);
	}

	public function eliminarPub(){
		$this->load->model('Publicaciones/Publicaciones_model');
		$id_pub = $this->input->post('id');

		$data ['estado'] = 'eliminado';

		if ($this->Publicaciones_model->updatePub($id_pub,$data)) {
			$answer ['answer'] = 'OK';
		}
		
		echo json_encode($answer);	
	}

	public function quitarReporte(){
		$this->load->model('Reportes/Reportes_model');
		$id_pub = $this->input->post('id');

		$data ['estado'] = 'inactivo';

		if ($this->Reportes_model->updateReportes($id_pub,$data)) {
			$answer ['answer'] = 'OK';
		}
		
		echo json_encode($answer);	
	}

}

/* End of file Loby.php */
/* Location: ./application/controllers/Loby.php */
