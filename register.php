<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
;

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_UNSAFE_RAW);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_UNSAFE_RAW);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_UNSAFE_RAW);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_UNSAFE_RAW);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_UNSAFE_RAW);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $message[] = 'El correo o número telefónico ya han sido registrados';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Las contraseñas no coinciden';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if ($select_user->rowCount() > 0) {
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registrate | Chiltepin Restaurant</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <section class="form-container">

      <form action="" method="post">
         <h3>Regístrese ahora</h3>
         <input type="text" name="name" required placeholder="Introduce tu nombre y apellido" class="box"
            maxlength="50">
         <input type="email" name="email" required placeholder="Introduce tu correo electrónico" class="box"
            maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="number" name="number" required placeholder="Introduce un número telefónico" class="box" min="0"
            max="9999999999" maxlength="10">
         <input type="password" name="pass" required placeholder="Crea una contraseña" class="box" maxlength="50"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="Vuelve a escribir tu contraseña" class="box"
            maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Crear perfil" name="submit" class="btn">
         <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
      </form>

   </section>











   <?php include 'components/footer.php'; ?>







   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>