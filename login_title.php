<?php

?>
<div class="menu">
    <table class="menu_css">
        <tr>
            <th>
                Hi~<?php echo $_SESSION['name'] ?>
                <button onclick="confirmEvent()">點我登出</button>

                <script>
                    function confirmEvent() {
                        if (confirm("確定要登出嗎?")) {
                            alert("已登出");
                            location.href="logout.php";
                            location.href="login.php";
                        }
                    }
                </script>
            </th>
            <td>
                <a href="editRecord.php">Home</a>
            </td>
            <td>
                <a href="editCategory.php">編輯類別</a>
            </td>
            <td>
                <a href="bookkeeping.php">新增紀錄</a>
            </td>
            <td>
                <a href="insert_category.php">新增類別</a>
            </td>
        </tr>
    </table>
    <table class="menu_search">

    </table>
</div>
