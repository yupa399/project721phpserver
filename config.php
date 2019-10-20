<?php
	global $config;
	$config = [
		'host'	=> 'fdb20.biz.nf',
		'port'	=> '3306',
		'uname' => '3102237_cass',
		'pass' 	=> 'yupa20190006',
		'db'	=> '3102237_cass',
	];

	function resJson($code, $msg, $data) {
		header('Content-Type: application/json');
		$data = ['code' => $code, 'msg' => $msg, 'data' => $data];
		echo json_encode($data);
		exit;
	}

	function connect() {
		$con = mysqli_connect('fdb20.biz.nf', '3102237_cass', 'yupa20190006', '3102237_cass', '3306');
		if ( !$con ) {
			resJson( 500, 'can not connect to db', null);
		}
		return $con;
	}

	function updateData($tableName, $data, $where) {
		$con = connect();
		$sql = "UPDATE `$tableName` SET ";
		foreach ($data as $key => $value) {
			$sql .= "`$key` = '" . mysqli_real_escape_string($con, $value) . "', ";
		}
		$sql = trim($sql, ", ") . " WHERE 1 = 1";
		foreach ($where as $key => $value) {
			$sql .= " AND `$key` = '" . mysqli_real_escape_string($con, $value) . "'";
		}
		$sql .= ";";
		$res = $con->query($sql);
		$con->close();
		return $sql;
	}

	function insertData($tableName, $data) {
		$con = connect();
		$sql = "INSERT INTO `$tableName`";
		$sql_keys = "";
		$sql_values = "";
		foreach ($data as $key => $value) {
			$sql_keys .= "`$key`, ";
			$sql_values .= "'" . mysqli_real_escape_string($con, $value) . "', ";
		}
		$sql .= '(' . trim($sql_keys, ", ") . ') VALUES (' . trim($sql_values, ', ') . ');';
		mysqli_query($con,$sql);
		$id = mysqli_insert_id($con);
		mysqli_close($con);
		return $id;
	}

	// limit to 50 since did not do split page
	function queryAllData($tableName) {
		$con = connect();
		$sql = "SELECT * FROM `$tableName` limit 50";
		$res = $con->query($sql);
		$con->close();
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
    		$rows[] = $r;
		}
		return $rows;
	}

	//
	function queryLatestData($tableName) {
		$con = connect();
		$sql = "SELECT * FROM `$tableName` order by id DESC limit 1";
		$res = $con->query($sql);
		$con->close();
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
    		$rows[] = $r;
		}
		return $rows;
	}