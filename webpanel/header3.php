<?php
include("../lib2/url.php");
include("../lib2/db.php");
session_start();
//$_SESSION['usuario'];

$rs_sec = dbfetch(dbselect($db,"configuracion",array("*"),"id_configuracion='1'","id_configuracion"));

function paginaactiva($a){
	$nombre_archivo = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	if ( strpos($nombre_archivo, '/') !== FALSE )
	$nombre_archivo = array_pop(explode('/', $nombre_archivo));
	if ($nombre_archivo == $a){ $activa = "active";} else { $activa = "";};
	return $activa;
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

 <!-- BEGIN HEAD -->
<head>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GARVESHOP | WEBPANEL </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/theme.css" />
    <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
	
	
    <!--END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- END PAGE LEVEL  STYLES -->
	<!-- PAGE LEVEL STYLES -->
 
</head>
     <!-- END HEAD -->
     <!-- BEGIN BODY -->
<body class="padTop53 " >

    <!-- MAIN WRAPPER -->

<div id="wrap" >        
<?php if (!isset($no_visible_superior) || !$no_visible_superior) { ?>
        <!-- HEADER SECTION -->
        <div id="top">
            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i>
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">

                     <table width="100%">
    <tr><td><? if ($rs_sec->imagen_1<>'') { ?>
          <div align="center"><img src="phpThumb.php?src=<?= $path_archivo.$rs_sec->imagen_1;?>&h=40&q=99" border="0"> 
            </div><?}?></td>
      <td><a href="index.php" class="navbar-brand">Panel - Barlosport</a> </td>
    </tr></table>

                </header>
                <!-- END LOGO SECTION -->
                <ul class="nav navbar-top-links navbar-right">

                    <!--ADMIN SETTINGS SECTIONS -->

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-user "></i>&nbsp; <i class="icon-chevron-down "></i>
                        </a>

                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="icon-user"></i> <?php echo $_SESSION['usuario'];?> </a>
                            </li>
                            <li><a href="adm_misdatos.php"><i class="icon-gear"></i> Mis Datos </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="icon-signout"></i> Logout </a>
                            </li>
                        </ul>

                    </li>
                    <!--END ADMIN SETTINGS -->
                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->
<? } ?>

<?php if (!isset($no_visible_lateral) || !$no_visible_lateral) { ?>
        <!-- MENU SECTION -->
       <div id="left" >
<?php include_once("lateral.php");?>
        </div>
        <!--END MENU SECTION --> 
<? } ?>
