<?php
$deviceToken = 'b5295eb11dbffd23a7d451f8d9000b6a0daeb068160cef5a990131ad0e7119e7';

$passphrase = '123';

$message = 'New Bird entry has been added';
$pemfilepath = '/home/karlakat/public_html/lespoton.com/portal/lespotPushP12.pem';

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfilepath);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp) {
	exit("Failed to connect: $err $errstr" . PHP_EOL);
}

echo 'Connected to APNS' . PHP_EOL;

$body['aps'] = array(
	'alert' => array(
		'body' => $message,
		// 'action-loc-key' => 'Bango App',
	),
	'badge' => 2,
	'sound' => 'oven.caf',
);

$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

$result = fwrite($fp, $msg, strlen($msg));

if (!$result) {
	echo 'Message not delivered' . PHP_EOL;
} else {
	echo 'Message successfully delivered' . PHP_EOL;
}

fclose($fp);