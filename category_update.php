<?php
include("db_conn.php");

$c_id = $_POST["c_id"];

$type= $_POST["type"];

$category_name = $_POST["category_name"];


if($category_name == ''){
    $category_name = '空';
}

$sql = "UPDATE category SET category_name=?,type =? WHERE c_id=?;";
$stmt = $db->prepare($sql);
$stmt->execute(array($category_name, $type,$c_id));
header('Location: editCategory.php');

?>