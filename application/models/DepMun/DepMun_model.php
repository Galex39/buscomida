<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DepMun_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getDepart(){
		try {
			$this->db->select('id,nombre');
			$this->db->from('departamentos');
			$this->db->order_by('nombre', 'ASD');
			$query = $this->db->get();

			return $query->result();
		} catch (PDOException $e) {
			return $e;
		}
	}

	public function getMun($id){
		try {
			$this->db->select('id,nombre');
			$this->db->from('municipios');
			$this->db->where('departamento_id',$id);
			$this->db->order_by('nombre', 'ASD');
			$query = $this->db->get();

			return $query->result();
		} catch (PDOException $e) {
			return $e;
		}
	}

	public function getDepmun($id){
		try {
			$this->db->select('departamento_id');
			$this->db->from('municipios');
			$this->db->where('id',$id);
			$query = $this->db->get();

			return $query->row_array();
		} catch (PDOException $e) {
			return $e;
		}
	}

	//Android methods

	public function getMunpAndroid($name){
		try {
			$this->db->select('municipios.nombre');
			$this->db->from('municipios');
			$this->db->join('departamentos','municipios.departamento_id = departamentos.id','INNER');
			$this->db->where('departamentos.nombre',$name);
			$this->db->order_by('municipios.nombre','ASD');
			$query = $this->db->get();

			return $query->result_array();
		} catch (PDOException $e) {
			return $e;
		}
	}
	
	public function getIdMunByname($name){
	    $this->db->select('id');
	    $this->db->from('municipios');
	    $this->db->where('nombre',$name);
	    $query = $this->db->get();
	    
	    return $query->row_array();
	}

}

/* End of file DepMun.php */
/* Location: ./application/models/DepMun/DepMun.php */