<?php  
   include("conn.php");
    
    if(isset($_POST['update'])){
        $name = $_POST['name'];
        $cname= $_POST['cname'];
        $url =$_POST['url'];
        if(isset($_FILES['image'])){
            $image = $_FILES['image'];
          // print_r($_FILES['image']);
            $img_name = $_FILES['image']['name'];
            $extension = pathinfo($img_name, PATHINFO_EXTENSION);      
            $randomno = rand(0, 100000);
            $rename = 'Upload'.date('Ymd').$randomno;
            echo $newname = $rename.'.'.$extension;
            $img_loc = $_FILES['image']['tmp_name'];        
            $img_des = "uploadImage/" .$img_name;
            move_uploaded_file($img_loc, 'uploadImage/'. $img_name); 
          }
        $sql = 	"UPDATE `sub category management` SET name='$name',url='$url', image='$img_name' WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        
        if($result)
        {
            echo 'form updated';
            header("location:list2.php");
            
        }
        else
        {
            echo ' Please Check Your Query ';
        }
    }
    else{
        header("location:list2.php");
    }   
?>