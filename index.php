<?php 
 
// Default url: http://localhost/0HoData/creative_cms/index.php?l=web&c=index&m=index

// Entry mark
define('ACCESS',TRUE);

// Define the project root directory
define('ROOT_PATH',str_replace('\\', '/', __DIR__).'/');

// Load the initialization file
require ROOT_PATH . 'core/initial.php';

// Activate the initialization file
\core\Initial::start();

// Default url: http://localhost/0HoData/creative_cms/index.php?l=web&c=index&m=index
// Log url: http://localhost/0HoData/creative_cms/index.php?l=web&c=index&m=log