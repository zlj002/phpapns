<?php

class PushAPNS {
	public function __construct() {
	}
	/*
	 * 推送消息到APNS服务器
	 * */
	public function SendOneMessage($deviceToken, $message) {
		// 这里是我们上面得到的deviceToken，直接复制过来（记得去掉空格）
//		$deviceToken = 'd784d0f9b8b1fe1bd3b25437ee20202554572bfcea005bb8b355ef9a4c3127e1';
//		$message = '您好，您有新的消息';
		// Put your private key's passphrase here:
		$passphrase = 'softvenu';
		
		// Put your alert message here:
		//$message = 'My first push test!'; 
		

		$ctx = stream_context_create ();
		stream_context_set_option ( $ctx, 'ssl', 'local_cert', 'ck.pem' );
		stream_context_set_option ( $ctx, 'ssl', 'passphrase', $passphrase );
		
		// Open a connection to the APNS server
		//这个为正是的发布地址
		$fp = stream_socket_client ( "ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx );
		//这个是沙盒测试地址，发布到appstore后记得修改哦
		//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		

		if (! $fp) {
			//			exit ( "Failed to connect: $err $errstr" . PHP_EOL );
			return FALSE;
		}
		echo 'Connected to APNS' . PHP_EOL;
		
		// Create the payload body
		$body ['aps'] = array ('alert' => $message, 'sound' => 'default' );
		
		// Encode the payload as JSON
		$payload = json_encode ( $body );
		
		// Build the binary notification
		$msg = chr ( 0 ) . pack ( 'n', 32 ) . pack ( 'H*', $deviceToken ) . pack ( 'n', strlen ( $payload ) ) . $payload;
		
		// Send it to the server
		$result = fwrite ( $fp, $msg, strlen ( $msg ) );
		//echo $result;
		if (! $result) {
			echo 'Message not delivered' . PHP_EOL;
			return false;
		} else {
			echo 'Message successfully delivered' . PHP_EOL;
			return TRUE;
		}
		// Close the connection to the server
		fclose ( $fp );
	}
}

?>