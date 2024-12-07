<?php
include 'db.php';
$id = $_GET['id'];

// Fetch student data
$query = "SELECT * FROM student WHERE id = $id";
$student = $conn->query($query)->fetch_assoc();

// Fetch classes
$class_result = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];

    // Handle image upload
    if ($image) {
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $student['image'];
    }

    // Update database
    $query = "UPDATE student SET name='$name', email='$email', address='$address', class_id=$class_id, image='$image' WHERE id=$id";
    $conn->query($query);

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= $student['name']; ?>" required>
        <input type="email" name="email" value="<?= $student['email']; ?>">
        <textarea name="address"><?= $student['address']; ?></textarea>
        <select name="class_id">
            <?php while ($class = $class_result->fetch_assoc()): ?>
                <option value="<?= $class['class_id']; ?>" <?= $class['class_id'] == $student['class_id'] ? 'selected' : ''; ?>>
                    <?= $class['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" accept=".jpg, .png">
        <button type="submit">Update Student</button>
    </form>
</body>
</html>
