<?php

//session_start();
$m = new Memcached;
$m->addServer('localhost', 11211);

$count = $m->get('mult-count');

if($count){
	echo $count;
}else{
	echo 'mult-count not set.';
}

?>