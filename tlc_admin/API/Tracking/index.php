<?php
    include_once 'courrierTracking.php';

    $api = new courrierTracking();

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $api->getById($id);

    }else{
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $api->getById($id);

        }else{
            $api->error('El id es incorrecto');
        }
    }
    
?>