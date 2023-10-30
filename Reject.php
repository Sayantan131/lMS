<?php 
include 'Conn.php';
$leaveId=$_POST["leaveId"];
$rejectReason=$_POST["rejectReason"];
$sql="UPDATE userleavedetails SET Status='Rejected', reject_Reason='".$rejectReason."' WHERE leaveid=".$leaveId."";

$resultsql = $conn->query($sql);
if ($resultsql) {
    echo 'success';
}
else
{
    echo 'fail';
}

?>