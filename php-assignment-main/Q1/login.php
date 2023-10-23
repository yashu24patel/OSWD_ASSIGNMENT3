<?php
session_start();
include('./connection/dbconnect.php');
if (isset($_POST['login_btn'])) {

    $login = false;
    $showerror = false;
    $log = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE email = '" . $log . "' OR phone = '" . $log . "'";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $login = true;
                $_SESSION['loggedin'] = true;
                if ($row['role'] == 'admin') {
                    $_SESSION['admin_email'] = $log;
                    $_SESSION['admin'] = $row;
                    header('location:./admin/index.php');
                } else {
                    $_SESSION['user_email'] = $log;
                    $_SESSION['User'] = $row;
                    header('location:./user/index.php');
                }
            } else {
                $showerror = "incorrect email or password";
            }
        }
    } else {
        $showerror = "incorrect email or password";
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
    <center>
        <h1>Login</h1>
        <form class="col-md-4" method="post">
            <table>
                <tr>
                    <td>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                        </div>
                    </td>
                    <td>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="2"></th>
                </tr>
            </table>
            <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
        </form>

    </center>


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