<?php
header("Content-type:text/html;charset=utf-8");
include_once "db_conn.php";

$rec_id = $_POST["rec_id"];
$Type = $_POST["Type"];
$Date = $_POST["Date"];
$Description = $_POST["Description"];
$cost = $_POST["cost"];
$Category = $_POST["Category"];

$query = ("insert into record (?,?,?,?,?,?)");
$stmt= $db->prepare($query);
$stmt->execute(array($rec_id,$Type,$Date,$Description,$cost,$Category));
header("Locatoin:inform.php");
?>