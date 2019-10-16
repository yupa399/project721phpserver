<?php

require 'config.php';

$httpBody = file_get_contents('php://input');
$record = json_decode($httpBody, true);
$id = $record['id'];
unset($record['id']);
$ret = insertDataMain('tbVersion', $record);
if ( !$ret ) {
    resJson(500, "insert db failed", null);
} else {
    resJson(200, 'successful', $ret );
}