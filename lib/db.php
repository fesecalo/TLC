<?php
include($url_base."lib/conf.php");

function chequearerror(){
  if (mysql_errno())
  echo "SQL ERROR ".mysql_error();
}

function dbconectar($sid, $usr, $pwd){
          global $sid_db, $usr_db, $pwd_db;
          if (!isset($usr))
            $usr = $usr_db;
          if (!isset($pwd))
            $pwd = $pwd_db;
          if (!isset($sid))
            $sid = $sid_db;
        $db = mysql_connect($sid_db,$usr_db,$pwd_db);
        chequearerror();
    return $db;
}



function dbclose($db){
  mysql_close($db);
}

function dbuse($db,$bd){
  dbquery($db,"USE $bd");
}

function dbquery($db,$sql){
        if (!isset($db))
            $db = dbconectar();
        	mysql_query("Use barlosport_barlopanel",$db);
            $r=mysql_query($sql,$db);
            chequearerror();
            return $r;
}

function dbfetch($resultado){
  $objeto = mysql_fetch_object($resultado);
  return $objeto;
}

function dbfreeresult($resultado){
  mysql_free_result($resultado);
}

function dbselect($db, $tabla, $campos,$where,$order){
 $sql = "Select ";
  for($i=0; $i < count($campos);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $campos[$i]";
  }
  $sql="$sql from $tabla ";
  if (isset($where))
    $sql="$sql where $where ";
  if (isset($where))
    $sql="$sql order by $order ";
	//echo $sql."<br>";	
  return dbquery($db,$sql);
}

function dbselect2($db, $tabla, $campos){
 $sql = "Select ";
  for($i=0; $i < count($campos);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $campos[$i]";
  }
  $sql="$sql from $tabla ";
//echo $sql;	
  return dbquery($db,$sql);
}

function dbinsert($db, $tabla, $campos, $valores){
  $sql = "Insert into $tabla (";
  for($i=0; $i < count($campos);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $campos[$i]";
  }
  $sql="$sql) values (";
  for($i=0; $i < count($valores);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $valores[$i]";
  }
  $sql="$sql )";
 // echo $sql;
  return dbquery($db,$sql);
}

function dbinsertblobs($db, $tabla, $campos, $valores,$campos_blob,$valores_blob){
  $sql = "Insert into $tabla (";
  for($i=0; $i < count($campos);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $campos[$i]";
  }
  for($i=0; $i < count($campos_blob);$i++){
    if (($i > 0) || (count($campos) > 0))
       $sql="$sql,";
    $sql="$sql $campos_blob[$i]";
  }
  $sql="$sql) values (";
  for($i=0; $i < count($valores);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $valores[$i]";
  }

  for($i=0; $i < count($valores_blob);$i++){
    if (($i > 0) || (count($valores) > 0))
       $sql="$sql,";
    $sql="$sql LOAD_FILE(\"".addslashes($valores_blob[$i])."\")";
  }
  $sql="$sql )";
  return dbquery($db,$sql);
}

function dbupdate($db, $tabla, $campos, $valores,$campos_llave,$valores_llave){
  $sql = "Update $tabla set ";
  for($i=0; $i < count($campos);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $campos[$i] = $valores[$i]";
  }
  if (count($campos_llave)){
    $sql="$sql where ";
    for($i=0; $i < count($campos_llave);$i++){
      if ($i > 0)
        $sql="$sql and ";
      $sql="$sql $campos_llave[$i]=$valores_llave[$i]";
    }
  }
  //echo $sql;
  return dbquery($db,$sql);
}

function dbupdateblobs($db, $tabla, $campos, $valores,$campos_llave,$valores_llave){
  $sql = "Update $tabla set ";
  for($i=0; $i < count($campos);$i++){
    if ($i > 0)
       $sql="$sql,";
    $sql="$sql $campos[$i] = LOAD_FILE(\"".addslashes($valores[$i])."\")";
  }
  if (count($campos_llave)){
    $sql="$sql where ";
    for($i=0; $i < count($campos_llave);$i++){
      if ($i > 0)
        $sql="$sql and ";
      $sql="$sql $campos_llave[$i]=$valores_llave[$i]";
        }
  }
  return dbquery($db,$sql);
}

function dbdelete($db, $tabla, $campos_llave,$valores_llave){
  $sql = "Delete from $tabla ";
  if (count($campos_llave)){
    $sql="$sql where ";
    for($i=0; $i < count($campos_llave);$i++){
      if ($i > 0)
        $sql="$sql and ";
      $sql="$sql $campos_llave[$i]=$valores_llave[$i]";
    }
  }
  return dbquery($db,$sql);
}
?>
