<?php
	// Returns the number of times a multiply was done, stored in memcache.

$m = new Memcache;  // Change to Memcached if on our VM.
$m->addServer('localhost', 11211);

$count = $m->get('mult-count');

// '==' checks the type of $count otherwise a 0 value would be triggered 
// as false.
if($count !== false){
	echo $count;
}else{
	echo 'mult-count not set.';
}

?>