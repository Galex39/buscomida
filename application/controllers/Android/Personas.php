<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personas extends CI_Controller {

	public function index()
	{
		
	}

	public function validarLogin(){
		$usuario = $this->input->post('nameUser');
		$pass = md5($this->input->post('password'));
		$passE = sha1($pass);

		$this->load->model('usuarios/Usuarios_model'); 
		
		if ($this->Usuarios_model->login($usuario,$passE)) {
			$dataJson  = 'OK';
		}else{
			$dataJson = 'ERROR';
		}

		echo $dataJson;
	}

	public function validarRegister(){
		//Se carga el modelo que se va a utilizar
		$this->load->model('usuarios/Usuarios_model');
		$this->load->model('DepMun/DepMun_model');

		$user_name = $this->input->post('user_name');
		$pw = $this->input->post('pw');
		$r_pw = $this->input->post('r_pw');

		if (!$this->Usuarios_model->validateUser($user_name)) {
			if ($pw == $r_pw){

				$pawE = md5($pw);
				
				$municipio = $this->DepMun_model->getIdMunByname($this->input->post('municipio'));

				$data_norm = array(
			        'nombres' => $this->input->post('nombres'),
			        'apellidos' => $this->input->post('apellidos'),
			        'telefono' => $this->input->post('telefono'),
			        'email' => $this->input->post('email'),
			        'municipio' => $municipio['id']
		    	);

		    	$data_us = array(
		    		'usuario' => $user_name,
		    		'pw' => sha1($pawE)
		    	);

		    	if ($this->Usuarios_model->register($data_us,$data_norm)) {
		    		$dataJson  = 'OK';
		    	}else{
		   			$dataJson  = 'ERR_REG';
		    	}
			}else{
				$dataJson  = 'ERR_PASS';
			}
		}else{
			$dataJson  = 'ERR_US';
		}

		echo $dataJson;
	}
	
	public function getDataUser(){
	    $this->load->model('usuarios/Usuarios_model');
	    $usuario = $this->input->get('usuario');
	    
	    $data ['info_us'] = $this->Usuarios_model->selectUserByUserName($usuario);
	    
	    echo json_encode($data);
	}
	
	public function getDataUserByid(){
        $this->load->model('usuarios/Usuarios_model');
        $usuario = $this->input->get('usuario');
        
        $data ['info_us'] = $this->Usuarios_model->selectUserById($usuario);
        
        echo json_encode($data);
	}
	
	public function editDataUser(){
	    $this->load->model('usuarios/Usuarios_model');
	    $id_us = $this->input->post('codigo_us');
	    $data = array(
	        'nombres' => $this->input->post('nombres'),
	        'apellidos' => $this->input->post('apellidos'),
	        'telefono' => $this->input->post('telefono'),
	        'email' => $this->input->post('email')
	    );
	    
	    if  ($this->Usuarios_model->updateDataUser($id_us,$data)){
	        echo 'OK';
	    }else{
	        echo 'Error';
	    }
	}
	
	public function getMunicipiosbByDepart(){
	    $this->load->model('DepMun/DepMun_model');
	    $name = $this->input->get('departamento');
	    $data ['lista_municipios'] = $this->DepMun_model->getMunpAndroid($name);
	    
	    echo json_encode($data);
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
					$answer = 'OK';
				}else{
					$answer = 'ERROR';
				}
			}else{
				$answer = 'ERR_PWD'; 
			}
		}else{
			$answer = 'ERR_PASS';
		}

		echo $answer;
	}
	
	public function getUState(){
	    $this->load->model('usuarios/Usuarios_model');
	    $id_us = $this->input->get('usuario');
	    $data ['estado'] = $this->Usuarios_model->getUState($id_us);
	    
	    echo json_encode($data);
	}
	
	public function uploadImage(){
	    
	    $this->load->model('usuarios/Usuarios_model');
	    if($_SERVER['REQUEST_METHOD']=='POST'){
 
            $imagen= $this->input->post('foto');
            $codigo_us = $this->input->post('usuario');
            
            $path = "assets/files/usuarios/".$codigo_us.".jpg";
             
            $data = array(
			    'foto' => $codigo_us.'.jpg'
		    );
            
            if($this->Usuarios_model->changeImage($codigo_us,$data)){
                file_put_contents($path,base64_decode($imagen));
                echo "Subio imagen Correctamente";
            }
             
        }else{
            echo "Error";
        }
	}

}

/* End of file Pesonas.php */
/* Location: ./application/controllers/Android/Pesonas.php */