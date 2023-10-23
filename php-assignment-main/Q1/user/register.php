<?php
session_start();
include('../connection/dbconnect.php');

if (isset($_POST['login_btn'])) {
    $login = false;
    $showerror = false;
    if ($_POST["vercode"] != $_SESSION["vercode"] || $_SESSION["vercode"] == "") {
        echo "<script>  alert('Incorrect Verification Code..!!'); </script>";
        $showerror = "Incorrect Verification Code..!!";
    } else {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' OR phone = '" . $phone . "'";
        $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            $showerror = "User already exist.";
        } elseif (!isset($name) || !isset($email) || !isset($password) || !isset($phone)) {
            $showerror = "Please Enter Details";
        } else {
            if (($password == $cpassword)) {
                $has = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` ( `name`,`phone`,`email`, `password`) VALUES ('$name','$phone','$email', '$has')";
                $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
                if ($result) {
                    $showalert = true;
                    header('Location: ../login.php');
                }
            } else {
                $showerror = "Please Enter Correct Details";
            }
        }
    }
} else {
    $login = "";
    $showerror = "";
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login</title>
</head>


<body class="container">
    <?php
    if ($login) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success !</strong> you are loggedin
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($showerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Failed !</strong> ' . $showerror . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <h1>Login Here</h1>
    <div class="row">
        <form class="col-md-6" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="number" class="form-control" name="phone" id="phone">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="cpassword" id="cpassword">
            </div>
            <div class="mb-3">
                <img src="captcha.php" alt="captcha">
                <input type="text" name="vercode">
            </div>
            <button type="submit" name="login_btn" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>