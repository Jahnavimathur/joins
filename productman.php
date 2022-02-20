<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>PRODUCT MANAGEMENT FORM</h2>
    <div>
        <form action="form.php" id="yourform" name="myForm" onSubmit= "return validateForm()"  method="post" enctype="multipart/form-data">
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
            <option value='<?php echo $row["name"]; ?>' <?php if(isset($name) && $row["name"] == $name){ echo 'selected';}?>><?php echo $row["name"]?></option>          
            <?php
                }
            ?>
            </select><br><br><div id="name" class="error"></div>  
            <option value="">Select Your Sub Category</option>
            <?php
            include("conn.php");
            $query = mysqli_query($conn,"SELECT * FROM `sub category management`");
            $rowcount = mysqli_num_rows($query);        
            ?>
            <select name="name" id="name">
            <option value="">Select Your Sub Category</option>            
                <?php
                for($i=1; $i<=$rowcount; $i++)
                {
                $row = mysqli_fetch_array($query);   
                ?>          
            <option value='<?php echo $row["name"]; ?>' <?php if(isset($name) && $row["name"] == $name){ echo 'selected';}?>><?php echo $row["name"]?></option>          
            <?php
                }
            ?>
            </select><br><br><div id="name" class="error"></div>
            <label for="name">Product Name</label>
            <input type="text" class="label" id="name" name="name" value="<?php if(isset($name)){ echo $name; } ?>" placeholder="Product name.."><div id="name" class="error"></div>

            <label for="url">Product URL</label>
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
          
          success:function(result){
            alert(result);
          }
        });
        e.preventDefault();
      });
    </script>
</body>
</html>