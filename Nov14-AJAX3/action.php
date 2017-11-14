<?php

// Does a multiply or add with the a and b get values, and updates memcache's
// mult-count variable.

$m = new Memcache;  // Change to Memcached if on our VM.
$m->addServer('localhost', 11211);

if(isset($_GET['action']) && $_GET['action'] == 'flush'){
	$m->set('mult-count', 0);
}

if(isset($_GET['a']) && isset($_GET['b']) && !empty($_GET['action'])){
	
	if ($_GET['action'] == 'mult')
	{
		//echo $_GET['a'] * $_GET['b'];  // Old code
		
		// do the the '*' operation
		// Send back a json-encoded package with what should be updated on the page
		// as well as the result.
		echo json_encode( array('destination' => $_GET['dest'], 'result' => $_GET['a'] * $_GET['b']) );
	} else if (	$_GET['action'] == 'add' ) {
		//echo $_GET['a'] + $_GET['b']; // Old code
		
		// do the '+' operation
		echo json_encode( array('destination' => $_GET['dest'], 'result' => $_GET['a'] + $_GET['b']) );
	}

	// Update the mult-count counter in Memcache
	if(!$m->get('mult-count')){ // false when mult-count is not stored yet
		$m->set('mult-count', 1);
	}else{
		$m->increment('mult-count', 1);//its in there, increment by 1
	}
}

 //phpinfo();

?>