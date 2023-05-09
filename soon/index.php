<!DOCTYPE HTML><head><title>TLC Courier</title>
		
	<link href="css/style.css" rel="stylesheet" type="text/css"  media="all" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js" type="text/javascript"></script>
	    <script src="js/countdown.js" type="text/javascript"></script>	
	    <script src="js/init.js" type="text/javascript"></script>
	    <link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>

  

<script language="javascript" type="text/javascript">

    //*** Este Codigo permite Validar que sea un campo Numerico
    function Solo_Numerico(variable){
        Numer=parseInt(variable);
        if (isNaN(Numer)){
            return "";
        }
        return Numer;
    }
    function ValNumero(Control){
        Control.value=Solo_Numerico(Control.value);
    }
    //*** Fin del Codigo para Validar que sea un campo Numerico

</script>
    
	</head>
	<body>
		<div class="container1">
		<!-----start-wrap----->
		<div class="wrap">
			<!-----start-Content----->
			<div class="content">
				<div class="content-header">
       
                <p style="margin-top:-80px; margin-bottom:30px;"><img src="images/logo.png"></p>
					<h1>PRONTO</h1>
					<!--p>Ya no es un simple rumor...</p-->
				</div>
				<!---start-countdown-timer----->
                
                
                <ul style=" text-align:center; color: #FFF;
	font-size: 35px;
	font-weight: bold;
	display: inline-block;
    margin-left:23%; margin-top:40px;">
					<li>
						
						


					</li>	
				</ul>
                       
				<!--ul id="countdown">
					<li>
						<span class="days">  </span>
						<h3>D&iacute;as</h3>
					</li>
					<li>
						<span class="hours">02</span>
						<h3>Horas</h3>
					</li>
					<li>
						<span class="minutes">00</span>
						<h3>Minutos</h3>
					</li>
					<li>
						<span class="seconds">53</span>
						<h3>Segundos</h3>
					</li>	
				</ul-->
				<!---End-countdown-timer----->
				<!---start-notifie----->
				<div class="notify" class="main clearfix column">
						<!--input type="text" class="textbox" style="width:50%" value="Tu email:" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Tu email';}"-->
						<input  class="md-trigger md-setperspective" data-modal="top-scorll" type="button" value="&iquest;QUIERES SABER MAS?">
					<div class="md-modal md-effect-19" id="top-scorll">
						<div class="md-content">
							<h3></h3>
							<div>
								                    <form action="enviar_contacto.php"  method="post" enctype="multipart/form-data" onSubmit="javascript:return valida()" name="formulario">
<p>	
						<input type="text" class="textbox" style="width:50%; margin-bottom:5px;" name="nombre" placeholder="Nombre" required>
                        <input type="text" class="textbox" style="width:50%;margin-bottom:5px;" name="email"  placeholder="Email" onClick="return direccionEmail(email,'email' )" required>
						<input type="text" class="textbox" style="width:50%; margin-bottom:5px;" name="telefono" placeholder="FONO" onkeyUp="return ValNumero(this);"  required>

                                                            
<!-- DATOS DOCUMENTO-->
<input name='folio' type="hidden"  value='TLC-<?php
$numero = rand(1,9999);
echo "$numero";
?>'>

<!--FECHA Y HORA-->  
<input id="fecha" name="fecha" value="<?php  echo date("d M, Y g:i");?>" type="hidden">
						
					</p>
                    <p style="text-align:center; margin-left:20%"><input type="submit"  style="margin-bottom:8px; padding: 12px;
	border: none;
	outline: none;
	font-family: 'bebasregular';
	background: #CCCCCC;
	-webkit-transition: all 0.3s ease-out;
	-moz-transition: all 0.3s ease-out;
	-ms-transition: all 0.3s ease-out;
	-o-transition: all 0.3s ease-out;
	transition: all 0.3s ease-out;
	color: #FFF;
	cursor:pointer;
	display:block;
	word-spacing: 0.2em; margin-left:25%;" value="ENVIAR"></p>
                                        
                    </form>
								<button class="md-close">MAS ADELANTE</button>
							</div>
						</div>
					</div>
					<script src="js/classie.js"></script>
					<script src="js/modalEffects.js"></script>
					<script>
						// this is important for IEs
						var polyfilter_scriptpath = '/js/';
					</script>
				</div>
				<!---End-notifie----->
				<!---start-social-icons---->
				<div class="social-icons">
					<h3>S&iacute;guenos</h3>
							<ul>
							<li><a target="_blank" href="https://www.facebook.com/tlccourier"><img src="images/facebook.png" title="facebook"></a></li>
						</ul>
				</div>
				<!---End-social-icons---->
				<!---start-copy-right---->
				<div class="copy-right">
					<p>TLC Courier 2017 <a href="http://www.tlccourier.cl">www.tlccourier.cl</a></p>
				</div>
				<!---End-copy-right---->
			</div>
			<!-----End-Content----->
		</div>
		<!-----End-wrap----->
		</div>
	</body>
</html>

