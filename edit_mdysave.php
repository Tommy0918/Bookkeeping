<?php
include("db_conn.php");

$rec_id = $_POST["rec_id"];
$description = $_POST["description"];
$type= $_POST["type"];
$cost = $_POST["cost"];
$category = $_POST["category"];
$date = $_POST["date"];

if($description == ''){
    $description = '空';
}

$sql = "UPDATE record SET description=?,type =?,cost=?,category=?,date=? WHERE rec_id=?;";
$stmt = $db->prepare($sql);
$stmt->execute(array($description, $type, $cost, $category, $date, $rec_id));
header('Location: editRecord.php');

?>