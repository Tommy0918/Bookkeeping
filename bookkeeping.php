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
        if($type == "in" && $cost < 0){
            echo "<script>alert('收入不能為負'); location.href = 'bookkeeping.php';</script>";
            exit();
        }
        else if(!is_numeric($cost)) {
            echo "<script>alert('請輸入合理數字'); location.href = 'bookkeeping.php';</script>";
            exit();
        }
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
    <input required type="date" name="date"><br/><br/>
    金  額 ：
    <input type="text" name="total"><br/><br/>
    收  支 :
    <select id="type_list" name="ways" onchange="changeCollege(this.selectedIndex)">>
        <option value="in">收入</option>
        <option value="out" selected>支出</option>
    </select><br/><br/>
    用  途 ：
    <select id="category_list" name="used">
        <!--預設進來時是支出，類別選單用支出的-->
        <?php
        $inner = "";
        $query = ("SELECT * FROM category where type = ?");
        $stmt = $db->prepare($query);
        $stmt->execute(array(false));
        $result = $stmt->fetchAll();
        for ($i = $stmt->rowCount() - 1; $i >= 0; $i--) {
            echo "<option>".$result[$i]['category']."</option>" ;
        }
        ?>
    </select><br/><br/>

    <script type="text/javascript">
        var typeSelect=document.getElementById("type-list");
        var categorySelect=document.getElementById("category-list");
        //收支選單的選取值改變時，改變類別選單
        function changeCollege(index){
            var inner;
            if(index == 1) {
                <!--支出(type=0)-->
                <?php
                    $inner = "";
                    $query = ("SELECT * FROM category where type = ?");
                    $stmt = $db->prepare($query);
                    $stmt->execute(array(false));
                    $result = $stmt->fetchAll();
                    for ($i = $stmt->rowCount() - 1; $i >= 0; $i--) {
                        $inner = $inner."<option>".$result[$i]['category_name']."</option>" ;
                    }
                ?>
                inner="<?php echo $inner; ?>";
            }
            else{
                <!--收入(type=1)-->
                <?php
                    $inner = "";
                    $query = ("SELECT * FROM category where type = ?");
                    $stmt = $db->prepare($query);
                    $stmt->execute(array(true));
                    $result = $stmt->fetchAll();
                    for($i = $stmt->rowCount()-1; $i >=0;$i--){
                        $inner = $inner."<option>".$result[$i]['category_name']."</option>" ;
                    }
                ?>
                inner="<?php echo $inner; ?>";
            }
            //改動類別選單的內容
            var categorySelect=document.getElementById("category_list");
            categorySelect.innerHTML=inner;
        }
        changeCollege(document.getElementById("type-list").selectedIndex);
    </script>

    描  述:
    <input type="text" name="dec"><br/><br/>
    <input type="submit" value="確認" name="check">
    <input type="reset" value="重設">
</form>


</body>
</center>
</html>
