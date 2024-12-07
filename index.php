<?php
include 'db.php';

// Fetch students with their class names using JOIN
$query = "SELECT student.id, student.name, student.email, student.created_at, classes.name AS class_name, student.image
          FROM student
          LEFT JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Students</h1>
        <a href="create.php" class="btn btn-primary">Add Student</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['class_name']; ?></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="uploads/<?= $row['image']; ?>" alt="Image" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="view.php?id=<?= $row['id']; ?>" class="btn btn-info">View</a>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
