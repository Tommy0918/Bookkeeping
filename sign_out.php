<?php
include_once "db_conn.php";
echo "test";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "test554";
    $cost = $_POST["cost"];

    echo $cost;
    $query = ("insert into record  (?,?,?,?,?,?)");
    $stmt = $db->prepare($query);
    $stmt -> execute(array($cost));
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
<form name="registerForm" method="post" action="" onsubmit="return validateForm()"> <!--裏面的變數要根據我們寫得改-->
    金  額 ：
    <input type="text" name="total"><br/><br/>
    收  支 :
    <select name="ways">
        <option value="" selected>收入還是支出</option>
        <option value="in">收入</option>
        <option value="out">支出</option>
    </select><br/><br/>
    用  途 ：
    <select name="used">
        <option value="" selected>請選擇你使用這筆錢的用途</option>
        <option value="eat">食</option>
        <option value="dress">衣</option>
        <option value="live">住</option>
        <option value="tran">行</option>
        <option value="tech" disabled>育</option>
        <option value="play">樂</option>
    </select><br/><br/>
    <input type="submit" value="確認" name="check">
    <input type="reset" value="重設" name="submit">
</form>


</body>
</center>
</html>
