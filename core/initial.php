<?php 

namespace core;
 
// Determine whether the access is legal, whether it is accessed from the index.php file
if(!ACCESS)
{
	header('location:../public/index.php');
	exit;
}
 
// Initialization class
class Initial
{
	// Entry method
	public static function start(){
		
		// Load path constant
		self::set_path();
 
		// Configuration file
		self::set_config();
 
		// Error control
		self::set_error();
 
		// Parse URL
		self::set_URL();
 
		// Autoload
		self::set_autolode();
 
		// distribution
		self::set_dispatch();
	}
 
	// Define path constant
	private static function set_path(){
		define('CORE_PATH',ROOT_PATH . 'core/');
		define('APP_PATH',ROOT_PATH . 'app/');
		define('CONFIG_PATH',ROOT_PATH . 'config/');
		define('VENDOR_PATH',ROOT_PATH . 'vendor/');
 
	}
 
	// Error method control
	private static function set_error(){
		global $config;
		// var_dump($config);die;
		// E_ALL is a system constant, showing all errors
		@ini_set('error_reporting', $config['error']['error_reporting']); 
		// 1 Display error information 0 Not display
		@ini_set('display_errors', $config['error']['display_errors']); 
	}
 
	// Configuration file
	private static function set_config(){
		// Set global variable $config to save configuration information
		global $config;
		// Include configuration files
		$config = include ROOT_PATH .'config/config.php';
	}
 
	// Parse URL
	private static function set_URL(){
		// l platform information c controller m access method
		$location = isset($_REQUEST['l']) ? $_REQUEST['l'] : 'web'; // Default visit web controllers folder
		$controller = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index'; // Default access to Index controller
		$method = isset($_REQUEST['m']) ? $_REQUEST['m'] : 'index'; // Default access index method
 
		define('l', $location);
		define('c', $controller);
		define('m', $method);
	}
 
	// Autoload
	private static function set_autoload_function($class){
		// Remove class name
		$class = basename($class);
 
		// Determine whether the core file exists
		$core_file = CORE_PATH . $class . '.php';
		if(file_exists($core_file)) include $core_file;
 
		// Determine whether the controller file exists
		$controller_file =  APP_PATH.  l . '/controllers/' .$class . '.php';
		if(file_exists($controller_file)) include $controller_file;
		//echo $controller_file;
		
 
		// Determine whether the model file exists
		$model_file = APP_PATH. l . '/models/' .$class . '.php';
		if(file_exists($model_file)) include $model_file;
 
		// Determine whether the model file exists
		$vendor_file = VENDOR_PATH .$class . '.php';
		if(file_exists($vendor_file)) include $vendor_file;
	}
 
	// Register for automatic loading
	private static function set_autolode(){
		// Use spl_autoload_registers to achieve registration
		spl_autoload_register(array(__CLASS__,'set_autoload_function'));
	}
 
	// Distribution controller
	private static function set_dispatch(){
		// Access path Platform information/controllers/method
		$location = l;
		$controller = c;
		$method = m;
 
		// combination
		$controller = "\\app\\{$location}\\controllers\\{$controller}Controller";
		//echo $controller;
		$controller = new $controller();
		// Realize distribution
		$controller->$method();
	}
 
}
