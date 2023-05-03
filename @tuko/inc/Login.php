<?php
class Login
{
    private $row = null;
    public $msg = array();
	
    public function __construct()    {
        if (isset($_POST["login"])) {
            $this->Login();
        }
    }
	
    private function Login()    {
        if (empty($_POST['usr'])) {
            $this->msg[] = "Nombre de usuario en blanco.";
			
        } elseif (empty($_POST['psw'])) {
            $this->msg[] = "Clave en blanco.";
			
        } elseif (empty($_POST['cp'])) {
            $this->msg[] = "Debe completar capcha.";
			
        } elseif ($_POST['cp']!=Accion::desencriptar($_POST['vcp'])) {
            $this->msg[] = "Error en respuesta capcha.";
			
        } elseif (!empty($_POST['usr']) && !empty($_POST['psw'])) {
            
			$sql = "SELECT * FROM ".DB_PRE."_usuario WHERE usuario = '" . BD::Escape(filter_var($_POST['usr'], FILTER_SANITIZE_STRING)). "';";
			$row = BD::Consulta($sql);
			if ($row->num_rows == 1) {
                $r = $row->fetch_object();
                if ($r->estado==2 && (crypt($_POST['psw'],$_POST['usr'])== $r->clave)){
                    session_start();
                        $_SESSION['VyS'] = $r->estado;
                        $_SESSION['user_id'] = $r->id;
                        $_SESSION['user_name'] = $r->nombre;
                        $_SESSION['user_tipo'] = $r->tipo;
                        $this->msg[] = $_SESSION['VyS'];
                        header("location: ".URL_SITIO."usr/index.php?p=Password&id=".$_SESSION['user_id']);
                }else{
                    if (crypt($_POST['psw'],$_POST['usr'])== $r->clave) {
                        session_start();
                        $_SESSION['VyS'] = $r->estado;
                        $_SESSION['user_id'] = $r->id;
                        $_SESSION['user_name'] = $r->nombre;
                        $_SESSION['user_tipo'] = $r->tipo;
                        $this->msg[] = $_SESSION['VyS'];
                        header("location: ".URL_SITIO."usr/index.php");
                    } else {
                        $this->msg[] = "Contraseña no coinciden.";
                    }
                }
			} else {	
			    $this->msg[] = "Usuario erroneo.";
			}
        }
    }

    public static function capcha($valor,$valida){
        $n1 = rand(1,2);
       
       $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $letra = '';
       for ($i = 0; $i < 3; $i++) {
           $letra .= $letras[rand(0, 25)];
       }
       $nums = '0123456789';
       $num = '';
       for ($i = 0; $i < 2; $i++) {
           $num .= $nums[rand(0, 9)];
       }
       ($n1==1)?$cadena=$letra." ".$num:$cadena=$num." ".$letra;
       
       echo "<h4>CODIGO CAPTCHA</h4>
            <div class='form-group'>
            <div class='col-sm-4'>
                <img src='".URL_SITIO."inc/Capcha.php?c=".Accion::encriptar($cadena)."' width='80px' />
            </div>
            <div class='col-sm-8'>   
                <input type='text' class='form-control' placeholder='Que dice la imagen?' name='".$valor."' id='".$valor."' size='8' required>
            </div>
           </div>
           <p><input type='hidden' name='".$valida."' id='".$valida."' value='".Accion::encriptar($cadena)."'>&nbsp;</p>";
    }
}
?>