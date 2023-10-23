<?php 
$conn = mysqli_connect("localhost","root","nayan","assignment") or die("Connection Failed");

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><students></students>');

    while ($row = $result->fetch_assoc()) {
        $student = $xml->addChild('student');
        $student->addChild('id', $row['id']);
        $student->addChild('name', $row['name']);
        $student->addChild('email', $row['email']);
        $student->addChild('contact', $row['contact']);
    }

    $xml->asXML('students.xml');
} else {
    echo "No data found in the MySQL table.";
}

$conn->close();
echo "Data exported to students.xml successfully!";

?>