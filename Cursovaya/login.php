<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email =  $_POST['email'];
   $pass = $_POST['password'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");

   if(mysqli_num_rows($select_users) == 1){

      while($row = mysqli_fetch_assoc($select_users)){
         
         if (password_verify($pass, $row['password'])){

            if($row['user_type'] == 'admin'){

               $_SESSION['admin_name'] = $row['name'];
               $_SESSION['admin_email'] = $row['email'];
               $_SESSION['admin_id'] = $row['id'];
               header('location:admin_page.php');

            }elseif($row['user_type'] == 'user'){

               $_SESSION['user_name'] = $row['name'];
               $_SESSION['user_email'] = $row['email'];
               $_SESSION['user_id'] = $row['id'];
               header('location:index.php');

            }
         }
         else{
            $message[] = 'Неправильная почта или пароль';
         }
      }
   }else{
      $message[] = 'Неправильная почта или пароль';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="css/style.css">

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
   
<div class="form-container">

   <form action="" method="post">
      <h3>Войти сейчас</h3>
      <input type="email" name="email" placeholder="Введи почту" required class="box">
      <input type="password" name="password" placeholder="Введи свой пароль" required class="box">
      <input type="submit" name="submit" value="Войти" class="btn">
      <p>У тебя нет аккаунта? <a href="register.php">Зарегистрируйся</a></p>
   </form>

</div>

</body>
</html>