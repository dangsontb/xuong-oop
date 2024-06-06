<?php

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/client.php';

$router->set404(function(){
    header('HTTP/1.1 404 Not Found');
	echo "404 Not Found";
});

// Run it!
$router->run();

