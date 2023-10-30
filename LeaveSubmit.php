<?php
include 'Conn.php';
  
$leaveType=$_POST["leaveType"];
 $NoOfDays=$_POST["NoOfDays"];
  $Reason=$_POST["Reason"];
 $date=$_POST["date"];
 $InsertLeaveSQL = "INSERT INTO userleavedetails (userId, leaveType, noOfDays,leaveDate,reason,Status)
 VALUES (".$_SESSION['id'].", ".$leaveType.", ".$NoOfDays.",'".$date."', '".$Reason."','Pending')";

$resultInsert = $conn->query($InsertLeaveSQL);
if ($resultInsert) {
    $_SESSION['msg']='Leave Applied Successfully';
    header("Location: user.php");
}





?>