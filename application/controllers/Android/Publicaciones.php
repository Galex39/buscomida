<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicaciones extends CI_Controller {

	public function index()
	{
		
	}
	
	public function  getPublic(){
	    $this->load->model('Publicaciones/Publicaciones_model');
	    $usuario = $this->input->get('usuario');
	    $municipio = $this->input->get('municipio');
	    
	    $data ['info_pub'] = $this->Publicaciones_model->getAndroidPublic($usuario,$municipio);
	    
	    echo json_encode($data);
	}
	
	public function getAceptPublic(){
	    $this->load->model('Solicitudes/Solicitudes_model');
	    $codigo_us = $this->input->get('usuario');
	    
	    $data ['info_pubacept'] = $this->Solicitudes_model->getPubRequestAnd($codigo_us);
	    
	    echo json_encode($data);
	}
	
	public function getMyPublic(){
	    $this->load->model('Publicaciones/Publicaciones_model');
	    $codigo_us = $this->input->get('usuario');
	    
	    $data ['info_mypub'] =  $this->Publicaciones_model->getMyPublic($codigo_us);
	    
	    echo json_encode($data);
	        
	}
	
	public function getPublicInformation(){
	    $this->load->model('Publicaciones/Publicaciones_model');
	    $id_pub = $this->input->get('id_pub');
	    
	    $data ['info_pub'] = $this->Publicaciones_model->getPublicInformation();
	    
	    echo json_encode($data);
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

			$answer = 'OK';
		}else{
			$answer = 'ERROR';
		}
		

		echo $answer;
	}
	
	public function rePublicar(){
		$this->load->model('Publicaciones/Publicaciones_model');
		date_default_timezone_set('America/Bogota');
		$time = time();
		$fecha_actual = date("Y-m-d H:i:s");
		$id_pub = $this->input->post('id_pub');
		$dataForm = array(
			'titulo' => $this->input->post('titulo'),
			'descripcion' => $this->input->post('descripcion'),
			'direccion' => $this->input->post('ubicacion'),
			'tiempo_disponible' => $this->input->post('tiempo'),
			'estado'=> 'activo',
			'fecha' => $fecha_actual
		);
		$datos_json= array();

  		if ($this->Publicaciones_model->updatePub($id_pub,$dataForm)) {
			$datos_json = "OK";
		}else{
			$datos_json = "ERROR";
		}

		echo $datos_json;
	}
	
	public function cancel_pub(){
		$this->load->model('Publicaciones/Publicaciones_model');

		$id_pub = $this->input->post('publicacion');
		$data ['estado'] = 'inactivo';

		if ($this->Publicaciones_model->updatePub($id_pub,$data)) {
			$answer ['state'] = 'Success';
		}

		echo json_encode($answer);
	}
	
	public function cancelSol(){

		$this->load->model('Publicaciones/Publicaciones_model');
		$this->load->model('usuarios/Usuarios_model');
		$this->load->model('Notificaciones/Notificaciones_model');
		$this->load->model('Solicitudes/Solicitudes_model');

		$id_pub = $this->input->post('id_pub');
		$id_us = $this->input->post('id_us');
		
		$data_sol ['estado'] = 'cancelado';
		$data_inc ['estado'] = 'activo';
		$data_us ['estado'] = 'activo';
		
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

		$data_upn ['estado'] = 'inactivo';

		$this->Notificaciones_model->updateNotification($id_pub,$data_upn);
		$this->Notificaciones_model->insertNotification($data_not);

		$answer = 'OK';

		echo $answer;
	}
	
	public function newPub(){
		$this->load->model('Publicaciones/Publicaciones_model');

		$fecha = new DateTime();
		$datename = $fecha->getTimestamp();
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
 
            $imagen= $this->input->post('foto');
            $path = "assets/files/publicaciones/".$datename."img_thumb.jpg";
    
                $dataForm = array(
        			'usuario' => $this->input->post('id_us'),
        			'titulo' => $this->input->post('titulo'),
        			'descripcion' => $this->input->post('descripcion'),
        			'direccion' => $this->input->post('ubicacion'),
        			'imagen' => $datename."img_thumb.jpg",
        			'tiempo_disponible' => $this->input->post('tiempo'),
        			'municipio' => $this->input->post('municipio')
        		);
            
            
            if ($this->Publicaciones_model->insertPub($dataForm)){
                echo 'OK';
                file_put_contents($path,base64_decode($imagen));
            }else{
                echo "ERR_PUB";
            }
            
        }else{
            echo "Error";
        }
		
	}
	
	public function showNotifications(){
		$id_us = $this->input->get('id_us');
		$this->load->model('Notificaciones/Notificaciones_model');
		$data ['info_not'] = $this->Notificaciones_model->getNotificationsT($id_us);
			 	
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
		$data = 'OK';
		echo $data;
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

		$answer = 'OK';

		echo $answer;
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

		$answer = 'Success';

		echo json_decode($answer);
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */