<?php
 include("connection.php");
$id=$_GET['id'];
 $result = mysqli_query($connection, "delete from trainees where Trainee_Id=$id");


 if ($result) {
    echo "<script>window.location.href='trainnees.php'</script>";
 }
?>