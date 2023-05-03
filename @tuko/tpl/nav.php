<nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src='../inc/tuko.png' style="width: 60px;" > Tuko<span class="h6">Software</span></a>
            </div>
            <div class="header-right">
            
          <ul class="navbar-nav">
            <li class="dropdown">
                <b id="navbarDropdown" class='btn btn-primary' role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i> ..:: MiMenu ::.. </b>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a href="<?php echo URL_SITIO;?>usr/?p=Password&id=<?php echo $_SESSION['user_id']?>" style="width: 100%;" title='Cambio de Clave'>
                    Cambio de clave <i class="fa fa-lock fa-lg btn btn-info"></i>
                </a>
                <br>
                <a href="?logout=1" style="width: 100%;" title="Logout">
                    Salir <i class="fa fa-exclamation-circle fa btn btn-danger"></i>
                </a>
              </div>
            </li>
        </ul>
        </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">   
                <li>
                        <div class="user-img-div">
                        <i class="fa fa-user fa-lg img-thumbnail"></i> <b class="inner-text"><?php echo $_SESSION['user_name'];?></b>
                        <br>
                        <small class="inner-text">
                        <i class="fa fa-plug"></i> Perfil: <?php echo Accion::perfil($_SESSION['user_tipo']);?>
                        </small>
                        <br>
                        <small class="inner-text">
                            <i class="fa fa-calendar"></i> <?php echo date ("d/m/Y");?>
                        </small>
                        </div>
                    </li>             
                    <li>
                        <a class="<?php echo $dsh;?>" href="<?php echo URL_SITIO;?>dsh/" ><i class="fa fa-tachometer"></i>Dashboard</a>
                    </li>

                    <li>
                        <a class="<?php echo $manifiesto;?>" href="<?php echo URL_SITIO;?>manifiesto/"><i class="fa fa-cubes"></i>Manifiestos</a>
                    </li>
                    
                    <li>
                        <a class="<?php echo $cliente;?>" href="<?php echo URL_SITIO;?>cliente/"><i class="fa fa-child"></i>Clientes</a>
                    </li>
                    <li>
                        <a class="<?php echo $origen;?>" href="<?php echo URL_SITIO;?>origen/"><i class="fa fa-group"></i>Socios</a>
                    </li>

                    <li>
                        <a class="<?php echo $usr;?>" href="<?php echo URL_SITIO;?>usr/"><i class="fa fa-user"></i>Usuarios</a>
                    </li>
                </ul>

            </div>

        </nav>