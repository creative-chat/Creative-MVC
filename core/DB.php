<?php

namespace core;
use \PDO;
use \PDOstatement;
use \PDOexception;

class DB
{ 
	private $db;
	private $fetch_model;
 
	// Constructor, instantiate pdo object
	public function __construct($info = array(),$drives = array())
	{
		$type = $info['type'] ? $info['type'] : 'mysql';
		$servername = $info['host'] ? $info['host'] :'localhost';
		$port = $info['port'] ? $info['port']: '3306';
		$database = $info['dbname'];
		$username = $info['user'];
		$password = $info['password'];
		$drives[PDO::ATTR_ERRMODE] = $drives[PDO::ATTR_ERRMODE] ? $drives[PDO::ATTR_ERRMODE] :  PDO::ERRMODE_EXCEPTION;
		$charset = $info['charset'] ? $charset = $info['charset'] : 'utf8';
 
		$this->fetch_model = $info['fetch_model'] ? $info['fetch_model'] : PDO::FETCH_ASSOC;
 
		// Connect database
		try {
			// $drives = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
			if($type == 'mysql')
			{
				$this->db = @new pdo("$type:server=$servername;port=$port;dbname=$database","$username","$password", $drives);
			} else if($type == 'sqlsrv') 
			{
				$this->db = new PDO("$type:server=$servername;Database=$database", $username,$password, $drives );
			}
		} catch (pdoException $e) {
			echo 'Database connection error';
			echo '<br />';
			echo  'The error file is ' . $e->getFile();
			echo '<br />';
			echo  'The number of error lines is ' . $e->getLine();
			echo '<br />';
			echo  'The number of error lines is ' . $e->getMessage();
			die();
		}
 
		//	Set character set
		try {
			// $this->db->exec("set name {$charset}");
		} catch (pdoException $e) {
			$this->pdo_exception($e);
		}
	}
 
	// Exception handling function
	private function pdo_exception(pdoException $e){
		echo 'SQL Execution error';
		echo '<br />';
		echo  'The error file is ' . $e->getFile();
		echo '<br />';
		echo  'The number of error lines is ' . $e->getLine();
		echo '<br />';
		echo  'The number of error lines is ' . $e->getMessage();
		die();
	}
 
 
	// Write action
	public function exec($sql){
		try {
			return $this->db->exec($sql);
		} catch (pdoException $e) {
			$this->pdo_exception($e);
		}
	}
 
	// Read action
	public function query($sql,$all = true){
		try {
			$stmt = $this->db->query($sql);
 
			if($all == true){
				$res = $stmt->fetchAll($this->fetch_model);
				//if(!$res) throw new pdoexception('No data is currently queried');
				return $res;
			}
			else{
				$res = $stmt->fetch($this->fetch_model);
				//if(!$res) throw new pdoexception('No data is currently queried');
				return $res;
			}
		} catch (pdoException $e) {
			$this->pdo_exception($e);
		}
	}

	// Prepare action
	public function preSelect($sql, $queryArray)
	{
		$stmt = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->execute($queryArray);

		$stmt = $stmt->fetchAll($this->fetch_model);
		return $stmt;
	}

	// Prepare insert action
	public function preInsert($sql, $queryArray)
	{
		$stmt = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		
		foreach ($queryArray as $key => $v) 
		{
			$stmt->bindParam(':'.$key, $queryArray[$key]);
		}

		$stmt->execute();
	}

	// Prepare demo
	public function prepare_demo($sql, $queryArray)
	{
        $keyword = 'A';
		$sql = "
            SELECT * FROM tb_uccountrycode 
			WHERE DESCE LIKE :DESCE
			OR DESCE LIKE :DESCE_int
        "; 

        $queryArray = array();
		$queryArray[':DESCE'] = $keyword.'%';
		$queryArray[':DESCE_int'] = '% '.$keyword.'%';

		$servername = "10.6.249.116,50266";
        $database = "trade_code";
        $username = "trade_code";
        $password = "trade_code123";

        $db = new PDO("sqlsrv:server=$servername;Database=$database", $username,$password, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );

        $stmt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$stmt->execute($queryArray);
 
		$stmt = $stmt->fetchAll($this->fetch_model);
		return $stmt;

		$array=array();
		$array_num = 0;
		foreach($stmt as $k=>$row) 
		{
			array_push( $array, array(
				"CTCODE"=> $row['CTCODE'], 
				"WORD"=> $row['DESCE'], 
			));
			$array_num += 1;
		}

		foreach($array as $k=>$row) 
        {   
          echo $row['CTCODE'].' | '.$row['WORD'].'<br/>';
        }
	}

}
