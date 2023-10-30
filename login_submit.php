<?php

include 'Conn.php';
$id=$_POST["id"];
$password=$_POST["pwd"];

$sql = "SELECT id, name, password, type FROM user where id='$id' and password = '$password' ";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();


    if($id==$row['id'] && $password== $row['password'])
    {
      $_SESSION["id"] = $row['id'];
      $_SESSION["name"] = $row['name'];
      $_SESSION["loginType"] = $row['type'];
        $type= $row['type'];
        if($type=='admin')
        {
            header("Location: admin.php");
        }
        else
        {
            header("Location: user.php");
        }
    }

  }
 else {
  echo "wrong credential";
}
$conn->close();
?>