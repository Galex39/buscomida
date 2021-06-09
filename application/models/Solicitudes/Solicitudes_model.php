<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitudes_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function newRequestPub($data){
		try {
			$this->db->insert('solicitudes',$data);
			return true;
		} catch (PDOException $e) {
			return $e;
		}
	}

	public function getPubIdRequest($id){
		try {
			$this->db->select('publicacion');
			$this->db->from('solicitudes');
			$this->db->where('estado','procesando');
			$this->db->where('usuario',$id);
			$query = $this->db->get();
			$result = $query->row_array();

			return $result;
		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}

	public function getPubRequest($limite,$numReg,$id){
		try {
			$this->db->select('solicitudes.publicacion,publicaciones.titulo,publicaciones.imagen,datos_usuario.nombres,datos_usuario.apellidos');
			$this->db->from('solicitudes');
			$this->db->join('publicaciones','publicaciones.id_publicaciones = solicitudes.publicacion');
			$this->db->join('usuarios','publicaciones.usuario = usuarios.codigo_us');
			$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
			$this->db->where('solicitudes.estado','entregado');
			$this->db->where('solicitudes.usuario',$id);
			$this->db->limit($numReg,$limite);
			$query = $this->db->get();
			$result = $query->result();

			return $result;
		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}

	public function getNumPubRequest($id){
		try {
			$this->db->select('id_solicitudes');
			$this->db->from('solicitudes');
			$this->db->where('estado','entregado');
			$this->db->where('solicitudes.usuario',$id);
			$query = $this->db->get();
			$result = $query->num_rows();

			return $result;
		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}

	public function updateRequest($id,$data){
		try {
    		$this->db->where('publicacion ',$id);
	    	$query = $this->db->update('solicitudes',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}
	}

	public function getSolNum($id_us){
		$this->db->select('usuario');
		$this->db->from('solicitudes');
		$this->db->where('usuario',$id_us);
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$query = $this->db->get();
		
		if ($query->num_rows()>=3) {
			return true;
		}else{
			return false;
		}
	}

	public function getPubAceptByYear($year){
		$this->db->select('COUNT(id_solicitudes) AS aceptadas');
		$this->db->from('solicitudes');
		$this->db->where('YEAR(fecha)',$year);
		$this->db->where('solicitudes.estado','entregado');
		$query = $this->db->get();

		return $query->row_array();
	}

	public function getPubAceptByMonth($year){
		$this->db->select('COUNT(id_solicitudes) AS aceptadas');
		$this->db->from('solicitudes');
		$this->db->where('YEAR(fecha)',$year);
		$this->db->where('solicitudes.estado','entregado');
		$this->db->group_by('MONTH(fecha)');
		$this->db->order_by('MONTH(fecha)','ASC');
		$query = $this->db->get();

		return $query->result_array();
	}
	//Metodos andoid

	public function getPubRequestAnd($id){
		try {
			$this->db->select('solicitudes.publicacion,publicaciones.titulo,publicaciones.imagen,publicaciones.fecha,publicaciones.tiempo_disponible,publicaciones.descripcion,publicaciones.direccion,publicaciones.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono');
			$this->db->from('solicitudes');
			$this->db->join('publicaciones','publicaciones.id_publicaciones = solicitudes.publicacion');
			$this->db->join('usuarios','publicaciones.usuario = usuarios.codigo_us');
			$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
			$this->db->where('solicitudes.estado','entregado');
			$this->db->where('solicitudes.usuario',$id);
			$query = $this->db->get();
			$result = $query->result();

			return $result;
		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}
}

/* End of file Solicitudes_model.php */
/* Location: ./application/models/Solicitudes/Solicitudes_model.php */