<?php
include("db_conn.php");

$c_id = $_POST["c_id"];
$category_name = $_POST["category_name"];

$recordCategoryExit = "select * from record where category=?";
$stmt = $db->prepare($recordCategoryExit);
$result=$stmt->execute(array($category_name));

if($stmt->rowCount() == 0){
    $sql = "DELETE FROM category WHERE c_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($c_id));
    header('Location: editCategory.php');
}
else{
    echo "<script>alert('紀錄中有這個類別'); location.href = 'category_delete.php';</script>";
}

?>