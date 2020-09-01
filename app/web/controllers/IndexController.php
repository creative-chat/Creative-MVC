<?php 

namespace app\web\controllers;
use \core\controller;

class IndexController extends Controller
{
	public function __construct()
	{
		// use \app\web\models\DbModel class to connect database
		$this->db = new \app\web\models\DbModel();
	}

	// Show logs json format data
	public function index()
	{
		$keyword = ''; // All data

		$sql = "
            SELECT * FROM logs
			WHERE title LIKE :title
			OR title LIKE :title_int
			limit 30
        "; 

        $queryArray = array();
		$queryArray[':title'] = $keyword.'%';
		$queryArray[':title_int'] = '% '.$keyword.'%';

		// Prepare data to select
		$results = $this->db->preSelect($sql, $queryArray); 

		$results_number = 0;
		foreach($results as $k=>$row)
        {   
        	$Data[$k]['id'] = $row['id'];
        	$Data[$k]['title'] = $row['title'];
        	$Data[$k]['description'] = $row['description'];

        	$results_number += 1;
        }

        $Data['results_number'] = $results_number;

        echo json_encode($Data);

	}

	public function log()
	{
		$log = new \app\web\controllers\LogController();

		$log->preInsert_log('logs', 'testing log', null);
	}

	// No prepare data to select
	public function query() 
	{
		$sql = "SELECT * FROM logs limit 30";
        $results = $this->db->query($sql);

        foreach($results as $k=>$row) 
        {   
          echo $row['id'].' | '.$row['title'].' | '.$row['description'].'<br/>';
        }
	}
}
