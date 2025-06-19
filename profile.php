<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE user_register SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched..!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched..!';
      }else{
         mysqli_query($conn, "UPDATE user_register SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully..!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
          $message[] = 'image is too large..';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE user_register SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully..!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   

</head>
<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

:root{
   --blue:#3498db;
   --dark-blue:#2980b9;
   --red:#e74c3c;
   --dark-red:#c0392b;
   --black:#333;
   --white:#fff;
   --light-bg:#eee;
   --box-shadow:0 5px 10px rgba(0,0,0,.1);
}

*{
   font-family: 'Poppins', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border: none;
   text-decoration: none;
}

*::-webkit-scrollbar{
   width: 10px;
}

*::-webkit-scrollbar-track{
   background-color: transparent;
}

*::-webkit-scrollbar-thumb{
   background-color: var(--blue);
}

.btn,
.delete-btn{
   width: 100%;
   border-radius: 5px;
   padding:10px 30px;
   color:var(--white);
   display: block;
   text-align: center;
   cursor: pointer;
   font-size: 20px;
   margin-top: 10px;
}

.btn{
   background-color:  #fbd0d9;
   color: crimson;
   font-size: 25px;
}

.btn:hover{
   background: rgba(0,0,0,.5);
   color: #fff;
}

.delete-btn{
   background-color:  #fbd0d9;
   color: crimson;
   font-size: 25px;
}

.delete-btn:hover{
   background: rgba(0,0,0,.5);
   color: #fff; 
}

.message{
   margin:10px 0;
   width: 100%;
   border-radius: 5px;
   padding:10px;
   text-align: center;
   background-color: rgb(235, 174, 174);
   color:var(--white);
   font-size: 20px;
}



.form-container{
   
   min-height: 100vh;
   background-color: var(--light-bg);
   display: flex;
   align-items: center;
   justify-content: center;
   padding:20px;
}

.form-container form{
   padding:20px;
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   text-align: center;
   width: 500px;
   border-radius: 5px;
}

.form-container form h3{
          font-size: 50px;
          text-transform: uppercase;
          margin-bottom: 10px;
          color: #333;
}

.form-container form .box{
   width: 100%;
   border-radius: 5px;
   padding:10px 15px;
   font-size: 22px;
   color:var(--black);
   margin:10px 0;
   background-color: #eee;
}
.form-container form .box .fa-eye {
   position: absolute;
   top: 50%;
   font-size: 22px;
   right: 15px;
   transform: translateY(-50%);
   cursor: pointer;
   color: #333;
}

.form-container form p{
   margin-top: 10px;
   font-size: 24px;
   color: #333;
}


.form-container form p a{
   color: maroon;
}

.form-container form p a:hover{
   text-decoration: underline;
}

.container{
   min-height: 100vh;
   background-color: var(--light-bg);
   display: flex;
   align-items: center;
   justify-content: center;
   padding:20px;
}

.container .profile{
   padding:20px;
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   text-align: center;
   width: 400px;
   border-radius: 5px;
}

.container .profile img{
   height: 150px;
   width: 150px;
   border-radius: 50%;
   object-fit: cover;
   margin-bottom: 5px;
}

.container .profile h3{
   margin:5px 0;
   font-size: 20px;
   color:var(--black);
}

.container .profile p{
   margin-top: 20px;
   color:var(--black);
   font-size: 20px;
}

.container .profile p a{
   color:var(--red);
}

.container .profile p a:hover{
   text-decoration: underline;
}

.update-profile{
   min-height: 100vh;
   background-color: var(--light-bg);
   display: flex;
   align-items: center;
   justify-content: center;
   padding:20px;
}

.update-profile form{
   padding:20px;
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   text-align: center;
   width: 700px;
   text-align: center;
   border-radius: 5px;
}

.update-profile form img{
   height: 200px;
   width: 200p;
   border-radius: 50%;
   object-fit: cover;
   margin-bottom: 5px;
}

.update-profile form .flex{
   display: flex;
   justify-content: space-between;
   margin-bottom: 20px;
   gap:15px;
}

.update-profile form .flex .inputBox{
   width: 49%;
}

.update-profile form .flex .inputBox span{
   text-align: left;
   display: block;
   margin-top: 15px;
   font-size: 17px;
   color:var(--black);
}

.update-profile form .flex .inputBox .box{
   width: 100%;
   border-radius: 5px;
   background-color: var(--light-bg);
   padding:12px 14px;
   font-size: 17px;
   color:var(--black);
   margin-top: 10px;
}

@media (max-width:650px){
   .update-profile form .flex{
      flex-wrap: wrap;
      gap:0;
   }
   .update-profile form .flex .inputBox{
      width: 100%;
   }
}
   </style>

<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM user_register WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <span>your email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            <span>update your pic :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="main.html" class="delete-btn">go back</a>
   </form>

</div>

</body>
</html>