<?php
include_once "db_conn.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["account"];
    $password = $_POST["password"];//獲取表單資料
    $query = ("SELECT * FROM user where name=? AND password=?");
    $stmt = $db->prepare($query);
    $stmt -> execute(array($name, $password));
    $result = $stmt->fetchAll();
    if($stmt->rowCount() == 0){
        echo "<script>alert('帳號或密碼錯誤'); location.href = 'login.php';</script>";
    }
    else{
        $_SESSION["login"]=true;
        $_SESSION["name"]=$name;
        $_SESSION["ID"]=$result[0]['ID'];
        echo "<script>alert('請開始使用記帳系統'); location.href = 'bookkeeping.php';</script>";//網址會變
    }
}
?>
<style>
    #show{
        padding: 0;
        border: 1px solid black;
        height: 20px;
        width: 200px;
        line-height: 20px;
    }
    #show1{
        padding: 0;
        border: 1px solid black;
        height: 20px;
        width: 200px;
        line-height: 20px;
    }
    #set{
        display: inline-block;
        height: 22px;
        background-color: rgba(0,0,0,0.5);
        color: white;
        line-height: 18px;
        margin-left: -72px;
        cursor: pointer;
    }
</style>
<html>
<head>
<!--    <meta http-equiv='Content-type' content='text/html'; charest='utf-8'>-->
<!--    <meta http-equiv="Pragma" Content="No-cache"> 清除快取-->
</head>
<center>
    <body>
    <form action="" method="post">
        <h1>記帳小幫手</h1>
        <h3>登入</h3>
        帳號:<input id="show1" type="text" name="account">
        <br>
        <br>
        密碼:<input id="show" type="password" name="password">
        <span id="set">顯示密碼</span>
        <script>
            set.onclick = function(){
                if(this.innerHTML == '顯示密碼'){
                    this.innerHTML = '隱藏密碼';
                    show.type="text";
                }else{
                    this.innerHTML = '顯示密碼';
                    show.type="password";
                }
            }
        </script>
        <br>
        <br>
        <input type="button" value="註冊" style="margin-right:150px;" onclick="location.href='insert_user.php'">
        <input type="submit" value="登入">
    </form>
    </body>
</center>
</html>
