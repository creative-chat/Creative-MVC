<?php 

namespace app\web\controllers;
use \core\controller;

class LogController extends Controller
{
	public function __construct()
	{
		$this->db = new \app\web\models\DbModel();
	}

	public function test()
	{
		echo 'Testing text !';
	}
	
	public function preInsert_log($table, $title, $description)
	{
		if( !empty($title) )
		{
			$sql = "
				INSERT INTO $table
				(
					title
					,description
				)
				VALUES 
				(
					:title
					,:description
				)
			";

			$queryArray = array();
		    $queryArray['title'] = $title;
		    $queryArray['description'] = $description; 
		    // $queryArray['updated_time'] = date('Y-m-d H:i:s');
			
			$stmt = $this->db->preInsert($sql, $queryArray); // Prepare data to insert
		}

		echo 'insert log';
	}
}
