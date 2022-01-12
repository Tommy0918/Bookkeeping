<?php
session_start();
include_once "db_conn.php";
include "login_title.php";
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
        function ChangeContent(rec_id){
            document.getElementById("rec_id").value = rec_id;
            document.getElementById("mfrom").action = "edit_record.php";
            document.getElementById("mfrom").submit();
        }

        function UpdateContent(){

            document.getElementById("mfrom").action = "record_update.php";
            document.getElementById("mfrom").submit();
        }

        function DeleteContent(){
            document.getElementById("mfrom").action = "record_delete.php";
            document.getElementById("mfrom").submit();
        }


    </script>
</head>
<body>
<form id="mfrom" method="post" action="edit_record.php">
    <input type="hidden" id="rec_id" name="rec_id" value="<?php echo isset($_POST["rec_id"])?$_POST["rec_id"]:""?>">

    <div class="content">
        <div class="inner_content">
            <table class="table">
                <!--<input class="btn btn-default" type="button" value="新增" onclick="location.href='bookkeeping.php'">-->
                <div style="text-align: left;font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size: 15px;font-weight: bold;">
                    <!--總數量為:-->
                    <?php
                    $sql = "SELECT COUNT(*) FROM record";
                    $stmt =  $db->prepare($sql);
                    $error = $stmt->execute();

                    if($rowcount = $stmt->fetchColumn())
                        //echo $rowcount;
                    ?>
                </div>
                <thead>
                <tr>
                    <th>#</th>
                    <th>日  期</th>
                    <th>收  支</th>
                    <th>類  別</th>
                    <th>描  述</th>
                    <th>金  額</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($_POST["rec_id"]) && !empty($_POST["rec_id"])){
                    $rec_id = $_POST["rec_id"];
                    $sql = "select * from record where rec_id = ?";
                    if($stmt = $db->prepare($sql)){
                        $stmt->execute(array($rec_id));
                        if($result = $stmt->fetchALL()){
                            ?>
                            <tr>
                                <th scope="colgroup">
                                    <input class="btn btn-default" type="button" value="按我更新" onclick="UpdateContent();">
                                    <input class="btn btn-default" type="button" value="按我刪除" onclick="DeleteContent();">
                                </th>
                                <td><input required type="date" id="date" name="date" value="<?php echo $result[0]['date'];?>"/></td>
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
                                </td>

                                <td>
                                    <select id="category_list" name="category">
                                        <?php
                                        $inner = "";
                                        $query = ("SELECT * FROM category where type = ?");
                                        $stmt = $db->prepare($query);
                                        $stmt->execute(array($result[0]['type']));
                                        $result2 = $stmt->fetchAll();
                                        for ($i = $stmt->rowCount() - 1; $i >= 0; $i--) {
                                            if($result[0]['category']!=$result2[$i]['category_name'])
                                                echo "<option>".$result2[$i]['category_name']."</option>" ;
                                            else
                                                echo "<option selected='selected'>".$result2[$i]['category_name']."</option>" ;
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
                                                $result3 = $stmt->fetchAll();
                                                for ($i = $stmt->rowCount() - 1; $i >= 0; $i--) {
                                                    $inner = $inner."<option>".$result3[$i]['category_name']."</option>" ;
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
                                                $result4 = $stmt->fetchAll();
                                                for($i = $stmt->rowCount()-1; $i >=0;$i--){
                                                    $inner = $inner."<option>".$result4[$i]['category_name']."</option>" ;
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
                                <td><input type="text" id="description" name="description" value="<?php echo $result[0]['description'];?>"/></td>
                                <td><input type="text" id="cost" name="cost" value="<?php echo $result[0]['cost'];?>"/></td>
                            </tr>
                            <?php
                        }
                    }
                }else{
                    $sql = "select * from record where ID = ?";
                    if($stmt = $db->prepare($sql)){
                        $stmt->execute(array($ID));
                        $rows = $stmt->fetchAll();
                        if(count($rows) != 0){
                            for($count = 0; $count < count($rows); $count++){
                                ?>
                                <tr>
                                    <th scope="row"><input type="button" value="編輯" onclick="ChangeContent('<?php echo $rows[$count]['rec_id'];?>');"><?php echo $count+1;?></input></th>
                                    <td><?php echo $rows[$count]['date'];?></td>
                                    <td>
                                        <?php
                                            if($rows[$count]['type'])
                                                echo '收入';
                                            else
                                                echo '支出';
                                            ?>
                                    </td>
                                    <td><?php echo $rows[$count]['category'];?></td>
                                    <td>
                                        <?php echo $rows[$count]['description'];?>
                                    </td>
                                    <td><?php echo $rows[$count]['cost'];?></td>
                                </tr>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <tr>
                                <h3>你還沒做過紀錄喔~</h3>
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