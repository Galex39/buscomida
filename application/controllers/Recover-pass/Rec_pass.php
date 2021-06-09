<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'phpMailer/phpMailer.php';
// require 'phpMailer/PHPMailer.php';
// require 'phpMailer/SMTP.php';

class Rec_pass extends CI_Controller {

	public function index(){
		$this->load->view('Forgot-password/Forgot-password');
	}

	public function sendRecoveryCode(){

    	$this->load->model('usuarios/Usuarios_model');

        $correoElectronico = $this->input->post('email');
        $codigo = $this->createRandomCode();
        $fechaRecuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));
        
        $data_us = $this->Usuarios_model->getUserByEmail($correoElectronico);

        if ($data_us === false) {
            $error['error'] = 'ERR_EMAIL';
            $this->load->view('Forgot-password/Forgot-password',$error);
        } else {
        	$updata = array(
        		'codigo_rec' => $codigo,
        		'fecha_rec' => $fechaRecuperacion
        	);
            $respuesta = $this->Usuarios_model->updateTableUser($data_us['codigo_us'],$updata);
        
            if ($respuesta) {
            	$nombre_c = $data_us['nombres'].' '.$data_us['apellidos'];
                $this->sendMail($correoElectronico, $nombre_c, $codigo);
                
                $error['error'] = 'SUCC_EMAIL';
                $this->load->view('Forgot-password/Forgot-password',$error);
            } else {
                $error ['error']  = 'ERR_SEND';
                $this->load->view('Forgot-password/Forgot-password',$error);
            }
        }
    }

    public function newPassword($code = null){
        $this->load->model('usuarios/Usuarios_model');
        if (isset($code)) {
            $user = $this->Usuarios_model->getUserWithCode($code);

            if ($user === false) {
                $error ['error'] = 'ERR_CODE';
                $this->load->view('Forgot-password/Forgot-password',$error);
            }else {
                $current = date("Y-m-d H:i:s");

                if (strtotime($current) > strtotime($user['fecha_rec'])) {
                    $error ['error'] = 'ERR_VEN';
                    $this->load->view('Forgot-password/Forgot-password',$error);
                }else {
                    $data ['user'] = $user ['codigo_us'];
                    $this->load->view('Recover-pass/Recover_pass',$data);
                }
            }
        } else {
            // redirect('inicio');
        }
    }

    public function updatePasswordWithCode(){

        $this->load->model('usuarios/Usuarios_model');

        $codigo_us = $this->input->post('codigo_us');
        $contrasena = md5($this->input->post('newPass'));
        $repetirContrasena = md5($this->input->post('confPass'));

        if ($contrasena != $repetirContrasena) {

            $data ['user'] = $codigo_us;
            $data ['error'] = 'ERR_CON';
            $this->load->view('Recover-pass/Recover_pass',$data);

        } else {
            

            $epass['pw'] = sha1($contrasena);

            $resultado = $this->Usuarios_model->updateTableUser($codigo_us, $epass);
            if ($resultado) {
                
                $error ['error'] = 'SUCC_CPW';
                $this->load->view('Login/login',$error);

            } else {
                $data ['user'] = $codigo_us;
                $data ['error'] = 'ERR_CPW';
                $this->load->view('Recover-pass/Recover_pass',$data);
            }
        }
    }

    public function sendMail($correoElectronico, $nombre, $codigo){
        $template = file_get_contents('http://buscomida.info/buscomida/index.php/Template/Template');
        $template = str_replace("{{name}}", $nombre, $template);
        $template = str_replace("{{action_url_2}}", '<b>'.base_url().'index.php/Recover-pass/Rec_pass/newPassword/'.$codigo.'</b>', $template);
        $template = str_replace("{{action_url_1}}", base_url().'index.php/Recover-pass/Rec_pass/newPassword/'.$codigo, $template);
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{operating_system}}", $this->getOS(), $template);
        $template = str_replace("{{browser_name}}", $this->getBrowser(), $template);

        $this->load->library("email");

        //configuracion para gmail
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'buscomidasen@gmail.com',
            'smtp_pass' => 'temporal12345',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        //cargamos la configuración para enviar con gmail
        $this->email->initialize($configGmail);

        $this->email->from('buscomidasen@gmail.com');
        $this->email->to($correoElectronico);
        $this->email->subject('BusCOmida');
        $this->email->message($template);

        //Se envia el email
        $this->email->send();
    }

    public function createRandomCode(){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
    
        return time().$pass;
    }

    public static function getOS(){

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    public static function getBrowser(){

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        $browser        = "Unknown Browser";

        $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

}

/* End of file Rec_pass.php */
/* Location: ./application/controllers/Recover-pass/Rec_pass.php */