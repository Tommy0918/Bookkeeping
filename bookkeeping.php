<?php
session_start();
include_once "db_conn.php";
include("login_title.php");
if($_SESSION["login"]) {
    $ID = $_SESSION['ID'];
//echo $ID;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cost = $_POST["total"];
        $type = $_POST["type"];//獲取表單資料
        $category = $_POST["category"];//獲取表單資料
        $date = $_POST["date"];
        $des = $_POST["dec"];
        if($cost < 0){
            echo "<script>alert('金額不能為負'); location.href = 'bookkeeping.php';</script>";
            exit();
        }
        else if(!is_numeric($cost)) {
            echo "<script>alert('請輸入合理數字'); location.href = 'bookkeeping.php';</script>";
            exit();
        }
        if($des=='')
            $des = '空';
        $query = ("insert into record values(?,?,?,?,?,?,?)");
        $stmt = $db->prepare($query);
        $stmt->execute(array($ID, null, $type, $category, $date, $des, $cost));
        header('Location: editRecord.php');
    }
}
else{
    echo "<script>alert('請先登入'); location.href = 'login.php';</script>";
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>index.php</title>
    <link rel="stylesheet" href="user_form.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.min.css">
</head>

<body>
    <form name="recordForm" method="post" action=" " onsubmit="return validateForm()">
        <div class="content">
            <div class="inner_content">
                <table class="table">
                    <!--            <input class="btn btn-default" type="button" value="" onclick="InsertContent();">-->
                    <thead>
                        <tr>
                            <th>日  期</th>
                            <th>收  支</th>
                            <th>類  別</th>
                            <th>描  述</th>
                            <th>金  額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input required type="date" name="date" value=<?php echo date('Y-m-d')?>>
                            </td>
                            <td>
                                <select id="type_list" name="type" onchange="changeCollege(this.selectedIndex)">>
                                    <option value="in">收入</option>
                                    <option value="out" selected>支出</option>
                                </select>
                            </td>
                            <td>
                                <select id="category_list" name="category">
                                    <!--預設進來時是支出，類別選單用支出的-->
                                    <?php
                                    $inner = "";
                                    $query = ("SELECT * FROM category where type = ?");
                                    $stmt = $db->prepare($query);
                                    $stmt->execute(array(false));
                                    $result = $stmt->fetchAll();
                                    for ($i = $stmt->rowCount() - 1; $i >= 0; $i--) {
                                        echo "<option>".$result[$i]['category_name']."</option>" ;
                                    }
                                    ?>
                                </select>
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
                            </td>
                            <td>
                                <input type="text" name="dec">
                            </td>
                            <td>
                                <input required type="text" name="total">
                            </td>
                            <td>
                                <input type="submit" value="新增" name="check" >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</body>
</html>
