<?php
class valida{
    public function __construct()    {
        session_start();
        //session_regenerate_id(true);
        if (isset($_GET["logout"])) {
            $this->Logout();
        }
        elseif ($this->Logueado() == false) {
            $this->Logout();
        }elseif ($_SESSION['VyS']=="2" && $_SESSION['YaPara']==false){
        $_SESSION['YaPara']=true;
           header("location: ".URL_SITIO."usr/index.php?p=Password&id=".$_SESSION['user_id']);
        }else{
            $_SESSION['YaPara']=false;
        }
    }

    public function Logout()    {
        $_SESSION = array();
        session_destroy();
        header('location: '.URL_SITIO.'index.php?msg=Has sido desconectado');
    }
	
    public function Logueado()    {
        if (isset($_SESSION['VyS'])) {
            return true;
        }
        return false;
    }
}
?>