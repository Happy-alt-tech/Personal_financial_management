<?php
session_start();
include 'config.php';

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Removed MD5 encryption
 
    $query = "SELECT * FROM user_form WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
 
    if(mysqli_num_rows($result) > 0){
       $row = mysqli_fetch_assoc($result);
       
       if ($row['status'] == 'approved') {
        $_SESSION['user_email'] = $email;
        $_SESSION['name'] = $row['name']; // ✅ User ka name session me save karna zaroori hai
        echo "<script>alert('Login Successfully!'); window.location.href='main.html';</script>"; 
        exit();
    }
    
       } else {
          echo "<script>alert('Your account is not approved yet. Please wait for admin approval.');</script>";
       }
    } else {
       echo "<script>alert('Incorrect email or password!');</script>";
    }

?>


<!DOCTYPE html> 
<html lang="en"> 
<head>    
    <meta charset="UTF-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Login</title>     
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
            padding: 20px;            
            border-radius: 10px;            
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);            
            width: 300px;        
        }         
        h2 {            
            text-align: center;            
            margin-bottom: 20px;            
            font-size: 24px;            
            color: #47e20f;        
        }         
        .form-container label {            
            display: block;            
            margin-bottom: 5px;            
            font-weight: bold;        
        }         
        .form-container input {            
            width: 90%;            
            padding: 10px;            
            margin-bottom: 10px;            
            border: none;            
            border-radius: 5px;            
            outline: none;            
            background: rgba(255, 255, 255, 0.8);            
            color: #333;        
        }         
        .form-container input[type="submit"] {            
            background: #52fb04;            
            color: #fff;            
            font-weight: bold;            
            cursor: pointer;        
        }         
        .form-container input[type="submit"]:hover {            
            background: #d8fc2573;        
        }         
        .error {            
            color: red;            
            font-size: 12px;            
            margin-top: -10px;            
            margin-bottom: 10px;        
        }         
        .switch {            
            text-align: center;        
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
            <h3>Login now</h3>       
            <?php       
            if(isset($message)){          
                foreach($message as $message){             
                    echo '<div class="error">'.$message.'</div>';          
                }       
            }       
            ?>       
            <input type="email" name="email" placeholder="Enter email" class="box" required>       
            <input type="password" name="password" placeholder="Enter password" class="box" required>       
            <input type="submit" name="submit" value="Login Now" class="btn">       
            <p>Don't have an account? <a href="register.php">Register now</a></p>    
        </form> 
    </div>  
</body> 
</html>
