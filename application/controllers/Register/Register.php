<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Register extends CI_Controller {
		
		public function index()
		{
			$this->load->view('Register/register');
		}

		public function validar(){
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
			    		'pw' => sha1($pawE)
			    	);

			    	if ($this->Usuarios_model->register($data_us,$data_norm)) {

			     		// Se destruyen las sessiones existentes 
						$this->session->unset_userdata('buscomida_session');

						//Se reciven los datos de la sesion y se crea una nueva sesion
						$data_session = $this->Usuarios_model->selectUser($user_name,sha1($pawE));
						$this->session->set_userdata('buscomida_session',$data_session);
			    		redirect('Personas/Loby/loby');
			    		
			    	}else{
			   			$data['error']= 'ERR_REG';
						$this->load->view('Register/register',$data);
			    	}
				}else{
					$data['error']= 'ERR_PASS';
					$this->load->view('Register/register',$data);	
				}
			}else{
				$data['error']= 'ERR_US';
				$this->load->view('Register/register',$data);
			}
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
	
	/* End of file Register.php */
	/* Location: ./application/controllers/Register/Register.php */

 ?>