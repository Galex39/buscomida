<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	

	public function __construct(){
		parent::__construct();
	}

    //Funcion del login
	public function login($userName,$pass){
		//Filtra por usuario y passwor para verificar si el usuario existe
    	$this->db->where('usuario',$userName);
    	$this->db->where('pw',$pass);
    	$data = $this->db->get('usuarios');
    	//Retorna respuesta si los registros encontrados son mayores a 0
    	if ($data->num_rows()>0) {
    		return true;
    	}else{
    		return false;
    	}
    }

    //Funcion para verificar si el usuario ya existe
    public function validateUser($username){
    	//Filtra por nombre de Usuario
    	$this->db->select('codigo_us');
    	$this->db->from('usuarios');
    	$this->db->where('usuario',$username);
    	$query = $this->db->get();
    	//Si los registros encontrados son mayores a 0 existe
    	if ($query->num_rows()>0) {
    		return true;
    	}else{
    		return false;
    	}
    }
    //Registro de usuarios
    public function register($data_us,$data_norm){
        try {
            //La DB tiene dos tablas de datos de usuario
            //Inserta en la primera tabla
            $this->db->insert('usuarios',$data_us);
            //Verifica si la insercion fue exitosa
            if ($this->db->affected_rows()) {
                //Captura el ultimo id
                $id = $this->db->insert_id();
                $data_norm['codigo_us'] = $id;
                //Hace la insercion en la segunda tabla
                $this->db->insert('datos_usuario',$data_norm);
                //Verifica si la insercion fue exitosa
                if ($this->db->affected_rows()) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        } catch (Exception $e) {
            return $e.getMessage();
        }
    	
    }
	//Consulta todos los datos del usuario para llenar los datos de SESSION
    public function selectUser($us,$pw){
        
        $this->db->select('usuarios.codigo_us,usuarios.usuario,usuarios.foto,usuarios.tipo,usuarios.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono,datos_usuario.email,datos_usuario.municipio,usuarios.fecha_limitado');
        $this->db->from('usuarios');
        $this->db->join('datos_usuario', 'usuarios.codigo_us = datos_usuario.codigo_us');
        $this->db->where('usuario',$us);
        $this->db->where('pw',$pw);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function selectUserById($id){
        
        $this->db->select('usuarios.codigo_us,usuarios.usuario,usuarios.foto,usuarios.tipo,usuarios.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono,datos_usuario.email,datos_usuario.municipio,usuarios.fecha_limitado');
        $this->db->from('usuarios');
        $this->db->join('datos_usuario', 'usuarios.codigo_us = datos_usuario.codigo_us');
        $this->db->where('usuarios.codigo_us',$id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getTipoUs($us){
        $this->db->select('tipo');
        $this->db->form('usuarios');
        $this->db->where('usuario',$us);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function updateDataUser($id,$data){
    	try {
    		$this->db->where('codigo_us',$id);
	    	$query = $this->db->update('datos_usuario',$data);
	    	return true;
    	} catch (PDOException $e) {
    		return $e.getMessage();
    	}	
    }

    public function validatePass($id,$pw){

        $this->db->select();
        $this->db->from('usuarios');
        $this->db->where('codigo_us',$id);
        $this->db->where('pw',$pw);
        $query = $this->db->get();

        if ($query->num_rows()>0) {
            return true;
        }else{
            return false;
        }
    }

    public function updateTableUser($id,$data){
        try {
            $this->db->where('codigo_us',$id);
            $this->db->update('usuarios',$data);
            return true;
        } catch (PDOException $e) {
            return $e.getMessage();
        }   
    }

    public function changeImage($id,$data){
        try {
            $this->db->where('codigo_us',$id);
            $this->db->update('usuarios',$data);
            return true;
        } catch (PDOException $e) {
           return $e.getMessage(); 
        }
        
    }

    public function updateUsState($id,$data){
    	try {
            $this->db->where('codigo_us',$id);
            $this->db->update('usuarios',$data);
            return true;
        } catch (PDOException $e) {
            return $e.getMessage();
        }   
    }

    public function selectUserDataById($id){
        
        $this->db->select('usuarios.foto,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono,datos_usuario.email');
        $this->db->from('usuarios');
        $this->db->join('datos_usuario', 'usuarios.codigo_us = datos_usuario.codigo_us');
        $this->db->where('usuarios.codigo_us',$id);
        $query = $this->db->get();

        return $query->row_array();
    }


    public function selectAdminUsers(){

        try {
            $this->db->select('usuarios.usuario,usuarios.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono,datos_usuario.email,municipios.nombre AS municipio');
            $this->db->from('usuarios');
            $this->db->join('datos_usuario', 'usuarios.codigo_us = datos_usuario.codigo_us');
            $this->db->join('municipios', 'municipios.id = datos_usuario.municipio');
            $this->db->where('usuarios.tipo','Admin');
            $query = $this->db->get();

            return $query->result_array();
            
        } catch (PDOException $e) {
            return $e.getMessage();
        }
    }

    public function getUserByEmail($email){
        $this->db->select('usuarios.codigo_us,datos_usuario.nombres,datos_usuario.apellidos,usuarios.codigo_rec,usuarios.fecha_rec');
        $this->db->from('usuarios');
         $this->db->join('datos_usuario', 'usuarios.codigo_us = datos_usuario.codigo_us');
        $this->db->where('email',$email);
        $query = $this->db->get();

        if ($this->db->affected_rows()) {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getUserWithCode($codigo){
        $this->db->select('usuarios.codigo_us,usuarios.fecha_rec');
        $this->db->from('usuarios');
        $this->db->where('codigo_rec',$codigo);
        $query = $this->db->get();

        if ($this->db->affected_rows()) {
            return $query->row_array();
        }else{
            return false;
        }
    }

    //andoid methods

    public function selectUserByUserName($us){
        
        $this->db->select('usuarios.codigo_us,usuarios.usuario,usuarios.foto,usuarios.estado,datos_usuario.nombres,datos_usuario.apellidos,datos_usuario.telefono,datos_usuario.email,datos_usuario.municipio,municipios.nombre as mun,departamentos.nombre as departamento');
        $this->db->from('usuarios');
        $this->db->join('datos_usuario', 'usuarios.codigo_us = datos_usuario.codigo_us');
        $this->db->join('municipios','datos_usuario.municipio = municipios.id');
        $this->db->join('departamentos','municipios.departamento_id = departamentos.id');
        $this->db->where('usuarios.usuario',$us);
        $query = $this->db->get();

        return $query->row_array();
    }
    
    public function getUState($id_us){
        $this->db->select('estado');
        $this->db->from('usuarios');
        $this->db->where('codigo_us',$id_us);
        $query = $this->db->get();
        
        return $query->row_array();
    }

}

/* End of file Usuarios.php */
/* Location: ./application/models/Usuarios.php */
	
