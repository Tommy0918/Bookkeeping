<?php
session_start();
include_once "db_conn.php";
include("login_title.php");
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
        header('Location: edit_record.php');
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
        <form name="categoryForm" method="post" action=" " onsubmit="return validateForm()">
            <div class="content">
                <div class="inner_content">
                    <table class="table">
                        <!--            <input class="btn btn-default" type="button" value="" onclick="InsertContent();">-->
                        <thead>
                            <tr>
                                <th>收  支</th>
                                <th>類  別</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <select id="type_list" name="ways" onchange="changeCollege(this.selectedIndex)">>
                                    <option value="1">收入</option>
                                    <option value="0" selected>支出</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="category">
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