<?php
	$p = new datos();
	$p->fi=(isset($_GET['fi'])?date("d-m-Y", strtotime($_GET['fi'])):"01-".date("m-Y"));
	$p->ff=(isset($_GET['ff'])?date("d-m-Y", strtotime($_GET['ff'])):date("d-m-Y"));
	include("html.php");
?>