<?php

	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	
	// validacion con csrf tiene que ir despues de la funcion session_start()
	require $conf['path_host'].'/funciones/validar_csrf.php';

	// funcion que envia el email
	//require $conf['path_host'].'/funciones/enviar_correo.php';
    require $conf['path_host'].'/../tlc_admin/archivos_prueba/composer-phpmailer/enviarEmail.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	// valida que todos los datos sean recibidos correctamente
	if(isset($_POST['nombreEmpresa']) && strlen($_POST['nombreEmpresa']) < 60 ) {
		$nombreEmpresa=$_POST['nombreEmpresa'];
	}else{
		die("Ocurrio un problema con el nombre de la empresa ingresado");
	}

	if(isset($_POST['rut']) && valida_rut($_POST['rut'])) {
		$rut=$_POST['rut'];
	}else{
	    die("Ocurrio un problema con el RUT ingresado");
	}

	if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$email=$_POST['email'];
	}else{
		die("Ocurrio un problema con el email ingresado");
	}

	if(isset($_POST['telefono'])  ) {
		$telefono=$_POST['telefono'];
	}else{
		die("Ocurrio un problema con el numero de celular ingresado");
	}

	if(!isset($_POST['region']) && $_POST['region']>0 && $_POST['region']<16) {
		die("Ocurrio un problema con la región seleccionada");
	}else{
		$region=$_POST['region'];
	}

    /*var_dump($_POST['comuna']);
    var_dump(isset($_POST['comuna']));
    var_dump(is_int($_POST['comuna']));
    var_dump(isset($_POST['comuna']) && is_int( (int) $_POST['comuna']));*/


	if(isset($_POST['comuna'])) {
		
		$comu = $_POST['comuna'];
		
		if($region == 1 && $comu == 346 || $comu == 296 || $comu == 297 || $comu == 3 || $comu == 2 || $comu == 4 || $comu == 5 ) {
    		$comuna=$_POST['comuna'];
    	}elseif($region == 2 && $comu == 7 || $comu == 10 || $comu == 298 || $comu == 8 || $comu == 300 || $comu == 301 || $comu == 299 || $comu == 9 || $comu == 6 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 3 && $comu == 302 || $comu == 14 || $comu == 11 || $comu == 13 || $comu == 12 || $comu == 17 || $comu == 18 || $comu == 15 || $comu == 16 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 4 && $comu == 22 || $comu == 31 || $comu == 29 || $comu == 21 || $comu == 30 || $comu == 20 || $comu == 19 || $comu == 33 || $comu == 26 || $comu == 25|| $comu == 24|| $comu == 27|| $comu == 28|| $comu == 32|| $comu == 23){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 5 && $comu == 44 || $comu == 56 || $comu == 67 || $comu == 46 || $comu == 40 || $comu == 63 || $comu == 340 || $comu == 45 || $comu == 47 || $comu == 51 || $comu == 41 || $comu == 321 || $comu == 50|| $comu == 49 || $comu == 59 || $comu == 53 || $comu == 65 || $comu == 66 || $comu == 52 || $comu == 54 || $comu == 62 || $comu == 57 || $comu == 55 || $comu == 36 || $comu == 61 || $comu == 48 || $comu == 38 || $comu == 35 || $comu == 68 || $comu == 42 || $comu == 69 || $comu == 60 || $comu == 64 || $comu == 43 || $comu == 34 || $comu == 39 || $comu == 37 || $comu == 58){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 6 && $comu == 132 || $comu == 125 || $comu == 110 || $comu == 114 || $comu == 113 || $comu == 112 || $comu == 107 || $comu == 139 || $comu == 116 || $comu == 136 || $comu == 129 || $comu == 106 || $comu == 122 || $comu == 134 || $comu == 126 || $comu == 138 || $comu == 120 || $comu == 130 || $comu == 133 || $comu == 131 || $comu == 115 || $comu == 118 || $comu == 137 || $comu == 127 || $comu == 135 || $comu == 123 || $comu == 105 || $comu == 121 || $comu == 119 || $comu == 124 || $comu == 111 || $comu == 117 || $comu == 128 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 7 && $comu == 166 || $comu == 167 || $comu == 161 || $comu == 157 || $comu == 155 || $comu == 140 || $comu == 158 || $comu == 144 || $comu == 145 || $comu == 159 || $comu == 162 || $comu == 154 || $comu == 147 || $comu == 164 || $comu == 152 || $comu == 320 || $comu == 153 || $comu == 143 || $comu == 165 || $comu == 149 || $comu == 141 || $comu == 148 || $comu == 151 || $comu == 156 || $comu == 341 || $comu == 150 || $comu == 142 || $comu == 146 || $comu == 163 || $comu == 160 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 8 && $comu == 303 || $comu == 198 || $comu == 180 || $comu == 208 || $comu == 201 || $comu == 344 || $comu == 168 || $comu == 342 || $comu == 175 || $comu == 186 || $comu == 170 || $comu == 188 || $comu == 202 || $comu == 194 || $comu == 197 || $comu == 185 || $comu == 193 || $comu == 192 || $comu == 210 || $comu == 199 || $comu == 200 || $comu == 204 || $comu == 195 || $comu == 214 || $comu == 212 || $comu == 213 || $comu == 174 || $comu == 184 || $comu == 191 || $comu == 169 || $comu == 171 || $comu == 215 || $comu == 206 || $comu == 182 || $comu == 172 || $comu == 187 || $comu == 176 || $comu == 178 || $comu == 177 || $comu == 181 || $comu == 179 || $comu == 343 || $comu == 211 || $comu == 205 || $comu == 196 || $comu == 189 || $comu == 203 || $comu == 190 || $comu == 173 || $comu == 209 || $comu == 207 || $comu == 183  ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 9 && $comu == 216 || $comu == 235 || $comu == 220 || $comu == 230 || $comu == 225 || $comu == 305 || $comu == 221 || $comu == 229 || $comu == 232 || $comu == 238 || $comu == 231 || $comu == 240 || $comu == 226 || $comu == 218 || $comu == 223 || $comu == 304 || $comu == 234 || $comu == 345 || $comu == 233 || $comu == 237 || $comu == 242 || $comu == 236 || $comu == 217 || $comu == 219 || $comu == 227 || $comu == 306 || $comu == 239 || $comu == 222 || $comu == 224 || $comu == 228 || $comu == 241 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 10 && $comu == 277 || $comu == 265 || $comu == 270 || $comu == 280 || $comu == 271 || $comu == 262 || $comu == 276 || $comu == 279 || $comu == 268 || $comu == 269 || $comu == 281 || $comu == 308 || $comu == 267 || $comu == 264 || $comu == 263 || $comu == 255 || $comu == 282 || $comu == 261 || $comu == 258 || $comu == 266 || $comu == 274 || $comu == 260 || $comu == 256 || $comu == 272 || $comu == 273 || $comu == 278 || $comu == 275 || $comu == 259 || $comu == 307 || $comu == 257 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 11 && $comu == 285 || $comu == 287 || $comu == 286 || $comu == 289 || $comu == 284 || $comu == 309 || $comu == 312 || $comu == 310 || $comu == 288 || $comu == 311 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 12 && $comu == 316 || $comu == 319 || $comu == 292 || $comu == 317 || $comu == 291 || $comu == 290 || $comu == 314 || $comu == 315 || $comu == 318 || $comu == 313 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 13 && $comu == 109 || $comu == 103 || $comu == 99 || $comu == 333 || $comu == 324 || $comu == 76 || $comu == 75 || $comu == 83 || $comu == 338 || $comu == 89 || $comu == 328 || $comu == 334 || $comu == 330 || $comu == 87 || $comu == 96 || $comu == 93 || $comu == 97 || $comu == 327 || $comu == 92 || $comu == 78 || $comu == 71 || $comu == 332 || $comu == 337 || $comu == 325 || $comu == 323 || $comu == 94 || $comu == 90 || $comu == 88 || $comu == 91 || $comu == 339 || $comu == 104 || $comu == 336 || $comu == 85 || $comu == 322 || $comu == 101 || $comu == 72 || $comu == 82 || $comu == 100 || $comu == 79 || $comu == 81 || $comu == 329 || $comu == 77 || $comu == 98 || $comu == 335 || $comu == 102 || $comu == 95 || $comu == 108 || $comu == 326 || $comu == 70 || $comu == 73 || $comu == 84 || $comu == 86 || $comu == 80 || $comu == 331 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 14 && $comu == 244 || $comu == 248 || $comu == 251 || $comu == 254 || $comu == 249 || $comu == 247 || $comu == 246 || $comu == 245 || $comu == 243  || $comu == 250 || $comu == 252 || $comu == 253 ){
    	    $comuna=$_POST['comuna'];
    	}elseif($region == 15 && $comu == 1 || $comu == 295 || $comu == 293 || $comu == 294 ){
    	    $comuna=$_POST['comuna'];
    	}else{
    	    die("Ocurrio un problema con la comuna seleccionada");
    	}
		
	}else{
	    die("Ocurrio un problema con la comuna seleccionada");
	}

	if(!isset($_POST['direccion'])) {
		die("Ocurrio un problema con la dirección ingresada");
	}else{
		$direccion=$_POST['direccion'];
	}

	if(!isset($_POST['pass'])) {
		die("Ocurrio un problema con la contraseña ingresada");
	}else{
		$pass=$_POST['pass'];
	}

	if(!isset($_POST['promoap'])) {
		die("Ocurrio un problema con la contraseña ingresada");
	}else{
		$promoap=$_POST['promoap'];
	}
	
	/*
	if(!isset($_POST['empresa'])) {
		die("Ocurrio un problema al determinar si el usuario es de Empresa o no");
	}else{
		$empresa=$_POST['empresa'];
	}
	*/
	// fin validacion de datos recibidos

	// Valida que el email ingresado no este registrado
	$db->prepare("SELECT * FROM gar_usuarios WHERE email=:correo ");
	$db->execute(array(':correo' => $email ));
	$correo = $db -> get_results();
	// fin validacion de email

	if(!empty($correo)){
		die("El email ingresado ya esta en uso, por favor ingrese otro email");
	}

    /*var_dump("INSERT INTO gar_usuarios SET 
		tipo_usuario=3, 
		pass='".hash('sha256', $pass)."', 
		rut='".$rut."', 
		email='".$email."', 
		nombre='".$nombre."',
		apellidos='".$apellido_p."',
		telefono='".$telefono."',
		direccion='".$direccion."',
		id_region='".$region."',
		id_comuna='".$comuna."',
		fecharegistro='".$fecha_actual."',
		tipo_cliente=1,
		usuario='',
		nombre_empresa='',
		id_cliente='',
		ultima_sesion=now(),
		promoap='".$promoap."'
	");*/


	// realiza el insert en la tabla usuario
	$db->prepare("INSERT INTO gar_usuarios SET 
		tipo_usuario=3, 
		pass=:pass_usu, 
		rut=:rut_usu, 
		email=:email_usu, 
		nombre_empresa=:nombre_emp,
		telefono=:telefono_usu,
		direccion=:direccion_usu,
		id_region=:region_usu,
		id_comuna=:comuna_usu,
		fecharegistro=:fecha,
		tipo_cliente=2,
		usuario='',
		nombre='',
		apellidos='',
		id_cliente='',
		ultima_sesion=now(),
		promoap=:promoap
	");
	$db->execute(
		array(
			':pass_usu' => hash('sha256', $pass),
			':rut_usu' => $rut,
			':email_usu' => $email,
			':nombre_emp' => $nombreEmpresa,
			':telefono_usu' => $telefono,
			':direccion_usu' => $direccion,
			':region_usu' => $region,
			':comuna_usu' => $comuna,
			':fecha' => $fecha_actual,
			':promoap' => $promoap
	));
	
	//$salida = $db->get_results();
	//var_dump($salida);die();

    function valida_rut($rut) {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;
        foreach(array_reverse(str_split($numero)) as $v)
        {
            if($i==8) $i = 2;
            $suma += $v * $i;
            ++$i;
        }
    
        $dvr = 11 - ($suma % 11);
        
        if($dvr == 11) $dvr = 0;
        if($dvr == 10) $dvr = 'K';
    
        if($dvr == strtoupper($dv)) { return true; } else { return false; }
    }

	$id_usuario=$db->lastId();
	// fin inser de direcciones de usuario

	// obtiene el nombre de la region
	$db->prepare("SELECT * FROM region WHERE id_region=:id_region");
	$db->execute(array(':id_region' => $region ));
	$resRegion=$db->get_results();

	$nombre_region=$resRegion[0]->nombre_region;

	// obtiene el nombre de la comuna
	$db->prepare("SELECT * FROM comunas WHERE id_comuna=:id_comuna");
	$db->execute(array(':id_comuna' => $comuna ));
	$resComuna=$db->get_results();

	$nombre_comuna=$resComuna[0]->nombre_comuna;

//----------------------------------MENSAJE CLIENTE-----------------------------------------------------------------

	// $correoEmail='axel.lanas@hotmail.cl';
	$correoEmail=$email;
	$mensaje="
        <title>TLC Courier</title>
        <table width=531 border=0 align=center cellpadding=0 cellspacing=0>
            <tbody>
                <tr>
                    <td colspan=3 align=left valign=top></td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top bgcolor=#0161AC>
                        <img src=http://tlccourier.cl/inicio/images/banda_mail.png width=531 height=96>
                    </td>
                </tr>
                <tr>
                    <td width=16 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                    <td width=500 align=left valign=top bgcolor=#FFFFFF>
                        <table width=490 border=0align=center cellpadding=0 cellspacing=0 bordercolor=#CCCCCC>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <tbody>
                                <tr>
                                    <td align=center valign=top bgcolor=#FFFFFF>
                                        <table width=400 border=0 cellpadding=0 cellspacing=0>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <font style=font-size:10pt; color=#0161AC face=Arial size=1>Felicitaciones <strong>".$nombreEmpresa.": </strong> Ya eres parte tlccourier, a partir de ahora todas tus compras en USA o el mundo nosotros lo traemos.</font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align=center>
                                                    <font style=font-size: 13pt; color=#0161AC face=Arial><strong><br>
                                                    Tus accesos para My TLC son:</strong></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align=center>
                                                    <table width=450 border=0 bgcolor=#0161AC cellpadding=3 cellspacing=0>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 15pt; color=#FFFFFF face=Arial ><strong> Numero de cliente: ".$id_usuario."</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 15pt; color=#FFFFFF face=Arial><strong style=text-decoration:none> Correo: ".$correoEmail."</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 15pt; color=#FFFFFF face=Arial ><strong>Contraseña: ".$pass."</strong></font>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <br/>

                                                    <table width=450 border=0 bgcolor=#0161AC cellpadding=3 cellspacing=0>
                                                        <tr >
                                                            <td align=center bgcolor=#FFFFFF >
                                                                <font style=font-size:10pt; color=#0161AC face=Arial><strong>Para efectuar tus compras, debes ingresar la informaci&oacute;n <br>
                                                                de la siguiente forma:</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Name:&nbsp;".$nombreEmpresa."&nbsp;</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Address line 1:&nbsp;8256 N. W 30 TH TERRACE</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center ><font style=font-size: 13pt; color=#FFFFFF face=Arial >
                                                                <strong>Address line 2: TLC-".$id_usuario."</strong><br>
                                                                <em>(!) siempre debes ingresar tu código</em></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>City:&nbsp;MIAMI</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>State:FLORIDA</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Zipcode:33122-1914</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align=center >
                                                                <font style=font-size: 13pt; color=#FFFFFF face=Arial ><strong>Phone:786-6158656</strong></font>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height=10></td> 
                                                        </tr>
                                                    </table>
                                                    <br><br>

                                                    <table width=450 border=0  bordercolor=#CCCCCC cellpadding=3 cellspacing=0>
                                                        <tr>
                                                            <td height=10></td>
                                                        </tr>

                                                        <tr>
                                                            <td align=center bgcolor=#FFFFFF> 
                                                                <font style=font-size:10pt; color=#0161AC face=Arial ><em><strong>IMPORTANTE:</strong><br />
                                                                NUNCA enviaremos un e-mail solicitando tus claves o datos personales y SIEMPRE nos dirigiremos a ti por tu nombre y apellido.<br />
                                                                Nunca reveles tus claves.<br />
                                                                Mantén tus datos actualizados.</em></font>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <tr>
                                <td height=30 align=center valign=bottom>
                                    <font style=font-size: 10pt; color=#0161AC face=Arial size=2 >www.tlccourier.cl - &copy; Todos los Derechos Reservados</font>
                                </td>
                            </tr>
                            &nbsp;&nbsp;&nbsp;
                        </table>
                    </td>
                    <td width=15 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                    &nbsp; 
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top bgcolor=#F5F5F5>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top bgcolor=#0161AC>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan=3 align=left valign=top></td>
                </tr>
            </tbody>
        </table>
    ";
	
	enviarCorreo($correoEmail,'Bienvenido a TLC Courier',$mensaje);

//------------------------------------------------------------------------------------------------------------------
    
	header("location:".$conf['path_host_url']."/usuario_registro/msj_registro_usuario.php");
	die();
?>