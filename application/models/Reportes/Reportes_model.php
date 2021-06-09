<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function  newReport($data){
		try {
			$this->db->insert('reportes_publicaciones',$data);
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function getPublicReport($limite,$numReg,$municipio){
		$this->db->select('reportes_publicaciones.publicacion,publicaciones.titulo,publicaciones.imagen,datos_usuario.nombres,datos_usuario.apellidos');
		$this->db->from('reportes_publicaciones');
		$this->db->join('publicaciones','publicaciones.id_publicaciones = reportes_publicaciones.publicacion');
		$this->db->join('usuarios', 'publicaciones.usuario = usuarios.codigo_us');
		$this->db->join('datos_usuario','datos_usuario.codigo_us = usuarios.codigo_us');
		$this->db->where('publicaciones.municipio',$municipio);
		$this->db->where('publicaciones.estado','activo');
		$this->db->where('reportes_publicaciones.estado','activo');
		$this->db->where('DATE(publicaciones.fecha) = CURRENT_DATE()');
		$this->db->group_by("reportes_publicaciones.publicacion");
		$this->db->having('COUNT(reportes_publicaciones.publicacion) >= 5');
		$this->db->limit($numReg,$limite);
		$query = $this->db->get();

		return $query->result();
	} 

	public function getNumPublicReport($municipio){
		$this->db->select('reportes_publicaciones.id_reporte');
		$this->db->from('reportes_publicaciones');
		$this->db->join('publicaciones', 'publicaciones.id_publicaciones = reportes_publicaciones.publicacion');
		$this->db->where('publicaciones.municipio',$municipio);
		$this->db->where('publicaciones.estado','activo');
		$this->db->where('reportes_publicaciones.estado','activo');
		$this->db->where('DATE(publicaciones.fecha) = CURRENT_DATE()');
		$this->db->group_by("reportes_publicaciones.publicacion");
		$this->db->having('COUNT(reportes_publicaciones.publicacion) >= 5');
		$query = $this->db->get();

		return $query->num_rows();
	} 

	public function updateReportes($id,$data){
		try {
    		$this->db->where('publicacion ',$id);
	    	$query = $this->db->update('reportes_publicaciones',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}	
	}

	//Consulta para validar si el usuario ya tiene un reporte sobre esa publicación
	public function validateReport($id_us,$id_pub){
		$this->db->select('id_reporte');
		$this->db->from('reportes_publicaciones');
		$this->db->where('usuario',$id_us);
		$this->db->where('publicacion',$id_pub);
		$query = $this->db->get();

		if ($query->num_rows()>0) {
			return false;	
		}else{
			return true;
		}
	}
	

}

/* End of file Reportes_model.php */
/* Location: ./application/models/Reportes/Reportes_model.php */