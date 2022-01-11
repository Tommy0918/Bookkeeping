<?php
session_start();
include_once "db_conn.php";
if($_SESSION['login']) {
    $ID = $_SESSION['ID'];
//echo $ID;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category = $_POST["category"];
        $type = $_POST["ways"];//獲取表單資料

        $query = ("select category_name from category where type = ?");
        $stmt = $db->prepare($query);
        $stmt->execute(array($type));
        $result = $stmt->fetchAll();
        for($i = 0;$i<count($result);$i++){
            if(strcmp($result[$i]['category_name'],$category )==0){
                echo "<script>alert('已有此類別'); location.href = 'insert_category.php'</script>";
                exit();
            }
        }
        $query = ("insert into category values(?,?,?)");
        $stmt = $db->prepare($query);
        $stmt->execute(array($category, null, $type));
        header('Location: editRecord.php');
    }
}
else{
    echo "<script>alert('請先登入'); location.href = 'login.php';</script>";
}
?>
<html>
<center>
</html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>記帳畫面</title>
</head>

<body>
<h1>新增類別</h1>
<form name="registerForm" method="post" action=" " onsubmit="return validateForm()">
    收  支 :
    <select id="type_list" name="ways" onchange="changeCollege(this.selectedIndex)">>
        <option value="1">收入</option>
        <option value="0" selected>支出</option>
    </select><br/><br/>

    類  別 ：
    <input type="text" name="category"><br/><br/>

    <input type="submit" value="確認" name="check">
</form>


</body>
</center>
</html>
