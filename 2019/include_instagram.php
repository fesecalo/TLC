<!-- BLOCK "TYPE 7" -->
        <div class="block type-7 scroll-to-block" data-id="contact">
            <div class="container">
            <h2 class="title"><img src="img/inst3.png" style="max-width:40%" alt="@tlccourier" /></h2>
            <div>
            	<!-- LightWidget WIDGET --><script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/41cca02b8cbf5078809e383f7dfc3472.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width:100%;border:0;overflow:hidden;"></iframe>
            </div>









<?php

$apiUrl = 'https://mindicador.cl/api';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($apiUrl);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
}
 
$dailyIndicators = json_decode($json);
echo 'El valor actual de la UF es $' . $dailyIndicators->uf->valor;
echo 'El valor actual del Dólar observado es $' . $dailyIndicators->dolar->valor;
echo 'El valor actual del Dólar acuerdo es $' . $dailyIndicators->dolar_intercambio->valor;
echo 'El valor actual del Euro es $' . $dailyIndicators->euro->valor;
echo 'El valor actual del IPC es ' . $dailyIndicators->ipc->valor;
echo 'El valor actual de la UTM es $' . $dailyIndicators->utm->valor;
echo 'El valor actual del IVP es $' . $dailyIndicators->ivp->valor;
echo 'El valor actual del Imacec es ' . $dailyIndicators->imacec->valor;
?>



                
            </div>
        </div>
<!-- BLOCK "TYPE 7" -->
            