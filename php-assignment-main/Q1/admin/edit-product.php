<?php
include('../connection/dbconnect.php');
$id = $_GET['id'];

if (isset($_GET['id'])) {
    $sql = "SELECT products.*,product_images.image,category.name as category_name FROM products LEFT JOIN category ON products.category_id=category.id LEFT JOIN product_images ON products.id=product_images.product_id WHERE products.id='" . $id . "'";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    $row = mysqli_fetch_assoc($result);
} else {
    header('location:./listCategory.php');
}

if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $success = false;
    $showerror = false;
    $product_name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    if (empty($product_name) || empty($category_id) || empty($price) || empty($id)) {
        $showerror = "Please Fill all details";
    } else {
        if (isset($product_name) && isset($price) && isset($id) && isset($category_id)) {
            $query = mysqli_query($conn, "UPDATE products SET  name='" . $product_name . "', price='".$price."', category_id='".$category_id."' WHERE id='" . $id . "'");
            if ($sql) {
                if(isset($_FILES['image'])){
                    $image = $_FILES["image"]['name'];
                    $image_type = $_FILES["image"]['type'];
                    $image_size = $_FILES["image"]['size'];
                    $image_tmp = $_FILES["image"]['tmp_name'];
                    move_uploaded_file($image_tmp, "../assets/img/".$image);
                    $sql = mysqli_query($conn, "UPDATE product_images SET image='" . $image . "' WHERE id='" . $id . "' ");
                }
                $success = true;
                header('location:./listProduct.php');
            }
        } else {
            $showerror = "Please fill all details ";
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
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
    <style>
        .fileinput-preview {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 5px;
        }

        .fileinput-preview img {
            width: 190px;
        }

        @media (max-width: 1199px) {
            .fileinput {
                margin-bottom: 9px;
                display: inline-block;
            }

            .fileinput .form-control {
                padding-top: 7px;
                padding-bottom: 5px;
                display: inline-block;
                margin-bottom: 0;
                vertical-align: middle;
                cursor: text;
            }

            .fileinput .thumbnail {
                overflow: hidden;
                display: inline-block;
                margin-bottom: 5px;
                vertical-align: middle;
                text-align: center;
            }

            .fileinput .thumbnail>img {
                max-height: 100%;
            }

            .fileinput .btn {
                vertical-align: middle;
            }

            .fileinput-exists .fileinput-new,
            .fileinput-new .fileinput-exists {
                display: none;
            }

            .fileinput-inline .fileinput-controls {
                display: inline;
            }

            .fileinput-filename {
                vertical-align: middle;
                display: inline-block;
                overflow: hidden;
            }

            .form-control .fileinput-filename {
                vertical-align: bottom;
            }

            .fileinput.input-group {
                display: flex;
            }

            .fileinput.input-group>* {
                position: relative;
                z-index: 2;
            }

            .fileinput.input-group>.btn-file {
                z-index: 1;
            }

            .fileinput-new.input-group .btn-file,
            .fileinput-new .input-group .btn-file {
                border-radius: 0 4px 4px 0;
            }

            .fileinput-new.input-group .btn-file.btn-xs,
            .fileinput-new .input-group .btn-file.btn-xs,
            .fileinput-new.input-group .btn-file.btn-sm,
            .fileinput-new .input-group .btn-file.btn-sm {
                border-radius: 0 3px 3px 0;
            }

            .fileinput-new.input-group .btn-file.btn-lg,
            .fileinput-new .input-group .btn-file.btn-lg {
                border-radius: 0 6px 6px 0;
            }

            .has-warning .fileinput .fileinput-preview {
                color: #8a6d3b;
            }

            .has-warning .fileinput .thumbnail {
                border-color: #faebcc;
            }

            .has-error .fileinput .fileinput-preview {
                color: #a94442;
            }

            .has-error .fileinput .thumbnail {
                border-color: #ebccd1;
            }

            .has-success .fileinput .fileinput-preview {
                color: #3c763d;
            }

            .has-success .fileinput .thumbnail {
                border-color: #d6e9c6;
            }

        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <?php
        if ($success) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success !</strong> Product updated Successfully.
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
        <a href="listProduct.php"><button type="button" class="btn btn-info">List Product</button></a>
        <h3 class="mt-3">Edit Product</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" id="name">
            </div>
            <div class="mb-3">
                <label class="form-label" for="category_id">Product Category</label>
                <select class="form-select" name="category_id" id="category_id">
                    <?php
                    $result = mysqli_query($conn, "select * from category");
                    while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                        <option value="<?php echo $row1['id']; ?>" <?php print ($row1['id'] == $row['category_id']) ? "selected" : "" ?>><?php echo $row1['name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Product Price</label>
                <input type="text" class="form-control" name="price" value="<?php echo $row['price']; ?>" id="price">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <div class="fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview" data-trigger="fileinput" style="width: 200px; height:150px;">
                        <img src="../assets/img/<?php echo $row['image']; ?>" alt="">
                    </div>
                    <span class="btn btn-primary  btn-file">
                        <span class="fileinput-new">Select</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" id="image" value="<?php echo $row['image']; ?>" name="image">
                    </span>
                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>