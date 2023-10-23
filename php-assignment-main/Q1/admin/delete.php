<?php
include('../connection/dbconnect.php');
$tbl_name = $_GET['tbl'];
$id = $_GET['id'];


$sql = mysqli_query($conn,"DELETE FROM $tbl_name WHERE id=$id");

switch ($tbl_name) {
	case 'category':
		echo '<script>window.location="listCategory.php"</script>';
	case 'product':
		echo '<script>window.location="listProduct.php"</script>';
	default:
		echo $sql;
		break;
}

?>