<?php
session_start();
include_once "db_conn.php";
include("login_title.php");
if($_SESSION['login']) {
    $ID = $_SESSION['ID'];
//echo $ID;
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
    <script>
        function ChangeContent(c_id){
            document.getElementById("c_id").value = c_id;
            document.getElementById("mfrom").action = "edit_category.php";
            document.getElementById("mfrom").submit();
        }

        function UpdateContent(){
            document.getElementById("mfrom").action = "category_update.php";
            document.getElementById("mfrom").submit();
        }

        function DeleteContent(){
            document.getElementById("mfrom").action = "category_delete.php";
            document.getElementById("mfrom").submit();
        }

        function InsertContent(){
            document.getElementById("mfrom").action = "bookkeeping.php";
            document.getElementById("mfrom").submit();
        }
    </script>
</head>
<body>
<form id="mfrom" method="post" action="edit_category.php">
    <input type="hidden" id="c_id" name="c_id" value="<?php echo isset($_POST["c_id"])?$_POST["c_id"]:""?>">

    <div class="content">
        <div class="inner_content">
            <table class="table">
                <div style="text-align: left;font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size: 15px;font-weight: bold;">
                    <!--總數量為:-->
                    <?php
                    $sql = "SELECT COUNT(*) FROM category";
                    $stmt =  $db->prepare($sql);
                    $error = $stmt->execute();

                    if($rowcount = $stmt->fetchColumn())
                    //echo $rowcount;
                    ?>
                </div>
                <thead>
                <tr>
                    <th>#</th>
                    <th>type</th>
                    <th>category_name</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($_POST["c_id"]) && !empty($_POST["c_id"])){
                    $c_id = $_POST["c_id"];
                    $sql = "select * from category where c_id = ?";
                    if($stmt = $db->prepare($sql)){
                        $stmt->execute(array($c_id));
                        if($result = $stmt->fetchALL()){
                            ?>
                            <tr>
                                <th scope="colgroup">
                                    <input class="btn btn-default" type="button" value="按我更新" onclick="UpdateContent();">
                                    <input class="btn btn-default" type="button" value="按我刪除" onclick="DeleteContent();">
                                </th>
                                <td>
                                    <?php
                                    if ($result[0]['type']){
                                        ?>
                                        <select id="type_list" name="type" onchange="changeCollege(this.selectedIndex)">>
                                            <option selected="selected" value=1>收入</option>
                                            <option  value=0>支出</option>
                                        </select>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <select id="type_list" name="type" onchange="changeCollege(this.selectedIndex)">>
                                            <option  value=1>收入</option>
                                            <option selected="selected" value=0>支出</option>
                                        </select>
                                        <?php
                                    }
                                    ?>
                                <td><input type="text" id="category_name" name="category_name" value="<?php echo $result[0]['category_name'];?>"/></td>
                            </tr>
                            <?php
                        }
                    }
                }else{
                    $sql = "select * from category";
                    if($stmt = $db->prepare($sql)){
                        $stmt->execute();

                        for($rows = $stmt->fetchAll(), $count = 0; $count < count($rows); $count++){
                            ?>
                            <tr>
                                <th scope="row"><a onclick="ChangeContent('<?php echo $rows[$count]['c_id'];?>');"><?php echo $count+1;?></a></th>
                                <td>
                                    <?php echo $rows[$count]['category_name'];?>
                                </td>
                                <td>
                                    <?php
                                    if($rows[$count]['type'])
                                        echo '收入';
                                    else
                                        echo '支出';
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</form>
</body>
</html>
