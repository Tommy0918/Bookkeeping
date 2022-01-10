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
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>index.php</title>
    <style>
        body {
            margin: 0px;
        }
        a {
            text-decoration: none;
            font-family: 微軟正黑體,新細明體,標楷體;
            font-weight: bold;
            font-size: 17px;
        }

        .menu {
            position:fixed;
            width: 100%;
            height: 40px;
            background-color: dimgrey;
            z-index: 9999999;
        }

        .menu a {
            text-decoration: none;
            color: white;
            font-family: 微軟正黑體,新細明體,標楷體;
            font-weight: bold;
            font-size: 17px;
        }

        .menu_css {
            float: left;
            width: 70%;
            height: inherit;
            overflow: hidden;
            font-family: 微軟正黑體,新細明體,標楷體;
            font-weight: bold;
            font-size: 17px;
            color: white;
            border-spacing: 0px;
        }
        .menu_css tr {
            display: block;
        }
        .menu_css td {
            height: 40px;
            padding: 0px 15px 0px 15px;
            white-space: nowrap;
        }
        .menu_css td:hover {
            background-color: black;
        }

        .menu_search{
            width: 30%;
            height: inherit;
            white-space: nowrap;
            overflow: hidden;
            font-family: 微軟正黑體,新細明體,標楷體;
            font-weight: bold;
            font-size: 17px;
            color: white;
        }
        .menu_search tr {
            display: block;
        }
        .menu_search td {
            height: 40px;
            padding: 0px 15px 0px 15px;
        }
        .menu_search td:hover {
            background-color: black;
        }

        .content {
            position: relative;
            word-wrap: break-word;
            width: 100%;
            top: 40px;
            background-color: #f1f1f1;
        }

        .inner_content {
            padding: 50px 130px 220px 130px;
        }

        .inner_content table {
            background-color: white;
        }

        li img {
            width: 100%;
            height: 100%;
        }

        input[type=text] {
            color: black;
        }

        form {
            margin-bottom: 0em;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.css">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.min.css">
</head>

<body>
<div class="menu">
    <table class="menu_css">
        <tr>
            <td>
                <a href="editRecord.php">編輯紀錄</a>
            </td>
            <td>
                <a href="">編輯類別</a>
            </td>
        </tr>
    </table>
</div>
<div class="content">
    <div class="inner_content">
        <input type="submit" value="返回" name="back" ></br></br>
        <table class="table">
            <!--            <input class="btn btn-default" type="button" value="" onclick="InsertContent();">-->
            <thead>
            <tr>
                <th>日  期</th>
                <th>收  支</th>
                <th>收  支</th>
                <th>category</th>
                <th>金  額</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input required type="date" name="date">
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
                    <input type="text" name="total">
                </td>
                <td>
                    <input type="text" name="dec">
                </td>
                <td>
                    <input type="submit" value="新增" name="check" >
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</center>
</html>
