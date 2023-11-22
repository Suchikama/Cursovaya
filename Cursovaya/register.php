<?php

include 'config.php';

if(isset($_POST['submit'])){

   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];

   if($pass != $cpass){
      $message[] = 'Пароли не совпадают!';
   } else {
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $pass = password_hash($_POST['password'],PASSWORD_DEFAULT);
      $cpass = password_hash($_POST['cpassword'],PASSWORD_DEFAULT);
      $user_type = $_POST['user_type'];

      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
      if(mysqli_num_rows($select_users) > 0){
         $message[] = 'Пользователь занят!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'Регистрация успешна!';
         header('location:login.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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
      <h3>Регистрация</h3>
      <input type="text" name="name" placeholder="Введи своё имя" required class="box">
      <input type="email" name="email" placeholder="Введи свою почту" required class="box">
      <input type="password" name="password" placeholder="Введи свой пароль" required class="box">
      <input type="password" name="cpassword" placeholder="Подтверди свой пароль" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="Зарегистрироваться" class="btn">
      <p>Есть уже аккаунт? <a href="login.php">Ввойти сейчас</a></p>
   </form>

</div>

</body>
</html>