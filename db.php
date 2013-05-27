<?php
class DB
{
	public static $dsn = "";
	public static $account = "";
	public static $passowrd = "";

	private static $db;
	
	public static function instance(){
		if(isset(DB::$db) == false)
			DB::$db = new DB;	
		return DB::$db;
	}
	
	public function pdo(){
	
		return $this->pdo;
	} 
	
	public function notORM(){
		include "notORM/NotORM.php";
		$table = new NotORM($this->pdo());
		return $table;
	}
	

	protected $pdo;
	public function __construct() {

    	$dsn = DB::$dsn;
		$user = DB::$account;
		$pwd = DB::$passowrd;
    	$dbh = new PDO($dsn, $user, $pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		$this->pdo = $dbh;

	}
	
	function fetchColOneArr($sql,$params=array()) {
		$rows = $this->fetch($sql,$params,PDO::FETCH_NUM);
		$result = array();
		foreach($rows as $row) {
			$result[] = $row[0];
		}
		return $result;
	}
	
	function fetchOneObj($sql,$params=array(),$defaultObj=NULL) {
		$rows = $this->fetch($sql,$params);
		if(count($rows) > 0)
			$result = $rows[0];
		else
			$result = $defaultObj;
		return $result;
	}
	
	function fetchOneVal($sql,$params=array(),$defaultProp=NULL) {
		$rows = $this->fetch($sql,$params,PDO::FETCH_NUM);
		if(count($rows) > 0)
			$result = $rows[0][0];
		else
			$result = $defaultProp;
		return $result;
	}
	
	function insert($sql,$params=array()) {
		try {
		   $sth = $this->pdo->prepare($sql);
 		   $sth->execute($params);
 		   return $this->pdo->lastInsertId();
 		} catch (PDOException $e) {
			echo $e->getMessage();
		}   
	}

	
	function execute($sql,$params=array()) {
		   $sth = $this->pdo->prepare($sql);
 		   return $sth->execute($params);
	}
	
	 function fetch($sql,$params=array(),$method=PDO::FETCH_OBJ) {
		   $sth = $this->pdo->prepare($sql);
 		   $sth->execute($params);
 		   $result = $sth->fetchAll($method);
 		   return $result;
	}

	function fetchArr($sql,$params=array()) {
		return $this->fetch($sql,$params=array(),PDO::FETCH_BOTH);

	}

	
	function __destruct() {
		$this->pdo = NULL;
	}
}
?>
