
<head>
  <!-- META TAGS -->
  <meta content="text/html; charset=UFT8" http-equiv=Content-Type>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <meta http-equiv="Content-Language" content="es-ES">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
  <!-- FIN TAGS -->

  <title><?php echo $conf['path_company_name']; ?> - Tracking</title>
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?php echo $conf['path_host_url'] ?>/css/bootstrap.min3.3.2.css" >

  <link rel="stylesheet" href="<?php echo $conf['path_host_url'] ?>/css/<?= $conf['path_theme_styles'] .'?v=' . date('Ymdhis') ?>">
  <link rel="stylesheet" href="<?php echo $conf['path_host_url'] ?>/css/queries.css">
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="<?php echo $conf['path_host_url'] ?>/css/font-awesome.css"> -->

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Sintony:400,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

  <!-- Datepicker -->
  <link href="<?php echo $conf['path_host_url'] ?>/css/datepicker/<?php echo $conf['path_theme_bootstrap'] ?>" rel="stylesheet" media="screen">
  <link href="<?php echo $conf['path_host_url'] ?>/css/datepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

  <!-- estilo de las tablas responsivas -->
  <link rel="stylesheet" href="<?php echo $conf['path_host_url'] ?>/css/DataTables/dataTables.css">
  <link rel="stylesheet" href="<?php echo $conf['path_host_url'] ?>/css/DataTables/dataTables.responsive.css">
  <!-- fin estilo de las tablas responsivas -->

  <div id="fb-root"></div>

  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;

      js = d.createElement(s); js.id = id;

      js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.3";

      fjs.parentNode.insertBefore(js, fjs);
    }
    (document, 'script', 'facebook-jssdk'));
  </script>	

</head>