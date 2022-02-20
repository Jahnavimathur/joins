<?php  
  include("conn.php");
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     //echo "<pre>";print_r($_POST);die;
     $my_id = $_POST["id"];
     $name = $_POST["name"];
     $cname = $_POST["cname"];
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
     //echo "<pre>";print_r($img);die;
     if($my_id == ""){
      $sql = "INSERT INTO `sub category management` (`category`,`cname`, `url`, `image`) VALUES ('$name','$cname', '$url', '$img_name')";   
      $result = mysqli_query($conn, $sql);
      if($result){
        echo "The record was inserted successfully";
      }else{
        echo "The record was not inserted successfully because of " . mysqli_error($conn);
      } 
    }     
  }
  if(isset($_GET['updateid1'])){
    $id = $_GET['updateid1'];
    $result_new = mysqli_query($conn, "SELECT * FROM `sub category management` WHERE id=$id");    
   /*  print_r($row);die; */
   
    while($row = mysqli_fetch_assoc($result_new)){
        $name = $row['name'];
        $cname = $row['cname'];
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
    <title>SUB Category Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>SUB CATEGORY MANAGEMENT FORM</h2>
    <div>
        <form action="subcategoryman.php" id="yourform" name="myForm" onSubmit= "return validateForm()"  method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; } ?>">    

            <option value="">Select Your Category</option>
            <?php
            include("conn.php");
            $query = mysqli_query($conn,"SELECT * FROM `category management`");
            $rowcount = mysqli_num_rows($query);        
            ?>
            <select name="name" id="name">
            <option value="">Select Your Category</option>            
                <?php
                for($i=1; $i<=$rowcount; $i++)
                {
                $row = mysqli_fetch_array($query);            
                ?>          
            <option value='<?php echo $row["name"]; ?>'  <?php if(isset($name) && $row["name"] == $name){ echo 'selected';}?>><?php echo $row["name"]?></option>          
            <?php
                }
            ?>
            </select><br><br><div id="name" class="error"></div>


            <label for="cname">Sub Category Name</label>
            <input type="text" class="label" id="cname" name="cname" value="<?php if(isset($cname)){ echo $cname; } ?>" placeholder="Sub Category name.."><div id="cname" class="error"></div>

            <label for="url">Sub Category URL</label>
            <input type="text" class="label" id="url" name="url" value="<?php if(isset($url)){ echo $url; } ?>">

            <label for="">Image</label>
            <input type="file"  name="image" value="<?php if(isset($image)){ echo $image;}?>"><img src="<?php if(isset($image)){ echo $image; } ?>" alt=""><div id="image" class="error"></div>
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
              name:{
                required: true,
              },
              cname: {
                required: true,
                lettersonly:true,
                minlength:3
              },
              image: {
                required: true,
              },
            },messages: {
              name:{
                required: "*Please select your category"
              }
              cname: {
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
        $("#cname").keyup(function() {
          var name = $("#cname").val();
          $("#url").val( name.toLowerCase().replace( /\s+/g, "-" ));
        });
      });
    </script>
    <script>
      $('#yourform').on('submit',function(){
        $.ajax({
          url:'categoryman.php',
          type:'post',
          data:jQuery('#yourform').serialize(),
          
          success:function(result){
            alert(result);
          }
        });
        e.preventDefault();
      });
    </script>
</body>
</html>