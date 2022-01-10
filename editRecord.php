<?php
include("db_conn.php");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>編輯紀錄</title>
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

        function ChangeContent(description){
            <?php echo "123"; ?>
            document.getElementById("description").value = description;
            document.getElementById("mfrom").action = "editRecord.php";
            document.getElementById("mfrom").submit();
        }

        function UpdateContent(){
            document.getElementById("rec_id").value = document.getElementById("rec_id").value;
            document.getElementById("TName").value = document.getElementById("TName").value;
            document.getElementById("Price").value = document.getElementById("Price").value;
            document.getElementById("Description").value = document.getElementById("Description").value;
            document.getElementById("Name").value = document.getElementById("Name").value;
            document.getElementById("Address").value = document.getElementById("Address").value;
            document.getElementById("Phone").value = document.getElementById("Phone").value;
            document.getElementById("mfrom").action = "";
            document.getElementById("mfrom").submit();
        }

        function DeleteContent(){
            document.getElementById("rec_id").value = document.getElementById("rec_id").value;
            document.getElementById("mfrom").action = "";
            document.getElementById("mfrom").submit();
        }

        function InsertContent(){
            document.getElementById("mfrom").action = "";
            document.getElementById("mfrom").submit();
        }
    </script>
</head>
<body>
<form id="mfrom" method="post" action="editRecord.php">
    <input type="hidden" id="ToyID" name="ToyID" value="<?php echo isset($_POST["ToyID"])?$_POST["ToyID"]:""?>">
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
        <table class="menu_search">
            <tr>
                <td>
<!--                    <form method="post" action="toy.php">-->
<!--                        Search-->
<!--                        <input type="text" id="keyword" name="keyword" value="" placeholder="輸入搜尋關鍵字" />-->
<!--                        <input type="submit" value="送出">-->
<!--                    </form>-->
                </td>
            </tr>
        </table>
    </div>
    <div class="content">
        <div class="inner_content">
            <table class="table">
                <input class="btn btn-default" type="button" value="新增" onclick="InsertContent();">
                <div style="text-align: left;font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size: 15px;font-weight: bold;">
<!--                    總數量為:-->
<!--                    --><?php
//                    $sql = "SELECT COUNT(*) FROM toy WHERE AreaCode = '201609260001'";
//                    $stmt =  $db->prepare($sql);
//                    $error = $stmt->execute();
//
//                    if($rowcount = $stmt->fetchColumn())
//                        echo $rowcount;
//                    ?>
                </div>
                <thead>
                <tr>
                    <th>#</th>
                    <th>description</th>
                    <th>type</th>
                    <th>category</th>
                    <th>date</th>
                    <th>cost</th>
                </tr>
                </thead>
                <tbody>
                <?php
                        //$sql = "SELECT t.ToyID,t.Name TName,t.Price,t.Description,ts.Name,ts.Address,ts.Phone FROM `toy` t left join `toysupplier` ts on t.ToyID = ts.ToyID";
                        $sql = "select * from record";
                        if($stmt = $db->prepare($sql)){
                            $stmt->execute();

                            for($rows = $stmt->fetchAll(), $count = 0; $count < count($rows); $count++){

                                echo "<tr>";
                                    echo '<th scope="row">'.$count.'</th>';
                                    echo "<td>";
                                    echo sprintf('<a href onclick="ChangeContent(%s)">%s</a>',$rows[$count]['description'],$rows[$count]['description']);
                                    echo "</td>";
                                    echo "<td>".$rows[$count]['type']."</td>";
                                    echo "<td>".$rows[$count]['category']."</td>";
                                    echo "<td>".$rows[$count]['date']."</td>";
                                    echo "<td>".$rows[$count]['cost']."</td>";
                                echo "</tr>";

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