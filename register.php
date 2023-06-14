<?php
include 'config.php';

$db_name = "familyfresh";
$username = "root";
$password = "";
$dsn = "mysql:host=localhost;dbname=" . $db_name;

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

$message = [];

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta charset="utf-8" />
    <title>JtaTech</title>
    <link rel="icon" type="image/png" href="images/jta.png">
    <link rel="stylesheet" type="text/css" href="components.css">
    <link href="https://googleapis.com/css? family=cambria, Cochin, Georgia, Times New Roman, serif " rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

    <nav class="navbar">
        <ul>
            <li>
                <a href="fhome.html">Main</a>
            </li>
        </ul>
    </nav>

    <?php
    if (!empty($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>

    <section class="form-container">

        <form action="" enctype="multipart/form-data" method="POST">
            <h3>register now</h3>
            <input type="text" name="name" class="box" placeholder="enter your name" required />
            <input type="email" name="email" class="box" placeholder="enter your email" required />
            <input type="password" name="pass" class="box" placeholder="enter your password" required />
            <input type="password" name="cpass" class="box" placeholder="confirm your password" required />
            <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png" />
            <input type="submit" value="register now" class="btn" name="submit" />
            <p>
                already have an account? <a href="login.php">login now</a>
            </p>
        </form>

    </section>


</body>
</html>
