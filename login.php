<?php
include_once "db_conn.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["account"];
    $password = $_POST["password"];//獲取表單資料
    $query = ("SELECT * FROM user where username='$name' AND password='$password'");
    $stmt = $db->prepare($query);
    $stmt -> execute(array());
    $result = $stmt -> fetchALL();


}
?>
<html>
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
<head>
    <meta http-equiv='Content-type' content='text/html'; charest='utf-8'>
    <meta http-equiv="Pragma" Content="No-cache"> <!--清除快取-->
</head>
<center>
    <body>
    <from name="loginForm" action="" method="post">
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
        <form>
            <input type="submit" value="註冊" style="margin-right:150px;">
            <input type="submit" value="登入">
        </form>
    </from>
    </body>
</center>
</html>
