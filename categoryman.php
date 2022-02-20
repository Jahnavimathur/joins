<?php  
  include("conn.php");
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     //echo "<pre>";print_r($_POST);die;
     $my_id = $_POST["id"];
     $name = $_POST["name"];
     $url = $_POST["url"];
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
    // echo "<pre>";print_r($img_name);die;
     if($my_id == ""){
      $sql = "INSERT INTO `category management` (`name`, `url`, `image`) VALUES ('$name', '$url', '$img_name')";   
      $result = mysqli_query($conn, $sql);
      if($result){
        header("location:list1.php");
        echo "The record was inserted successfully";
      }else{
        echo "The record was not inserted successfully because of " . mysqli_error($conn);
      } 
    }     
  }

  if(isset($_GET['updateid'])){
    $id = $_GET['updateid'];
    $result_new = mysqli_query($conn, "SELECT * FROM `category management` WHERE id=$id");    
   /*  print_r($row);die; */
   
    while($row = mysqli_fetch_assoc($result_new)){
        $name = $row['name'];
        $url = $row['url']; 
        $image = $row['image'];     
    }
    //echo "<pre>";print_r($img);die;
     //echo $name;die; 
  }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>CATEGORY MANAGEMENT FORM</h2>
    <div>
        <form action="categoryman.php" id="yourform" name="myForm" onSubmit= "return validateForm()"  method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; } ?>">    
            <label for="name">Category Name</label>
            <input type="text" class="label" id="name" name="name" value="<?php if(isset($name)){ echo $name; } ?>" placeholder="Category name.."><div id="name" class="error"></div>

            <label for="url">Category URL</label>
            <input type="text" class="label" id="url" name="url" value="<?php if(isset($url)){ echo $url; } ?>">

            <label for="">Image</label>
            <input type="file"  name="image" value="<?php if(isset($img_des)){ echo $img_des;}?>"><img src="<?php if(isset($img_des)){ echo $img_des; } ?>" alt=""><div id="image" class="error"></div><br>
            <div id="result" style="color: red;"></div>
        
            <input type="submit" value="Submit">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
      $(document).ready(function(){
        jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z'. ]+$/i.test(value);
        }, "*Letters only please");
      });
        $("#yourform").validate({
            rules:{
                name: {
                    required: true,
                    lettersonly:true,
                    minlength:3
                },
                image: {
                    required: true,
                },
            },messages: {
                name: {
                    required: "*Please enter your name",
                    minlength:"*Name should have atleast 3 alphabets"
                },
                image: {
                    required: "*Image is required",
                },
            },
            submitHandler:function(form){
                form.submit();
            }            
        });

    </script>
    <script>
      $(function() {
        $("#name").keyup(function() {
            var name = $("#name").val();
            $("#url").val( name.toLowerCase().replace( /\s+/g, "-" ) );
        });
      });
    </script>
    <script>
      $('#yourform').on('submit',function(){
        $.ajax({
          url:'categoryman.php',
          type:'post',
          data:jQuery('#yourform').serialize(),
          
          success:function(result)
        });
        e.preventDefault();
      });
    </script>
</body>
</html>