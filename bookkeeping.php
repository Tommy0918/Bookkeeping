<?php
session_start();
include_once "db_conn.php";
if($_SESSION['login']) {
    $ID = $_SESSION['ID'];
//echo $ID;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cost = $_POST["total"];
        $type = $_POST["ways"];//獲取表單資料
        $category = $_POST["used"];//獲取表單資料
        $date = $_POST["date"];
        $des = $_POST["dec"];
        $query = ("insert into record values(?,?,?,?,?,?,?)");
        $stmt = $db->prepare($query);
        $stmt->execute(array($ID, null, $type, $category, $date, $des, $cost));

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
<h1>記帳資訊</h1>
<form name="registerForm" method="post" action=" " onsubmit="return validateForm()">
    日  期 ：
    <input type="date" name="date"><br/><br/>
    金  額 ：
    <input type="text" name="total"><br/><br/>
    收  支 :
    <select name="ways" type="submit">
        <option value="in">收入</option>
        <option value="out" selected>支出</option>
    </select><br/><br/>
    用  途 ：
    <select name="used">
        <?php
            $query = ("SELECT * FROM category where type = ?");
            $stmt = $db->prepare($query);
            $stmt->execute(array(false));
            $result = $stmt->fetchAll();
            for($i = $stmt->rowCount()-1; $i >=0;$i--){
                $temp = $result[$i]['category'];
                echo"<option>$temp</option>";
            }
        ?>
    </select><br/><br/>
    描  述:
    <input type="text" name="dec"><br/><br/>
    <input type="submit" value="確認" name="check">
    <input type="reset" value="重設">
</form>


</body>
</center>
</html>
