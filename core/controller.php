<?php 
namespace core;
 
class Controller {

	public function __construct()
	{
		//
	}
 
	// Error setting
	protected function error($msg,$a=a,$c=c,$p=p,$time=5){
		$refresh = 'Refresh:' . $time . ';url=index.php?c=' . $c .'&a=' . $a . '&p=' . $p;
		header($refresh);
		echo $msg;
		exit;
	}
}
 