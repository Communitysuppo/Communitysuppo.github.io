<?php

include 'config.php';

session_start(); 

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, image) VALUES(?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, quantity, image) VALUES(?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge" />
    <meta charset="utf-8" />
    <title>JtaTech</title>
    <link rel="icon" type="image/png" href="images/jta.png" />
    <link rel="stylesheet" type="text/css" href="css_style.css" />
    <link href="https://googleapis.com/css? family=cambria, Cochin, Georgia, Times New Roman, serif " rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

    <?php include 'header.php'; ?>
    
    <div class="home-bg">

        <section class="home">

            <div class="content">
                <span>Pantry Delivery</span>
                <h3>Current list of products </h3>
                <p>Please follow guidlines as provide when placing orders </p>
                <a href="about.php" class="btn">FAQs</a>
            </div>

        </section>

    </div>

    <section class="home-category">

        <h1 class="title">shop by category</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/fruit.png" alt="" />
                <h3>fruits</h3>
                <p>" "</p>
                <a href="category.php?category=fruits" class="btn">fruits</a>
            </div>

            <div class="box">
                <img src="images/meat.png" alt="" />
                <h3>Meats</h3>
                <p>" "</p>
                <a href="category.php?category=meat" class="btn">meat</a>
            </div>

            <div class="box">
                <img src="images/vegs.png" alt="" />
                <h3>Vegitables</h3>
                <p> " "</p>
                <a href="category.php?category=vegitables" class="btn">vegitables</a>
            </div>

            <div class="box">
                <img src="images/dairy.jpg" alt="" />
                <h3>Diary</h3>
                <p>" "</p>
                <a href="category.php?category=fish" class="btn">fish</a>
            </div>

        </div>

    </section>
    <br />
    <br />

    <section class="products">


        <div class="box-container">

            <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" class="box" method="POST">
                <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="" />
                <div class="name">
                    <?= $fetch_products['name']; ?>
                </div>
                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>" />
                <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>" />
                <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>" />
                <input type="number" min="1" value="1" name="p_qty" class="qty" />
                <input type="submit" value="add to cart" class="btn" name="add_to_cart" />
            </form>
            <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
            ?>

        </div>

    </section>
  


    <script src="script.js"></script>

</body>
</html>