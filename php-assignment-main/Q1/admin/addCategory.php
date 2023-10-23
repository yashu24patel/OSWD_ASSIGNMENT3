<?php
include('../connection/dbconnect.php');
if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $success = false;
    $showerror = false;
    $cat_name = $_POST['name'];
    $sql = mysqli_query($conn, "SELECT * FROM category WHERE name='$cat_name'") or die("SQL Query Failed.");
    $existnumrows = mysqli_num_rows($sql);
    if ($existnumrows > 0) {
        $showerror = "Category already Exist.";
    } elseif (empty($cat_name)) {
        $showerror = "Please Enter Category";
    } else {
        if (isset($cat_name)) {
            $sql = mysqli_query($conn, "INSERT INTO category(name) VALUES('" . $cat_name . "')");
            if ($sql) {
                $success = true;
            }
        } else {
            $showerror = "Please Enter Category ";
        }
    }
} else {
    $success = "";
    $showerror = "";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <?php
        if ($success) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success !</strong> Category Added Successfully.
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
        <a href="listCategory.php"><button type="button" class="btn btn-info">List Category</button></a>
        <h3 class="mt-3">Add New Category</h3>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>