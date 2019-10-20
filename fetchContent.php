<?php

require 'config.php';

$httpBody = file_get_contents('php://input');
$queryString = json_decode($httpBody, true);
if ("latest" == $queryString["queryData"]){
$ret = queryLatestData("tbMain");
    resJson(200, "Success", $ret );
}else{
    resJson(500, $queryString, null );
}
