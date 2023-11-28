<?php

if (isset($_POST['add_to_cart'])) {

   if ($user_id == '') {
      header('location:login.php');
   } else {

      $pid = $_POST['pid'];
      $pid = filter_var($pid, );
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_UNSAFE_RAW);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_UNSAFE_RAW);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_UNSAFE_RAW);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_UNSAFE_RAW);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if ($check_cart_numbers->rowCount() > 0) {
         $message[] = '¡Ya se ha añadido al carrito!';
      } else {
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = '¡Añadido al carrito!';

      }

   }

}

?>