<?php
session_start();
include('../connection/dbconnect.php');
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('../login.php','_self')</script>";
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">

        <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>

    <body>
        <?php require './componets/nav.php' ?>
        <div class="container">
            <h3>Product</h3>
            <a href="addProduct.php"><button type="button" class="btn btn-info">Add New Product</button></a>
            <table id="datatable2" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT products.*,product_images.image,category.name as category_name FROM products LEFT JOIN category ON products.category_id=category.id LEFT JOIN product_images ON products.id=product_images.product_id";
                    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row["id"];
                        $name = $row["name"];
                        $product_images = $row["image"];
                        $price = $row["price"];
                        $category_name = $row["category_name"];
                    ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><img src="../assets/img/<?php echo $product_images; ?>" alt="image" width="50" height="50"></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $category_name; ?></td>
                            <td>
                                <a class="btn btn-info" href="edit-product.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a class="btn btn-danger" href="delete.php?tbl=product&id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
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
<?php } ?>