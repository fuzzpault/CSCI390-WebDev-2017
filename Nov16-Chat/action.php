<?php

// PHP file to react to AJAX calls from the chat program index.html in
// this same folder.

$m = new Memcache;  // Change to Memcached if on our VM.
$m->addServer('localhost', 11211);

// Check to see if anything is stored yet, and if not set
$history = $m->get('history');

if($history === false && !isset($_GET['msg'])){
	$m->set('history','');
	echo json_encode( array('result' => '' ) );
}else if(isset($_GET['msg']) && $_GET['msg'] == 'CLEAR'){
	$m->set('history','');	
	echo json_encode( array('result' => '' ) );
}else if($history === false && isset($_GET['msg'])){
	$msg = htmlspecialchars ( $_GET['msg'] );
	$m->set('history', ($_SERVER['REMOTE_ADDR'] . ': ' . $msg. '<br>'));
	echo json_encode( array('result' => $_SERVER['REMOTE_ADDR'] . ': ' . $msg. '<br>' ) );
}else if(isset($_GET['msg'])){
	$msg = htmlspecialchars ( $_GET['msg'] );
	$m->prepend('history', ($_SERVER['REMOTE_ADDR'] . ': ' . $msg. '<br>'));
	echo json_encode( array('result' =>  $_SERVER['REMOTE_ADDR'] . ': ' . $msg. '<br>' . $history) );
}else{
	echo json_encode( array('result' => $history ) );
}


?>