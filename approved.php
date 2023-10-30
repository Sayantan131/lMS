<?php 
include 'Conn.php';
$leaveId=$_POST["leaveId"];
$sql="UPDATE userleavedetails SET Status='Approved' WHERE leaveid=".$leaveId."";

$resultsql = $conn->query($sql);
if ($resultsql) {
    echo 'success';
}
else
{
    echo 'fail';
}

?>