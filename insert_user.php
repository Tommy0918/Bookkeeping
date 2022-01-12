<?php
include_once "db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name=$_POST["username"];
    $password1=$_POST["password"];//獲取表單資料
    $password2=$_POST["password_check"];
    if($name==""||$password1=="")//判斷是否填寫
    {
        echo "<script>alert('請確實填寫'); location.href = 'insert_user.php';</script>";
    }
    if($password1==$password2)//確認密碼是否正確
    {
        $query = "select * from user where name=?";
        $stmt = $db->prepare($query);
        $stmt->execute(array($name));
        if ($stmt->rowCount() == 0) {
            echo "<script>alert('註冊成功!歡迎使用!'); location.href = 'login.php';</script>";
            $query = "insert into user values(?,?,?)";//將註冊資訊插入資料庫表中
            $stmt = $db->prepare($query);
            $stmt->execute(array(null, $name, $password1));
        } else {
            echo "<script>alert('此帳號已被註冊'); location.href = 'insert_user.php';</script>";
        }
    }
    else{
        echo "<script>alert('密碼不一致'); location.href = 'insert_user.php';</script>";
    }
}
?>

<html>
<center>
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
<div>
    <table>
        <tr>

    <input type ="button" onclick="location.href='login.php'" value="回登入頁面"></input>

            <td>
                <h1>註冊頁面</h1><!--原本body~form只有這行-->
            </td>
        </tr>
    </table>
</div>
<form name="registerForm" method="post" action="">
    帳  號：
    <input id = "show" type="text" name="username"><br/><br/>
    密  碼：
    <input id = "show1" type="password" name="password" id="password"><br/><br/>
    確認密碼：
    <input type="password" name="password_check" id="password_check"><br/><br/>
    <input type="submit" value="註冊" name="submit">
    <input type="reset" value="重設" name="submit">
</form>
</body>
</center>
</html>