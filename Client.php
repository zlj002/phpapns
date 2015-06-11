<?php
ini_set("soap.wsdl_cache_enabled", "0");
//$url = 'http://localhost/t/ws/test_server.wsdl';
$url = 'http://localhost:1236/PushAPNSServer.php?wsdl';    //两种url都可以
$client = new SoapClient($url);
//$params = array('deviceToken'=>'d784d0f9b8b1fe1bd3b25437ee20202554572bfcea005bb8b355ef9a4c3127e1', 'message'=>'您有新消息');
//$res = $client->__soapCall(SendOneMessage,array('parameters'=>$params));
$res = $client->SendOneMessage('d784d0f9b8b1fe1bd3b25437ee20202554572bfcea005bb8b355ef9a4c3127e1','您有一个日程提醒');      //调用方法1
var_dump($res);

  
?>