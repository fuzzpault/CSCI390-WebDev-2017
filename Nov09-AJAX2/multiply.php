<?php

// Does a multiply with the a and b get values, and updates memcache's
// mult-count variable.

$m = new Memcache;  // Change to Memcached if on our VM.
$m->addServer('localhost', 11211);

if(isset($_GET['a']) && isset($_GET['b'])){
	echo $_GET['a'] * $_GET['b'];

	if(!$m->get('mult-count')){
		$m->set('mult-count', 1);
	}else{
		$m->increment('mult-count', 1);
	}
}

?>