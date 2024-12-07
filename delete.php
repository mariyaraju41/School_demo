<?php
include 'db.php';
$id = $_GET['id'];

// Fetch student image to delete
$query = "SELECT image FROM student WHERE id = $id";
$image = $conn->query($query)->fetch_assoc()['image'];

// Delete image file
if ($image && file_exists("uploads/$image")) {
    unlink("uploads/$image");
}

// Delete student
$conn->query("DELETE FROM student WHERE id = $id");
header('Location: index.php');
?>
