<?php
/** 
if(isset($_COOKIE['contador'])){ 
     setcookie('contador', $_COOKIE['contador'] + 1); 
}else{
     setcookie('contador', 1); 
} 
if (isset($_COOKIE['contador']) && $_COOKIE['contador'] >= 3){
     setcookie('contador', 0);
     unset($_COOKIE["cookie"]);
header("Location: index.php?msg=caduco".$_COOKIE['contador']); 
}
*/ 
require_once("inc/BD.php");
require_once("inc/Accion.php");
require_once("inc/Login.php");

$login = new Login();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo ST_TT;?></title>

    <!-- BOOTSTRAP STYLES-->
    <link href="tpl/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="tpl/css/font-awesome.css" rel="stylesheet" />
    <link href="tpl/css/login.css" rel="stylesheet" />
</head>
<body style="background-color: #efefef;">
    <div class="sidenav">
         <div class="login-main-text">
          <h1>
               <img src='inc/tuko.png' width="60px"> TUKO 
               <span class="h4 mb-3 font-weight-normal">SOFTWARE.</span><br>
               <span class="h4 mb-3 font-weight-normal">Sistema control de Manifiestos.</span>
          </h1>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
            <form method="post" accept-charset="utf-8" action="<?php echo URL_SITIO;?>index.php" name="loginform" autocomplete="off" role="form" class="form-signin">
               <h3>Acceso.</h3>
               <br>
               <div class="form-group">
                     <input class="form-control" placeholder="Usuario" name="usr" type="usr" autofocus required>
                  </div>
                  <div class="form-group">
                     <input class="form-control" placeholder="Password" name="psw" type="password" value="" required>
                  </div>
                    <?php echo Login::capcha("cp","vcp");?>
                  <button type="submit" class="btn btn-lg btn-black btn-block btn-signin" name="login" id="login" >Iniciar Sesion</button>
               </form>
               </div>
          <div><br>
            <?php
                if (isset($login)) {
					if ($login->msg) {
            ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Aviso!</strong>
				<?php
					foreach ($login->msg as $msg) {
						echo $msg;
					}
				?>
			</div>
			<?php
			     	}
				}
				if (isset($_GET['msg'])) {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Aviso!</strong>
				<?php echo $_GET['msg'];?>
			</div>
			<?php
               }
               ?>
               </div>
            <div >
               <div align="center">
                    &copy; TukoSoftware 2019 | Por <a href="http://www.tukosoftware.cl/">Vitorious</a>
               </div>
          </div>
         </div>
      </div>
</body>
</html>

