<?php

include 'config.php';


if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select->execute([$email, $pass]);
   $row = $select->fetch(PDO::FETCH_ASSOC);

   if($select->rowCount() > 0){

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_id'] = $row['id'];
         header('location:user.php');

      }else{
         $message[] = 'no user found!';
      }
      
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="fuel.css">

</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
  

<nav class="navbar bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="img/logo2.jpg" alt="Logo" width="70" height="80" class="d-inline-block align-text-top">
      Home
    </a>
  </div>
</nav>




<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Login now</h3>
      <input type="email" required placeholder="enter your email" class="box" name="email">
      <input type="password" required placeholder="enter your password" class="box" name="pass">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
      <input type="submit" value="Login now" class="btn" name="submit">
   </form>

</section>

</body>
</html>