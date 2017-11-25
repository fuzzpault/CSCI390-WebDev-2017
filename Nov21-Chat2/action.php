<?php

session_start();
$who = substr($_COOKIE["PHPSESSID"],0,3);

// PHP file to react to AJAX calls from the chat program index.php in
// this same folder.

$m = new Memcache;  // Change to Memcached if on our VM.
$m->addServer('localhost', 11211);

// See if we have any chats
$history = $m->get('history2');

// This version stores an array of chats, each containing the chat and a short
// string (first 3 characters) of their session cookie so we can track
// individual users.

if($history === false && !isset($_GET['msg'])){
	$m->set('history2',array());
	echo json_encode( array('result' => array() ) );
}else if(isset($_GET['msg']) && $_GET['msg'] == 'CLEAR'){
	$m->set('history2',array());	
	echo json_encode( array('result' => array() ) );
}else if(! is_array($history) && isset($_GET['msg'])){
	$msg = htmlspecialchars ( $_GET['msg'] );
	$m->set( 'history2', array( array('user' => $who , 'msg' => $msg) ) );
	echo json_encode( array('result' => array( array('user' => $who , 'msg' => $msg) ) ) );
}else if(isset($_GET['msg'])){
	$msg = htmlspecialchars ( $_GET['msg'] );
	$newhistory = array_merge( array( array('user' => $who , 'msg' => $msg) ), $history );
	
	//var_dump($newhistory);
	$m->set('history2', $newhistory);
	echo json_encode( array('result' =>  $history) );
	
}else if(isset($_GET['like'])){
	$user = htmlspecialchars ( $_GET['like'] );
	$likes = $m->get($user);
	if($user != $who){
	
		// If the user has no likes
		//if ($)
		if($likes === false){
			$m->set($user,0);
		}else{
			// By default, it adds 1 = $m->increment($user, 1);
			$m->increment($user);
		}
	}
}else{
	foreach ($history as $key => $value) {
		
		// This will add what stored in the variable $who (user name)
		$likes = $m->get($value['user']);
		if($likes === false){
			$history[$key] = array_merge($value,array('likes' => 1));
		}else{
			$history[$key] = array_merge($value,array('likes' => $likes));
		}
	}
	echo json_encode( array('result' => $history ) );
}


?>