<?php
include("db_conn.php");

$rec_id = $_POST["rec_id"];

$sql = "DELETE FROM record WHERE rec_id = ?";
$stmt = $db->prepare($sql);
$success = $stmt->execute(array($rec_id));
header('Location: edit_record.php');

?>