<?php
$nox=isset($_GET['p'])?$_GET['p']:$_POST["p"];
switch ($nox) {
case 'Lista':
	$p = new datos();
	$row1 = $p->traeTodo((isset($_POST['b'])?$_POST['b']:$_GET['b']));
	$pag = (isset($_REQUEST['pag']) && !empty($_REQUEST['pag']))?$_REQUEST['pag']:1;
	$totalReg = $row1->num_rows;
	$total_paginas = ceil($totalReg / NPAG);
	$inicioPag = ($pag - 1) * NPAG;
	$row = $p->traeFiltro((isset($_POST['b'])?$_POST['b']:$_GET['b']),$inicioPag);

	include("vista/Lista_vista.php");
	include("vista/Nuevo_vista.php");
	break;
case 'Nuevo':
	if(isset($_POST["idnv"])){
		$p = new datos();
		$p->nombre = $_POST["nombre"];
		$p->usuario = $_POST["usuario"];
		$p->clave = crypt($_POST['clave'],$_POST['usuario']);
		$p->tipo = $_POST["tipo"];
		$p->estado = 2;
		$p->fecha = date("d-m-Y H:i:s");
		$nox =$p->crear();
		echo Accion::creaUrl($pagina,'Lista',$nox[0],$nox[1]);
	}
	break;
case 'Editar':
	if(isset($_POST["ided"])){
		$p = new datos();
		$p->id = $_POST["ided"];
		$p->nombre = $_POST["nombre"];
		$p->usuario = $_POST["usuario"];
		$p->tipo = $_POST["tipo"];
		$nox =$p->editar();
		echo Accion::creaUrl($pagina,'Lista',$nox[0],$nox[1]);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXid();
		include("vista/Editar_vista.php");
	}
	break;
case 'Eliminar':
	if(isset($_POST["idel"])){
		$p = new datos();
		$p->id = $_POST["idel"];
		$p->nombre = $_POST["nombre"];
		$nox =$p->eliminar();
		echo Accion::creaUrl($pagina,'Lista',$nox[0],$nox[1]);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXid();
		include("vista/Eliminar_vista.php");
	}
	break;
case 'Password':
	if(isset($_POST["idpass"])){
		$p = new datos();
		$p->id = $_POST["idpass"];
		$p->nombre = $_POST["nombre"];
		$p->estado = 1;
		$nox =$p->editarPass($_POST["clavea"],$_POST["clavear"],$_POST["usuario"]);
		echo Accion::creaUrl($pagina,'Lista',$nox[0],$nox[1]);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXid();
		include("vista/Pass_vista.php");
	}
	break;
default:
	$p = new datos();
	$row1 = $p->traeTodo((isset($_POST['b'])?$_POST['b']:$_GET['b']));
	$pag = (isset($_REQUEST['pag']) && !empty($_REQUEST['pag']))?$_REQUEST['pag']:1;
	$totalReg = $row1->num_rows;
	$total_paginas = ceil($totalReg / NPAG);
	$inicioPag = ($pag - 1) * NPAG;
	$row = $p->traeFiltro((isset($_POST['b'])?$_POST['b']:$_GET['b']),$inicioPag);

	include("vista/Lista_vista.php");
	include("vista/Nuevo_vista.php");
	break;
}
?>