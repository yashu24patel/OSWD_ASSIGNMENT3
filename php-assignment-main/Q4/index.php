<?php
$directory = 'C:\xampp\htdocs\PHP\Assignment';

if (is_dir($directory)) {
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo $file . "<br>";
        }
    }
} else {
    echo "Directory not found.";
}
?>
