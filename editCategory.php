<?php
include("db_conn.php");
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
    <script>
        function ChangeContent(c_id){
            document.getElementById("c_id").value = c_id;
            document.getElementById("mfrom").action = "editCategory.php";
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
<form id="mfrom" method="post" action="editCategory.php">
    <input type="hidden" id="c_id" name="c_id" value="<?php echo isset($_POST["c_id"])?$_POST["c_id"]:""?>">
    <div class="menu">
        <table class="menu_css">
            <tr>
                <td>
                    <a href="editRecord.php">Home</a>
                </td>
                <td>
                    <a href="editCategory.php">編輯類別</a>
                </td>
                <td>
                    <a href="insert_category.php">新增類別</a>
                </td>
            </tr>
        </table>
        <table class="menu_search">

        </table>
    </div>
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
                    <th>category_name</th>
                    <th>type</th>
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
                                <td><input type="text" id="category_name" name="category_name" value="<?php echo $result[0]['category_name'];?>"/></td>
                                <td><select id="type_list" name="type" onchange="changeCollege(this.selectedIndex)">>
                                        <option  value=1>收入</option>
                                        <option  value=0>支出</option>
                                    </select></td>
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
                                <th scope="row"><?php echo $count;?></th>
                                <td>
                                    <a onclick="ChangeContent('<?php echo $rows[$count]['c_id'];?>');"><?php echo $rows[$count]['category_name'];?></a>
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
