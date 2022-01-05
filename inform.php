<?php
header("Content-type:text/html;charset=utf-8");
include "db_conn.php";

echo "<table border='1'>
<tr>
<th>Type</th>
<th>Date</th>
<th>Description</th>
<th>cost</th>
<th>Category</th>
</tr>";

$query = ("select * from record");
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();

for($i=0;$i<count($result);$i++){
    echo "<tr>";
    echo "<td>".$result[$i]['type']."</td>";
    echo "<td>".$result[$i]['date']."</td>";
    echo "<td>".$result[$i]['description']."</td>";
    echo "<td>".$result[$i]['cost']."</td>";
    echo "<td>".$result[$i]['category']."</td>";
    echo "</tr>.";
}
echo "</table>";
echo "<br><input type ='button' onclick='history.back()' value='Go Back'></input>"
?>