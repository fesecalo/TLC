<?php
	
	$url='http://www.tlccourier.cl/btrace_admin/API/Tracking/index.php';

	$data=array(
		'id'=>'9400111899223094870382'
	);

	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($data),
	    ),
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, true, $context);

	echo '<pre>';
	print_r($result);
	echo '</pre>';

?>