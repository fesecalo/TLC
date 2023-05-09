<?
$mime=array("doc"=>"text/doc","doc"=>"application/msword");
$mime=array("xls"=>"text/xls","xls"=>"application/x-msexcel");
$mime=array("xls"=>"text/xls","xls"=>"application/vnd.ms-excel");
$mime=array("pdf"=>"text/pdf","pdf"=>"application/pdf");
$mime=array("ppt"=>"text/ppt","ppt"=>"application/x-mspowerpoint");
$mime=array("ppt"=>"text/ppt","ppt"=>"application/vnd.ms-powerpoint");

$file=$_GET["f"];
$formato=substr(strrchr($documento,"."),1);
$mime_type=$mime[$formato];

header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: $mime_type; name=$documento");
header ( "Content-Disposition: attachment; filename=$documento");
$path="../archivos/";

readfile("$path$documento");

?>
