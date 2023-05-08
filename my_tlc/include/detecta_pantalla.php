<?php
// FUNCION QUE DETECTA EL TIPO DE PANTALLA DEL SIPOSITIVO QUE ESTA ACCEDIENDO A LA WEB
$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
if ($tablet_browser > 0) {
// Si es tablet has lo que necesites
   $msg_tabla=1;
}
else if ($mobile_browser > 0) {
// Si es dispositivo mobil has lo que necesites
   $msg_tabla=1;
}
else {
// Si es ordenador de escritorio has lo que necesites
   $msg_tabla=0;
} 
// FIN FUNCION QUE DETECTA EL TIPO DE PANTALLA DEL SIPOSITIVO QUE ESTA ACCEDIENDO A LA WEB

// FUNCION QUE DETECTA DESDE QUE NAVEGADOR SE ESTA ACCEDIENDO AL SITIO WEB
$user_agent = $_SERVER['HTTP_USER_AGENT'];
 
function getBrowser($user_agent){
 
    if(strpos($user_agent, 'MSIE') !== FALSE)
        // return 'Internet explorer';
        return 1;
    elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
        // return 'Microsoft Edge';
        return 2;
    elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
        // return 'Internet explorer';
        return 3;
    elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
        // return "Opera Mini";
        return 4;
    elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
        // return "Opera";
        return 5;
    elseif(strpos($user_agent, 'Firefox') !== FALSE)
        // return 'Mozilla Firefox';
        return 6;
    elseif(strpos($user_agent, 'Chrome') !== FALSE)
        // return 'Google Chrome';
        return 7;
    elseif(strpos($user_agent, 'Safari') !== FALSE)
        // return "Safari";
        return 8;
    else
        // return 'No hemos podido detectar su navegador';
        return 0;
 
}
 
$navegador = getBrowser($user_agent);

// FIN FUNCION QUE DETECTA DESDE QUE NAVEGADOR SE ESTA ACCEDIENDO AL SITIO WEB
?>