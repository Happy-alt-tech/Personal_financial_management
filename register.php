<?php
include 'config.php';
session_start();

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password']; // Removed MD5 encryption
   $cpass = $_POST['cpassword'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   if (!is_dir('uploaded_img')) {
       mkdir('uploaded_img', 0777, true);
   }

   // Check if email already exists
   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die(mysqli_error($conn));

   if(mysqli_num_rows($select) > 0){
      echo "<script>alert('User already exists!');</script>";
   } else {
      if($pass != $cpass){
         echo "<script>alert('Confirm password not matched!');</script>";
      } elseif($image_size > 2000000){
         echo "<script>alert('Image size is too large!');</script>";
      } else {
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image, status) 
         VALUES ('$name', '$email', '$pass', '$image', 'pending')") or die(mysqli_error($conn));

         if($insert){
             move_uploaded_file($image_tmp_name, $image_folder);
             echo "<script>alert('Your registration request has been sent. Wait for admin approval.');</script>";
         } else {
             echo "<script>alert('Registration failed!');</script>";
         }
      }
   }
}
?>



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

      body {
         font-family: "montserrat";
         background-image: url("http://localhost/PHP/finance_background_with_humans.jpg");
         background-attachment: fixed;
         background-size: 100% 100%;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         margin: 0;
         color: #fff;
      }

      .form-container {
         backdrop-filter: blur(10px);
         padding: 30px;
         border-radius: 10px;
         background: rgba(0, 108, 22, 0.3);
         box-shadow: 0 4px 30px rgba(21, 106, 0, 0.1);
         width: 500px;
      }

      h2 {
         text-align: center;
         margin-bottom: 20px;
         font-size: 28px;
         color: #47e20f;
      }

      .form-container label {
         display: block;
         margin-bottom: 8px;
         font-weight: bold;
         font-size: 18px;
      }

      .form-container input {
         width: 95%;
         padding: 12px;
         margin-bottom: 12px;
         border: none;
         border-radius: 5px;
         outline: none;
         background: rgba(255, 255, 255, 0.8);
         color: #333;
         font-size: 16px;
      }

      .form-container input[type="submit"] {
         background: #52fb04;
         color: #fff;
         font-weight: bold;
         cursor: pointer;
         font-size: 18px;
      }

      .form-container input[type="submit"]:hover {
         background: #d8fc2573;
      }

      .switch {
         text-align: center;
         font-size: 16px;
      }

      .switch a {
         color: #85ed0e;
         text-decoration: none;
         font-weight: bold;
      }

      .switch a:hover {
         text-decoration: underline;
      }
   </style>
</head>
<body>
   <div class="form-container">
      <form action="" method="post" enctype="multipart/form-data">
         <h2>Register Now</h2>
         <input type="text" name="name" placeholder="Enter Username" required>
         <input type="email" name="email" placeholder="Enter Email" required>
         <input type="password" name="password" placeholder="Enter Password" required>
         <input type="password" name="cpassword" placeholder="Confirm Password" required>
         <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">
         <input type="submit" name="submit" value="Register Now">
         <p class="switch">Already have an account? <a href="login.php">Login Now</a></p>
      </form>
   </div>

   <script>
function checkApprovalStatus() {
    fetch('check_status.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'approved') {
            clearInterval(checkInterval); // स्टेटस चेक करना बंद करें
            
            alert('Your request has been approved! Redirecting to login page...');
            
            // यूज़र को लॉगिन पेज पर भेजें
            window.location.href = 'login.php';
        }
    })
    .catch(error => console.error('Error:', error));
}

// हर 5 सेकंड में स्टेटस चेक करेगा
let checkInterval = setInterval(checkApprovalStatus, 10000);
</script>


</body>
</html>
