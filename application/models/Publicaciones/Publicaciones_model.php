<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicaciones_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}

	public function insertPub($data_pub){
		try {
			$this->db->insert('publicaciones',$data_pub);
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function updatePub($id,$data){
		try {
    		$this->db->where('id_publicaciones ',$id);
	    	$query = $this->db->update('publicaciones',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}	
	}

	public function disabledPublic($id,$data){
		try {
    		$this->db->where('usuario',$id); 
    		$this->db->where('DATE(fecha) < CURRENT_DATE()');
	    	$query = $this->db->update('publicaciones',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}	
	}

	public function getPublic($limite,$numReg,$id_us,$municipio){
		$this->db->select('id_publicaciones,titulo,imagen,datos_usuario.nombres,datos_usuario.apellidos');
		$this->db->from('publicaciones');
		$this->db->join('usuarios','usuarios.codigo_us = publicaciones.usuario');
		$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
		$this->db->where('publicaciones.municipio',$municipio);
		$this->db->where('publicaciones.estado','activo');
		$this->db->where('publicaciones.usuario <> '.$id_us);
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$this->db->order_by('fecha','DESC');
		$this->db->limit($numReg,$limite);
		$query = $this->db->get();

		if ($this->db->affected_rows()) {
			return $query->result();
		}else{
			return false;
		}
	}

	public function getPublicByUser($limite,$numReg,$id_us){
		$this->db->select('id_publicaciones,titulo,imagen,publicaciones.estado,datos_usuario.nombres,datos_usuario.apellidos');
		$this->db->from('publicaciones');
		$this->db->join('usuarios','usuarios.codigo_us = publicaciones.usuario');
		$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
		$this->db->where('publicaciones.estado <> "eliminado"');
		$this->db->where('publicaciones.usuario',$id_us);
		$this->db->order_by('fecha', 'DESC');
		$this->db->limit($numReg,$limite);
		$query = $this->db->get();

		if ($this->db->affected_rows()) {
			return $query->result();
		}else{
			return false;
		}
	}

	public function getNumPublic($id_us,$municipio){
		$this->db->select('id_publicaciones');
		$this->db->from('publicaciones');
		$this->db->where('municipio',$municipio);
		$this->db->where('publicaciones.estado','activo');
		$this->db->where('publicaciones.usuario <> '.$id_us);
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$query = $this->db->get();
		$numeroR = $query->num_rows();

		return $numeroR;
	}

	public function getNumPublicByUser($id_us){
		$this->db->select('id_publicaciones');
		$this->db->from('publicaciones');
		$this->db->where('publicaciones.estado <> "eliminado"');
		$this->db->where('publicaciones.usuario',$id_us);
		$this->db->order_by('fecha', 'DESC');
		$query = $this->db->get();
		$numeroR = $query->num_rows();

		return $numeroR;
	}

	public function getPublicInformation($id){
		$this->db->select('id_publicaciones,titulo,descripcion,fecha,imagen,direccion,tiempo_disponible,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono');
		$this->db->from('publicaciones');
		$this->db->join('usuarios','usuarios.codigo_us = publicaciones.usuario');
		$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
		$this->db->where('id_publicaciones',$id);
		$query = $this->db->get();

		if ($this->db->affected_rows()) {
			return $query->row_array();
		}else{
			return false;
		}
	}

	public function getPublicIdAndTimed(){
		$this->db->select('id_publicaciones,fecha,tiempo_disponible,estado');
		$this->db->from('publicaciones');
		// $this->db->where('estado','activo');
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$query = $this->db->get();
		$data = $query->result();

		return $data;
	}

	public function getUserPub($id){
		try {
			$this->db->select('usuario,titulo');
			$this->db->from('publicaciones');
			$this->db->where('id_publicaciones',$id);
			$query = $this->db->get();
			$result = $query->row_array();

			return $result;
		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}

	public function getPublicState($id){
		try {
			$this->db->select('estado');
			$this->db->from('publicaciones');
			$this->db->where('id_publicaciones',$id);
			$query = $this->db->get();
			$result = $query->row_array();

			return $result;
		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}

	public function getPublicAdmin($limite,$numReg,$municipio){
		try {
			$this->db->select('id_publicaciones,titulo,imagen,datos_usuario.nombres,datos_usuario.apellidos');
			$this->db->from('publicaciones');
			$this->db->join('usuarios','usuarios.codigo_us = publicaciones.usuario');
			$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
			$this->db->where('publicaciones.municipio',$municipio);
			$this->db->where('publicaciones.estado','activo');
			$this->db->where('DATE(fecha) = CURRENT_DATE()');
			$this->db->order_by('fecha','DESC');
			$this->db->limit($numReg,$limite);
			$query = $this->db->get();

			return $query->result();

		} catch (PDOException $e) {
			return $e.getMessage();
		}
	}
	public function getNumPublicAdmin($municipio){
		$this->db->select('id_publicaciones');
		$this->db->from('publicaciones');
		$this->db->where('municipio',$municipio);
		$this->db->where('publicaciones.estado','activo');
		$this->db->where('DATE(fecha) = CURRENT_DATE()');
		$query = $this->db->get();

		return $query->num_rows();
	}

	//Consultas para graficas

	public function getPubxM($year){
		$this->db->select('COUNT(id_publicaciones) AS numero');
		$this->db->from('publicaciones');
		$this->db->where('YEAR(fecha)',$year);
		$this->db->group_by('MONTH(fecha)');
		$this->db->order_by('MONTH(fecha)','ASC');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function getPubByYear($year){
		$this->db->select('COUNT(id_publicaciones) AS hechas');
		$this->db->from('publicaciones');
		$this->db->where('YEAR(fecha)',$year);
		$query = $this->db->get();

		return $query->row_array();
	}


	//Metodos Android
	
	public function getAndroidPublic($id_us,$municipio){
	   
		$this->db->select('solicitudes.publicacion AS id_publicaciones,publicaciones.titulo,publicaciones.imagen,publicaciones.fecha,publicaciones.tiempo_disponible,publicaciones.descripcion,publicaciones.direccion,publicaciones.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono');
		$this->db->from('solicitudes');
		$this->db->join('publicaciones','publicaciones.id_publicaciones = solicitudes.publicacion');
		$this->db->join('usuarios','publicaciones.usuario = usuarios.codigo_us');
		$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
		$this->db->where('solicitudes.estado','procesando');
		$this->db->where('solicitudes.usuario',$id_us);
		$query = $this->db->get();
		$result = $query->result();

		if ($query->num_rows()!=0) {
			return $result;
		}else{
		    $this->db->select('id_publicaciones,titulo,descripcion,fecha,imagen,direccion,tiempo_disponible,publicaciones.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono');
    		$this->db->from('publicaciones');
    		$this->db->join('usuarios','usuarios.codigo_us = publicaciones.usuario');
    		$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
    		$this->db->where('publicaciones.municipio',$municipio);
    		$this->db->where('publicaciones.estado','activo');
    		$this->db->where('publicaciones.usuario <> '.$id_us);
    		$this->db->where('DATE(fecha) = CURRENT_DATE()');
    		$query2 = $this->db->get();
			return $query2->result();
		}
	}
	
	public function getMyPublic($id_us){
    	$this->db->select('id_publicaciones,titulo,descripcion,fecha,imagen,direccion,tiempo_disponible,publicaciones.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono');
    	$this->db->from('publicaciones');
    	$this->db->join('usuarios','usuarios.codigo_us = publicaciones.usuario');
    	$this->db->join('datos_usuario','usuarios.codigo_us = datos_usuario.codigo_us');
    	$this->db->where('publicaciones.usuario',$id_us);
    	$this->db->order_by('fecha', 'DESC');
    	$query = $this->db->get();
    
    	if ($this->db->affected_rows()) {
    		return $query->result_array();
    	}else{
    		return array();
    	}
    }



}

/* End of file Publicaciones.php */
/* Location: ./application/models/Publicaciones.php */
