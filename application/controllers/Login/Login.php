<?php 
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Login extends CI_Controller {
	
		public function index(){
			$this->load->view('Login/login');
		}

		public function validar(){
			$usuario = $this->input->post('nameUser');
			$pass = md5($this->input->post('password'));
			$passE = sha1($pass);

			$this->load->model('usuarios/Usuarios_model'); 
			
			if ($this->Usuarios_model->login($usuario,$passE)) {
				//Se destruyen las sessiones existentes 
				$this->session->unset_userdata('buscomida_session');

				//Se reciven los datos de la sesion y se crea una nueva sesion
				$data_session = $this->Usuarios_model->selectUser($usuario,$passE); 
				$this->session->set_userdata('buscomida_session',$data_session);

				//Segun los privilegios se redirecciona a su respectivo lugar
				if ($this->session->userdata('buscomida_session')['tipo']=='Persona') {
					redirect('Personas/Loby/loby');	
				}else if($this->session->userdata('buscomida_session')['tipo']=='Admin'){
					redirect('Admin/Loby/loby');
				}

			}else{
				$data['error'] = 'ERROR';
				$this->load->view('Login/login',$data);
			}
		} 
		public function cerrar_session(){
			$this->session->unset_userdata('buscomida_session');
			redirect('inicio');
		}
	
	}
	
	/* End of file Login.php */
	/* Location: ./application/controllers/Login.php */

 ?>