<?php
error_reporting(0); //nel mio caso vengono mostrati errori relativi a funzioni deprecate
require 'wrapper.php';		
$host = 'edysma.invionews.net';
$api_key = '595ac5cb9490de82200e1017b98f277e';
$secret = '5b2e0ca115cb66285b3019c9c6812a56';
service_init($host, $api_key, $secret);
$result = service_user_list();

if (service_errorcode()) {
	echo ("errore: " . service_errorcode() . ' - ' . service_errormessage());
	exit();
}
print_r($result);