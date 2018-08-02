<?php

$mysqli = new mysqli('localhost','letabox_letabox_sys','letabox_letabox_sys','letabox_letabox_sys');
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>