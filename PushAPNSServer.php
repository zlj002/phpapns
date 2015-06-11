<?php
ini_set ( "soap.wsdl_cache_enabled", "0" );
include "PushAPNS.php";
$Server = new SoapServer ( 'soap.wsdl'); //创建SoapServer对象
$Server->setClass ( "PushAPNS" );
$Server->handle (); 
?>