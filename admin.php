
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Approval Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="CSS/admin.css">
</head>
<?php 
include 'Conn.php';
$sql = "SELECT a.*,b.name,c.name as leaveType FROM `userleavedetails` a left JOIN user b on a.userId=b.id LEFT join leavetypemaster c on a.leaveType=c.id where Status='Pending'";
$result = $conn->query($sql);
?>

<body class="bg-image">

<div class="container">
  <h2>Approve The leaves</h2>
  <!-- <p>Test</p>             -->
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Leave Type</th>
        <th>Reason</th>
        <th>Leave Date</th>
        <th>No Of days</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            
            ?>
      <tr>
        <td><?php echo $row["name"] ?></td>
        <td><?php echo $row["leaveType"] ?></td>
        <td><?php echo $row["reason"] ?></td>
        <td><?php echo $row["leaveDate"] ?></td>
        <td><?php echo $row["noOfDays"] ?></td>
        <td><button type="button" class="btn btn-success" onclick="approved(<?php echo $row["leaveid"] ?>)" >Approved</button>
<button type="button" class="btn btn-danger" onclick="reject(<?php echo $row["leaveid"] ?>)">Reject</button>
</td>
      </tr> 
      <?php } } ?>
      
    </tbody>
  </table>
</div>

</body>
</html>

<script>
function approved(id) {

  if (confirm("Do you really want to approve!") == true) {
    $.ajax({
    url: 'approved.php',
    type: 'POST',
    data: { leaveId: id} ,
   
    success: function (response) {
      if(response=='success')
      {
        location.reload();
      }
      else{
        alert('Please try again');
      }
       
    },
    error: function () {
       
    }
    });
  } else {
    text = "You canceled!";
  }


   
}

function reject(id) {

if (confirm("Do you really want to reject!") == true) {

  let rejectReason = prompt("Please enter Reject Reason", "");


  $.ajax({
  url: 'Reject.php',
  type: 'POST',
  data: { leaveId: id,rejectReason:rejectReason} ,
 
  success: function (response) {
    if(response=='success')
    {
      location.reload();
    }
    else{
      alert('Please try again');
    }
     
  },
  error: function () {
     
  }
  });
} else {
  text = "You canceled!";
}


 
}
</script>

