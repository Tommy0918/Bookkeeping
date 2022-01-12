<?php
session_start();
include("db_conn.php");
$ID = $_SESSION['ID'];
$rec_id = $_POST["rec_id"];
$description = $_POST["description"];
$type= $_POST["type"];
$cost = $_POST["cost"];
$category = $_POST["category"];
$date = $_POST["date"];

if($description == ''){
    $description = '空';
}

$sql = "UPDATE record SET description=?,type =?,cost=?,category=?,date=? WHERE rec_id=? and ID=?;";
$stmt = $db->prepare($sql);
$stmt->execute(array($description, $type, $cost, $category, $date, $rec_id, $ID));
header('Location: edit_record.php');

?>