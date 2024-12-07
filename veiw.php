<?php
include 'db.php';
$id = $_GET['id'];

// Fetch student details
$query = "SELECT student.*, classes.name AS class_name FROM student
          LEFT JOIN classes ON student.class_id = classes.class_id
          WHERE student.id = $id";
$result = $conn->query($query);
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
</head>
<body>
    <h1><?= $student['name']; ?></h1>
    <p>Email: <?= $student['email']; ?></p>
    <p>Address: <?= $student['address']; ?></p>
    <p>Class: <?= $student['class_name']; ?></p>
    <p>Image:
        <?php if ($student['image']): ?>
            <img src="uploads/<?= $student['image']; ?>" alt="Image" width="100">
        <?php endif; ?>
    </p>
    <p>Created At: <?= $student['created_at']; ?></p>
    <a href="index.php">Back</a>
</body>
</html>
