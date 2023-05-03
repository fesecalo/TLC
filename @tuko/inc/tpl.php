<?php
class Templeta {
	public static function msg($msg,$color){
	switch ($color) {
		case 'ok':
			$c='success';
			$i='check-circle';
			break;
		case 'nok':
			$c='danger';
			$i='times-circle';
			break;
		case 'info':
			$c='info';
			$i='info-circle ';
			break;
		case 'pre':
			$c='warning';
			$i='exclamation-circle';
			break;
	}
	include("../tpl/msg.php");
	}
	
	public function cab(){
        include("../tpl/cab.php");
	}
	
	public function pie(){
        include("../tpl/pie.php");
	}
	
	public function nav($pagina){
        $$pagina = 'active-menu';
        $mca = array("prod", "mark", "cat", "oft");
        $mcb = array("usr", "suc");
        $vca = in_array($pagina, $mca)?'collapse in':'';
        $vcb = in_array($pagina, $mcb)?'collapse in':'';
        include("../tpl/nav.php");
	}
}
?>