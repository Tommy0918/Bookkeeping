<?php
include_once "db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name=$_POST["username"];
    $password1=$_POST["password"];//獲取表單資料
    $password2=$_POST["password_check"];
    if($name==""||$password1=="")//判斷是否填寫
    {
        echo "<script>alert('請確實填寫'); location.href = 'insert_user.php';</script>";
        exit;
    }
    if($password1==$password2)//確認密碼是否正確
    {
        $str="select count(*) from register where username="."'"."$name"."'";
        $result=mysql_query($str,$link);
        $pass=mysql_fetch_row($result);
        $pa=$pass[0];
        if($pa==1)//判斷資料庫表中是否已存在該使用者名稱
        {
            echo "<script>alert('此帳號已被註冊'); location.href = 'insert_user.php';</script>";
            exit;
        }
        $sql="insert into register values("."\""."$name"."\"".","."\""."$password1"."\"".")";//將註冊資訊插入資料庫表中
//echo"$sql";
        mysql_query($sql,$link);
        mysql_query('SET NAMES UTF8');
        $close=mysql_close($link);
        if($close)
        {
//echo"資料庫關閉";
//echo"註冊成功！";
            echo "<script>alert('請確實填寫'); location.href = 'login.php';</script>";
        }
    }
    else
    {
        echo "<script>alert('密碼不一致'); location.href = 'insert_user.php';</script>";
    }

    $query = ("insert into user values(?,?,?)");
    $stmt= $db->prepare($query);
    $result = $stmt->execute(array(null,$name,$password1));
}
?>

<html>
<center>
</html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>會員註冊</title>
    <script>
        function validateForm() {
            var x = document.forms["registerForm"]["password"].value;
            var y = document.forms["registerForm"]["password_check"].value;
            if(x.length<6){
                alert("密碼長度不足");
                return false;
            }
            if (x != y) {
                alert("請確認密碼是否輸入正確");
                return false;
            }
        }
    </script>

</head>
<body>
<h1>註冊頁面</h1>
<form name="registerForm" method="post" action="">
    帳  號：
    <input type="text" name="username"><br/><br/>
    密  碼(最少需要6碼)：
    <input type="password" name="password" id="password"><br/><br/>
    確認密碼：
    <input type="password" name="password_check" id="password_check"><br/><br/>
    <input type="submit" value="註冊" name="submit">
    <input type="reset" value="重設" name="submit">
</form>
</body>
</center>
</html>

