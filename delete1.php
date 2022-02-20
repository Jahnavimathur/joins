<?php
    include("conn.php");
    $id = $_GET['deleteid'];
    $result = mysqli_query($conn, "DELETE FROM `category management` WHERE id = $id");
    header("Location:list1.php");
?>
