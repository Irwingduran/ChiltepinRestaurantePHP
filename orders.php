<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:index.php');
}
;

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mis Ordenes | Chiltepin Restaurant</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <div class="heading">
      <h3>Mis Ordenes</h3>
      <p><a href="index.php">Inicio</a> <span> / Pedidos</span></p>
   </div>

   <section class="orders">

      <h1 class="title">Tus pedidos</h1>

      <div class="box-container">

         <?php
         if ($user_id == '') {
            echo '<p class="empty">Por favor, inicia sesión para ver tus ordenes./p>';
         } else {
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if ($select_orders->rowCount() > 0) {
               while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <div class="box">
                     <p> Fecha y hora : <span>
                           <?= $fetch_orders['placed_on']; ?>
                        </span></p>
                     <p>Nombre : <span>
                           <?= $fetch_orders['name']; ?>
                        </span></p>
                     <p>Email : <span>
                           <?= $fetch_orders['email']; ?>
                        </span></p>
                     <p>Teléfono : <span>
                           <?= $fetch_orders['number']; ?>
                        </span></p>
                     <p>Dirección : <span>
                           <?= $fetch_orders['address']; ?>
                        </span></p>
                     <p>Método de pago : <span>
                           <?= $fetch_orders['method']; ?>
                        </span></p>
                     <p>Tus ordenes : <span>
                           <?= $fetch_orders['total_products']; ?>
                        </span></p>
                     <p>Total : <span>$
                           <?= $fetch_orders['total_price']; ?>/-
                        </span></p>
                     <p> Pago completado: <span style="color:<?php if ($fetch_orders['payment_status'] == 'pendiente') {
                        echo 'red';
                     } else {
                        echo 'green';
                     }
                     ; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                  </div>
                  <?php
               }
            } else {
               echo '<p class="empty">Aún no hay pedidos</p>';
            }
         }
         ?>

      </div>

   </section>










   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->






   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>