<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Apply Leave</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="CSS/user.css">
  </head>
  <?php 
include 'Conn.php';
$pendingLeavessql = "SELECT sum(noOfDays) as ApprovedLeaves,leaveType FROM userleavedetails WHERE userId=".$_SESSION['id']." and Status='Approved' GROUP by leaveType;";
$pendingLeavessqlresult = $conn->query($pendingLeavessql);
$rowLeaves = $pendingLeavessqlresult->fetch_all(MYSQLI_ASSOC);
$approvedCasualLeave=0;
$approvedSickLeave=0;
$approvedEarnedLeave=0;
foreach($rowLeaves as $key => $value){
    $approvedLeaveCount= $value['ApprovedLeaves']; 
    $approvedLeaveType=$value['leaveType'];
    if($approvedLeaveType==1)
    {
         $approvedCasualLeave=$approvedLeaveCount;
    }
    if($approvedLeaveType==2)
    {
         $approvedSickLeave=$approvedLeaveCount;
    }
    if($approvedLeaveType==3)
    {
         $approvedEarnedLeave=$approvedLeaveCount;
    }
    
}

$Leavedetailssql = "SELECT a.*,b.name,c.name as leaveType FROM `userleavedetails` a left JOIN user b on a.userId=b.id LEFT join leavetypemaster c on a.leaveType=c.id where a.userId=".$_SESSION['id']."";
$resultDetails = $conn->query($Leavedetailssql);


$LeaveType = "SELECT * FROM leavetypemaster";
$LeaveTyperesult = $conn->query($LeaveType);
$LeaveTyperesultArray = $LeaveTyperesult->fetch_all();
  $pendingSickLeaves=$LeaveTyperesultArray[1][2]-$approvedSickLeave; 
 $pendingCasualLeaves=$LeaveTyperesultArray[0][2]-$approvedCasualLeave;
 $pendingEarnedLeaves=$LeaveTyperesultArray[2][2]-$approvedEarnedLeave;


?>
  <body class="bg-image">
  
    <!-- <div class="welcome">
    Welcome <?php
      echo $_SESSION["name"]; echo '<br>';
   
      if(isset($_SESSION['msg']))
      {
        echo $_SESSION['msg'];
        $_SESSION['msg']='';
      }
      ?>
    </div> -->
    
    <div class="container">
  <h2>Please Fill the form to apply the leave</h2>
  <form method="post" action="LeaveSubmit.php" >
    <div class="form-group">
      <label for="type">Leave Type:</label>
      <select name="leaveType" > 
      <option value=""?>--Please select Type--</option>
<?php foreach($LeaveTyperesultArray as $key => $value){ ?>
                <option value="<?php echo $value[0];?>"><?php echo $value[1];     ?></option> 
<?php } ?>
    </select>
    </div>
    <div class="form-group">
      <label for="days">No Of Days:</label>
      <input type="text" class="form-control" id="pwd" placeholder="Enter No Of Days" name="NoOfDays" value="">
    </div>
    <div class="form-group">
      <label for="Reason">Reason:</label>
      <input type="text" class="form-control" id="pwd" placeholder="Enter Reason" name="Reason" value="">
    </div>
    <div class="form-group">
      <label for="date">Leave Date:</label>
      <input type="date" class="form-control" id="pwd" placeholder="Enter Date" name="date" value="">
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
</div>

<div class="leave_balance">
  <h2>Leave Balance</h2>
  Casual <button type="button" class="btn btn-primary"><?php echo $pendingCasualLeaves ?></button>
  Sick <button type="button" class="btn btn-success"><?php echo $pendingSickLeaves ?></button>
  Earned <button type="button" class="btn btn-info"><?php echo $pendingEarnedLeaves ?></button>
      
</div>


<div class="leave_details">
  <h2>Leave Details</h2>
  <!-- <p>Test</p>             -->
  <table class="table">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Leave Reason</th>
        <th>Leave Date</th>
        <th>No Of days</th>
        <th>Status</th>
        <th>Reject Reason</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($resultDetails->num_rows > 0) { 
        while($row = $resultDetails->fetch_assoc()) { 
            
            ?>
      <tr>
    
        <td><?php echo $row["leaveType"] ?></td>
        <td><?php echo $row["reason"] ?></td>
        <td><?php echo $row["leaveDate"] ?></td>
        <td><?php echo $row["noOfDays"] ?></td>
        <td><?php echo $row["Status"] ?></td>
        <td><?php echo $row["reject_Reason"] ?></td>
        
      </tr> 
      <?php } } ?>
      
    </tbody>
  </table>
</div>

  </body>
  </html>


