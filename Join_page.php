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
   $phone = ($_POST['phone']);
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $company = ($_POST['company']);
   $company = filter_var($company, FILTER_SANITIZE_STRING);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta charset="utf-8" />
    <title>JionUS</title>
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
            <h3>Join</h3>
            <input type="text" name="name" class="box" placeholder="enter your name" required />
            <input type="email" name="email" class="box" placeholder="enter your email" required />
            <input type="tel" name="phone" class="box" placeholder="enter your phone number" required />
            <input type="text" name="company" class="box" placeholder="enter company name" required />
            <input type="submit" value="Join now" class="btn" name="submit" />
        </form>

    </section>


</body>
</html>
