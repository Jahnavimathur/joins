<?php
    include("conn.php");
    $id = $_GET['deleteid1'];
    $result = mysqli_query($conn, "DELETE FROM `sub category management` WHERE id = $id");
    header("Location:list2.php");
?>
