<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function insertNotification($data){
		try {
			$this->db->insert('notificaciones',$data);
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function getNotifications($id){
		$this->db->select();
		$this->db->from('notificaciones');
		$this->db->where('destinatario',$id);
		$this->db->where('estado','activo');
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}

	public function getNumNotifications($id){
		$this->db->select('id_noti');
		$this->db->from('notificaciones');
		$this->db->where('destinatario',$id);
		$this->db->where('estado','activo');
		$this->db->where('tipo <> "verificacion"');
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$query = $this->db->get();
		$result = $query->num_rows();

		return $result;
	}

	public function updateNotification($id,$data){
		try {
    		$this->db->where('publicacion ',$id);
	    	$query = $this->db->update('notificaciones',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}	
	}

	public function updateNotificationById($id,$data){
		try {
    		$this->db->where('id_noti ',$id);
	    	$query = $this->db->update('notificaciones',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}	
	}
	
	//Android metods
	
	public function getNotificationsT($id){
		$this->db->select('notificaciones.id_noti,notificaciones.mensaje,notificaciones.fecha,notificaciones.remitente,notificaciones.destinatario,notificaciones.publicacion,notificaciones.tipo,publicaciones.imagen');
		$this->db->from('notificaciones');
		$this->db->join('publicaciones','notificaciones.publicacion = publicaciones.id_publicaciones');
		$this->db->where('destinatario',$id);
		$this->db->where('notificaciones.estado','activo');
		$this->db->where('DATE(notificaciones.fecha) = CURRENT_DATE()');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
}


/* End of file notificaciones_model.php */
/* Location: ./application/models/Notificaciones/notificaciones_model.php */