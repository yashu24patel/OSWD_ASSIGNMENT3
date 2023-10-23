<?php
include("../connection/dbconnect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="container">
        <h3>Category</h3>
        <a class="nav-link" href="../logout.php">Logout</a>
        <div class="d-flax row">
            <div class="col-md-4">
                <table id="datatable2" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Categories</th>
                        </tr>
                        
                    </thead>
                    <tbody>


                        <?php
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            $name = $row["name"];
                        ?>
                            <tr>
                                <td><a href="index.php?cat_id=<?php echo $id; ?>"><?php echo $name; ?></a></td>
                            </tr>

                        <?php
                        }

                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['cat_id'])) {
                            $cat_id = $_GET['cat_id'];
                            $sql = "SELECT products.*,product_images.image FROM products LEFT JOIN product_images ON products.id=product_images.product_id WHERE category_id='" . $cat_id . "'";
                        } else {
                            $sql = "SELECT products.*,product_images.image FROM products LEFT JOIN product_images ON products.id=product_images.product_id";
                        }
                        $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            $name = $row["name"];
                            $product_images = $row["image"];
                            $price = $row["price"];
                        ?>
                            <tr>
                                <td><img src="../assets/img/<?php echo $product_images; ?>" alt="image" width="50" height="50"></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $price; ?></td>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#datatable').dataTable();

            $('#datatable2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });

            $('#datatable3').DataTable({
                "scrollY": "400px",
                "scrollCollapse": true,
                "paging": false
            });

            $('.edit').click(function() {
                $(this).addClass('editMode');
            });

            // Save data
            $(".edit").focusout(function() {
                $(this).removeClass("editMode");

            });


        });
    </script>
</body>

</html>